<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use DB;

class User extends Authenticatable
{
    use Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
    public static function permissionGroup()
    {
        $permission = DB::table('permissions')
                        ->select('group_name')
                        ->groupBy('group_name')->get();
        return $permission;
    }
    public static function roleHasPermissions($role,$permissions)
    {
        $haspermission=true;
        foreach ($permissions as $permission) {
            if(!$role->hasPermissionTo($permission->name)){
                $haspermission=false;
                return $haspermission;
            }
        }
        return $haspermission;
    }
    public static function permissionGroupById($group_name)
    {
        $permission = DB::table('permissions')
                        ->select('name')
                        ->where('group_name',$group_name)
                        ->get();
        return $permission;
    }
}
