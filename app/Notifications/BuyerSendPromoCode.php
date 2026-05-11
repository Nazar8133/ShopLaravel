<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BuyerSendPromoCode extends Notification
{
    use Queueable;

    public string $promoCode;
    public int $discountValue;
    public string $dateStart;
    public string $dateEnd;
    /**
     * Create a new notification instance.
     */
    public function __construct(string $promoCode, int $discountValue, string $dateStart, string $dateEnd)
    {
        $this->promoCode=$promoCode;
        $this->discountValue=$discountValue;
        $this->dateStart=$dateStart;
        $this->dateEnd=$dateEnd;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Безкоштовний промокод!')
            ->view('user.emailNotification.sendPromoCode', [
                'promoCode'=>$this->promoCode,
                'discountValue'=>$this->discountValue,
                'dateStart'=>$this->dateStart,
                'dateEnd'=>$this->dateEnd
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
