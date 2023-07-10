<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    
    use HasFactory;

    // protected $hidden = [
    // // 'pivot'
    // ];
    
    protected $guarded=[];


    protected function day(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (int)$value,
        );
    }

    // protected function startTime(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i'),
    //     );
    // }
    //  protected function endTime(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i'),
    //     );
    // }
    public function users(){
        return $this->belongsToMany(User::class,'Studentsubjects')->withPivot('updated_at');
    }

    public function usersAttended(){
        return $this->users()->wherePivot('is_attended','=',true);
    }

    
    
}
