<?php

namespace App\Models;
use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'uni_number',
        'name',
        'year',
        // 'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        // 'pivot',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i'),
        );
    }

    public function programs(){
        return $this->belongsToMany(User::class,'studentsubjects','user_id','program_id')->withTimestamps();

    }
    // public function userAttendance(){
    //     return $this->hasMany()
    // }


}
