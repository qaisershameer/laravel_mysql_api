<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class account extends Model
{
    use HasFactory;

    protected $fillable = [
        'acTitle', 'email', 'mobile', 'openingBal', 'CurrentBal', 'uId', 'currencyId', 'accTypeId', 'parentId', 'areaId'
    ];

}
