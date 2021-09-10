<?php
namespace App\Traits;

use Illuminate\Http\Request;

trait Config
{
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
        $configs = $request->all();
        foreach ($configs as $config_name => $config_value) {
            $info = $this->model::find($config_name);
            if ($info) {
                $info->config_value = $config_value;
                $info->save();
            } else {
                $this->model::create(['config_name' => $config_name, 'config_value' => $config_value]);
            }
        }

        return response()->json(['status' => true]);
    }
}