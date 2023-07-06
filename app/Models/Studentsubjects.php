<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studentsubjects extends Model
{
    use HasFactory;
    
    protected $table='studentsubjects';

    // protected $guarded=[];
    protected $fillable = [
       'program_id',
       'user_id',
       'is_attended',
    ];
    
}
