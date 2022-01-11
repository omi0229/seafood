<?php
namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\Config;

trait MailConfig
{
    # 簽名檔資料
    public function getConfig()
    {
        return Config::select(['config_name', 'config_value'])->where(function ($query) {
            $query->where('config_name', 'basic_email');
            $query->orWhere('config_name', 'basic_phone');
            $query->orWhere('config_name', 'basic_company');
            $query->orWhere('config_name', 'basic_admin_notification');
        })->get();
    }

    # 密件副本
    public function getBccList(): array
    {
        $notification_list = [];
        $basic_admin_notification = $this->getConfig()->where('config_name', 'basic_admin_notification')->first();
        if ($basic_admin_notification) {
            foreach (explode(',', $basic_admin_notification->config_value) as $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($notification_list, $email);
                }
            }
        }

        return $notification_list;
    }
}
