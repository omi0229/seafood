<?php


namespace App\Services;

use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ForgetPasswordLog;
use App\Services\General;
use App\Services\SmsServices;

class MemberServices
{
    protected $request, $sms_services;

    public function __construct(Request $request, SmsServices $sms_services)
    {
        $this->request = $request;
        $this->sms_services = $sms_services;
    }

    static $model = 'App\Models\Member';

    static function authInputData($inputs, $type = 'create')
    {
        if ($type === 'create') {
            $auth = [
                'cellphone' => 'required',
                'password' => 'required',
                'name' => 'required',
            ];
            $tip = [
                'cellphone.required' => '請填寫手機號碼',
                'password.required' => '請填寫密碼',
                'name.required' => '請填寫真實名字',
            ];
        } else {
            $auth = [
                'name' => 'required'
            ];
            $tip = [
                'name.required' => '請填寫真實名字'
            ];
        }

        $validator = Validator::make($inputs, $auth, $tip);
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()->first()];
        }

        if ($type === 'create' && !self::authCellphone($inputs['cellphone'])) {
            return ['status' => false, 'message' => '已有重複手機號碼資料'];
        }

        return ['status' => true ];
    }

    # true => 此電話無人註冊, false => 已有人註冊
    static function authCellphone($cellphone): bool
    {
        $model = app()->make(self::$model)->where('cellphone', $cellphone);
        return !($model->count() > 0);
    }

    public function authPassword($id, $password)
    {
        $model = app()->make(self::$model);
        $member = $model::where('id', $model::decodeSlug($id))->where('active', 1)->first();
        $validCredentials = \Hash::check($password, optional($member)->getAuthPassword());

        # 密碼錯誤
        if (!$validCredentials) {
            return false;
        }

        return true;
    }

    public function authLogin()
    {
        $credentials = $this->request->only('cellphone', 'password');

        $auth = [
            'cellphone' => 'required|string',
            'password' => 'required|string',
        ];

        $tip = [
            'cellphone.required' => '請輸入帳號 (手機號碼)',
            'password.required' => '請輸入密碼',
        ];

        $validator = Validator::make($credentials, $auth, $tip);
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()->first()];
        }

        if (app()->make(self::$model)::where('cellphone', $credentials['cellphone'])->where('active', 0)->count() > 0) {
            return ['status' => false, 'message' => '此帳戶已停用'];
        }

        $member = app()->make(self::$model)::where('cellphone', $credentials['cellphone'])->where('active', 1)->first();
        $validCredentials = \Hash::check($credentials['password'], optional($member)->getAuthPassword());

        if (!$validCredentials) {
            return ['status' => false, 'message' => '帳號或密碼錯誤'];
        }

        return ['status' => true, 'message' => '登入成功', 'member' => $member];
    }

    public function forgetPassword()
    {
        $inputs = $this->request->all();
        if (isset($inputs['cellphone']) && isset($inputs['name'])) {
            $model = app()->make(self::$model)::where('cellphone', $inputs['cellphone'])->where('name', $inputs['name']);
            if ($model->count() > 0) {
                $log = ForgetPasswordLog::where('cellphone', $inputs['cellphone'])->orWhere('ip', $this->request->ip())->orderBy('created_at', 'DESC');
                if ($log->count() > 0) {
                    $log_delay = clone $log;
                    $seconds = Carbon::parse($log_delay->first()->created_at)->addSeconds(env('SMS_CODE_DELAY', 60))->timestamp - now()->timestamp;
                    if ($seconds > 0) {
                        return ['status' => false, 'message' => '發送間隔過短', 'data' => $seconds];
                    }
                }

                $log->delete();
                ForgetPasswordLog::create(['cellphone' => $inputs['cellphone'], 'ip' => $this->request->ip()]);

                # 取得隨機八碼密碼
                $new_password = General::randomPassword();
                # 發送提示密碼簡訊
                $result = $this->sms_services->send([$inputs['cellphone']], $new_password, 'forget_password');
                if ($result['status'] == 0) {
                    # 修改成取得的八碼密碼
                    $model->first()->update(['password' => $new_password]);
                    return ['status' => true, 'message' => '已寄發簡訊'];
                }

                return ['status' => false, 'message' => '簡訊寄發失敗'];
            }

            return ['status' => false, 'message' => '無此會員資料', 'data' => $this->request->ip()];
        }

        return ['status' => false, 'message' => '輸入資料錯誤'];
    }

    public function exportMembers()
    {
        $model = app()->make(self::$model);

        $xls = '<table>';

        $xls .= '<tr>
            <th><span>手機號碼(帳號)</span></th>
            <th><span>姓名</span></th>
            <th><span>電子郵件</span></th>
            <th><span>市內電話</span></th>
            <th><span>郵遞區號</span></th>
            <th><span>城市</span></th>
            <th><span>地區</span></th>
            <th><span>地址</span></th>
        </tr>';

        foreach ($model->all() as $row) {
            $xls .= '<tr>
                <td>' . $row['cellphone'] . '&zwnj;' . '</td>
                <td>' . $row['name'] . '</td>
                <td>' . $row['email'] . '</td>
                <td>' . $row['telephone'] . '&zwnj;' . '</td>
                <td>' . $row['zipcode'] . '&zwnj;' . '</td>
                <td>' . $row['country'] . '</td>
                <td>' . $row['city'] . '</td>
                <td>' . $row['address'] . '</td>
            </tr>';
        }

        $xls .= '</table>';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="members.xls"');
        header('Cache-Control: max-age=0');

        return $xls;
    }
}
