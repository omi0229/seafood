<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Orders;
use App\Models\Config;

class OrderEstablishment extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new message instance.
     *
     * @param Orders $order
     */
    public function __construct(Orders $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): OrderEstablishment
    {
        $config = Config::select(['config_name', 'config_value'])->where(function ($query) {
            $query->where('config_name', 'basic_email');
            $query->orWhere('config_name', 'basic_phone');
            $query->orWhere('config_name', 'basic_company');
            $query->orWhere('config_name', 'basic_admin_notification');
        })->get();

        $notification_list = [];
        $basic_admin_notification = $config->where('config_name', 'basic_admin_notification')->first();
        if ($basic_admin_notification) {
            foreach (explode(',', $basic_admin_notification) as $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($notification_list, $email);
                }
            }
        }

        return $this->view('email.order_establishment')
            ->subject(env('SENDER_NAME') . ' - 訂單成立')
            ->bcc($notification_list)
            ->with([
                'order' => $this->order,
                'config' => $config,
            ]);
    }
}
