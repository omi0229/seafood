<?php


namespace App\Services;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MemberServices
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
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
                'id' => 'required',
                'name' => 'required'
            ];
            $tip = [
                'id.required' => 'id驗證失敗',
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

    static function authCellphone($cellphone)
    {
        $model = app()->make(self::$model)->where('cellphone', $cellphone);
        if ($model->count() > 0) {
            return false;
        }

        return true;
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
