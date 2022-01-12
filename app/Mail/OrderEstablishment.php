<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Traits\MailConfig;
use App\Models\Orders;

class OrderEstablishment extends Mailable
{
    use Queueable, SerializesModels, MailConfig;

    protected $order, $config;

    /**
     * Create a new message instance.
     *
     * @param Orders $order
     */
    public function __construct(Orders $order)
    {
        $this->order = $order->load(['member', 'order_products', 'order_products.product', 'order_products.product_specifications', 'discount_record', 'discount_record.discount_codes', 'discount_record.coupon']);
        $this->config = $this->getConfig();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): OrderEstablishment
    {
        return $this->view('email.order_establishment')
            ->subject(env('SENDER_NAME') . ' - 訂單成立')
            ->bcc($this->getBccList()) # 密件副本
            ->with([
                'order' => $this->order,
                'config' => $this->config, # 簽名檔資料
            ]);
    }
}
