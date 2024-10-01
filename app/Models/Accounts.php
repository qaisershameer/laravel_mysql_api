<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    use HasFactory;

    protected $table='accounts';
    protected $primaryKey ='acId';

    protected $fillable = [
        'acTitle', 'email', 'mobile', 'openingBal', 'CurrentBal', 'uId', 'currencyId', 'accTypeId', 'parentId', 'areaId'
    ];

}
