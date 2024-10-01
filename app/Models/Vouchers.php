<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vouchers extends Model
{
    use HasFactory;

    protected $table='vouchers';
    protected $primaryKey ='voucherId';

    protected $fillable = [
        'voucherDate', 'voucherPrefix', 'remarksMaster', 'sumDebit', 'sumCredit', 'sumDebitSR', 'sumCreditSR', 'uId'
    ];
        
}
