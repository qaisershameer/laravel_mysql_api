<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccParent extends Model
{
    use HasFactory;

    protected $table='accparent';
    protected $primaryKey ='parentId';    

    protected $fillable = [
        'accParentTitle', 'accTypeId', 'uId'
    ];

}
