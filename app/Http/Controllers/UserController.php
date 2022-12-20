<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //member index page return
    public function index(){
        $admin_profile = Admin::findOrFail(1);
        $users = User::latest()->get();
        $roles = Role::where('status' , true)->latest()->get();
        return view('user.pages.user.index' , compact(['admin_profile' , 'users' , 'roles']));
    }
}
