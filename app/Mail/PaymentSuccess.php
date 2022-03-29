<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Traits\MailConfig;
use App\Models\Orders;

class PaymentSuccess extends Mailable
{
    use Queueable, SerializesModels, MailConfig;

    protected $order, $config;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Orders $order)
    {
        $this->order = $order->load(['order_products', 'discount_record', 'discount_record.discount_codes', 'discount_record.coupon']);
        $this->config = $this->getConfig();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): PaymentSuccess
    {
        $payment_status_message = '失敗';
        if ($this->order && $this->order->payment_status && $this->order->payment_status === 1) {
            $payment_status_message = '成功';
        }

        return $this->view('email.payment_success')
            ->subject(env('SENDER_NAME') . ' - 訂單付款' . $payment_status_message)
            ->bcc($this->getBccList()) # 密件副本
            ->with([
                'order' => $this->order,
                'config' => $this->config, # 簽名檔資料
            ]);
    }
}
