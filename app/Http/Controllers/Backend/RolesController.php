<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('backend.pages.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        $permissionGroup = user::permissionGroup();
        return view('backend.pages.roles.create',compact('permissions','permissionGroup'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(["name"=>"required|max:100|unique:roles"]);
        $roles = Role::create(["name"=>$request->name]);
        $permissions = $request->permission;
        if(!empty($permissions)){
            $roles->syncPermissions($permissions);
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $role = Role::findById($id);
        $permissions = Permission::all();
        $permissionGroup = User::permissionGroup();
        return view('backend.pages.roles.edit',compact('role','permissions','permissionGroup'));
    }
    public function update(Request $request, $id)
    {
        $request->validate(["name"=>"required|max:100"]);
        $roles = Role::findById($id);
        $permissions = $request->permission;
        if(!empty($permissions)){
            $roles->syncPermissions($permissions);
        }
        return back(); 
    }
    public function destroy($id)
    {
        $role = Role::findById($id);
        if(!is_null($role)){
            $role->delete();
        }
        return back(); 
    }
}
