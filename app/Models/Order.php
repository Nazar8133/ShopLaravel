<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey='idOrder';

    protected $fillable = [
        'numberOrder',
        'idBuyer',
        'watches',
        'delivery',
        'idPayment',
        'payment',
        'paymentStatus',
        'koment',
        'idPromoCode',
        'orderStatus',
    ];
}
