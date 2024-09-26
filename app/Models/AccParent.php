<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accparent extends Model
{
    use HasFactory;

    protected $fillable = [
        'accParentTitle', 'uId'
    ];

}
