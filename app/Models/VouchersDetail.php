<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class voucherdata extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucherId', 'uId', 'acId', 'remarksDetail', 'debit', 'credit', 'debitSR', 'creditSR'
    ];

}
