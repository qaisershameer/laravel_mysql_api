<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class acctype extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'accTypeTitle', 'uId'
    ];

}
