<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VouchersDetail extends Model
{
    use HasFactory;

    protected $table='vouchersdetail';
    protected $primaryKey ='voucherDtid';

    protected $fillable = [
        'voucherId', 'uId', 'acId', 'remarksDetail', 'debit', 'credit', 'debitSR', 'creditSR'
    ];

}
