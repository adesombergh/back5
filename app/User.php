<?php

namespace App;

use Illuminate\Notifications\Notifiable;
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
        'name', 'password','username','roles'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];
  
    public function roles()
    {
        return $this->belongsToMany('\App\Role');
    }
  
    public function hasAccess()
    {
       return $this->hasOneOfThisRoles(['boss','gerant','respo'])?true:abort(401,"You don't have the right!!!");
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    public function hasOneOfThisRoles($roles)
    {
        foreach ($roles as $role) {
            if ($this->roles()->where('name', $role)->first()) {
                return true;
            }
        }
        return false;
    }

}
