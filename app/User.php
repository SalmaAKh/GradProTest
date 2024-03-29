<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $fillable = [
		'email',
		'name',
		'surname',
		'password',
		'remember_token'
	];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function instructor()
    {
        return $this->hasOne(\App\Instructor::class);
    }

    public function administrators()
    {
        return $this->hasOne(\App\Administrator::class);
    }

    public function isAdministrator()
    {
        return $this->administrators()->count()>0;
    }

    public function isInstructor()
    {
        return $this->instructor()->count()>0;
    }






}
