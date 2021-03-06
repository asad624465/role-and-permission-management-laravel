<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
class UserController extends Controller
{
    public $user;
    public function __construct(){
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    /*=================================================================================================
                                        Display user list
    =================================================================================================*/
    public function index()
    {
        /*if(is_null($this->user) || !$this->user->can('role.view')){
            abort('403','Unauthorized access');
        }*/
        $users = User::all();
        return view('backend.pages.users.index',compact('users'));
    }
    /*=================================================================================================
                                        Create new user form 
    =================================================================================================*/
    public function create()
    {
        if(is_null($this->user) || !$this->user->can('role.add')){
            abort('403','Unauthorized access');
        }
        $roles = Role::all();
        return view('backend.pages.users.create',compact('roles'));
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
        return redirect('users')->with('success', 'User created successfully.');
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
        if(is_null($this->user) || !$this->user->can('role.edit')){
            abort('403','Unauthorized access');
        }
        $userdata = User::findOrFail($id);
        $roles = Role::all();
        return view('backend.pages.users.edit',compact('userdata','roles'));
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
        $user = User::find($id);
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
        return redirect('users')->with('success', 'User created successfully.');
    }
    /*=================================================================================================
                                        Delete user
    =================================================================================================*/
    public function destroy($id)
    {
        if(is_null($this->user) || !$this->user->can('role.delete')){
            abort('403','Unauthorized access');
        }
        $user = User::findOrFail($id);
        if(!is_null($user)){
            $user->delete();
        }
        session()->flash('success', 'User has been deleted !!');
        return back(); 
    }
}
