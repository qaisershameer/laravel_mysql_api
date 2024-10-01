<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccType extends Model
{
    use HasFactory;

    protected $table='acctype';
    protected $primaryKey ='accTypeId';

    protected $fillable = [
        'accTypeTitle', 'uId'
    ];

}
