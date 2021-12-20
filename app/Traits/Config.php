<?php
namespace App\Traits;

use Illuminate\Http\Request;

trait Config
{
    private $auth_url_list = ['link_youtube', 'link_facebook', 'link_instagram', 'link_line'];

    public function index()
    {
        return view($this->service_name . '.index');
    }

    public function get(Request $request)
    {
        return response()->json(['status' => true, 'data' => $this->model::all()]);
    }

    public function set(Request $request)
    {
        $error = false;
        $error_message = '';
        $configs = $request->all();
        foreach ($configs as $config_name => $config_value) {

            if ($config_value && $config_name === 'basic_email' && !filter_var($config_value, FILTER_VALIDATE_EMAIL)) {
                $error = true;
                $error_message = '電子郵件格式錯誤';
                break;
            }

            # 外部連結驗證
            if ($config_value && in_array($config_name, $this->auth_url_list) && !filter_var($config_value, FILTER_VALIDATE_URL)) {
                $error = true;
                $error_message = substr($config_name, 5) . ' 不是正確連結';
                break;
            }

            $info = $this->model::find($config_name);
            if ($info) {
                $info->config_value = $config_value;
                $info->save();
            } else {
                $this->model::create(['config_name' => $config_name, 'config_value' => $config_value]);
            }
        }

        if ($error) {
            return response()->json(['status' => false, 'message' => $error_message]);
        }

        return response()->json(['status' => true]);
    }
}
