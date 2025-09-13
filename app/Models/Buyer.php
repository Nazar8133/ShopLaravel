<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use App\Notifications\BuyerResetPasswordNotification;
use App\Notifications\BuyerVerifyEmailNotification;

class Buyer extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use Notifiable, CanResetPasswordTrait;
    protected $primaryKey='idBuyer';
    protected $fillable = [
        'pib', 'number', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new BuyerResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new BuyerVerifyEmailNotification());
    }
}
