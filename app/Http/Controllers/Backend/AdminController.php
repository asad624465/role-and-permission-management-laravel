<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
class AdminController extends Controller
{
    /*=================================================================================================
                                        Display user list
    =================================================================================================*/
    public function index()
    {
        $users = Admin::all();
        return view('backend.pages.admins.index',compact('users'));
    }
    /*=================================================================================================
                                        Create new user form 
    =================================================================================================*/
    public function create()
    {
        $roles = Role::all();
        return view('backend.pages.admins.create',compact('roles'));
    }
    /*=================================================================================================
                                        Save new user
    =================================================================================================*/
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required|min:8|max:12',
        ]);
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        if ($request->role) {
            $user->assignRole($request->role);
        }
        return redirect('users')->with('success', 'Admin created successfully.');
    }
    public function show($id)
    {
        //
    }
    /*=================================================================================================
                                        Edit user by id
    =================================================================================================*/
    public function edit($id)
    {
        $userdata = Admin::findOrFail($id);
        $roles = Role::all();
        return view('backend.pages.admins.edit',compact('userdata','roles'));
    }
    /*=================================================================================================
                                        Update User
    =================================================================================================*/
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|unique:users,email,'.$id,
            'password'=>'nullable|min:8|max:12'

        ]);
        $user = Admin::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->email = $request->email;
        if ($request->password) {
            bcrypt($request->password);
        }
        $user->roles()->detach();
        if ($request->role) {
            $user->assignRole($request->role);
        }
        $user->save();
        return redirect('users')->with('success', 'Admin created successfully.');
    }
    /*=================================================================================================
                                        Delete user
    =================================================================================================*/
    public function destroy($id)
    {
        $user = Admin::findOrFail($id);
        if(!is_null($user)){
            $user->delete();
        }
        session()->flash('success', 'Admin has been deleted !!');
        return back(); 
    }
}
