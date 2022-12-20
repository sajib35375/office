<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityReply;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function adminDash(){
        // Community post send
        $communities = Community::where('status' , true)->latest()->take(2)->select(['id','title','description'])->with('replies')->get();
        // Total User
        $user_count = User::count();
        // File Count
        $files = File::count();
        // Community Count
        $community_count = Community::where('status' , true)->count();
        // Reply Count
        $reply_count = CommunityReply::count();
        // Recent File Tickets
        // $file = File::latest()->take(5)->with('replies')->get();
        return view('admin.pages.home.index' , compact(['communities' , 'user_count' , 'files' , 'community_count' , 'reply_count']));
    }


    protected function guard()
    {
        return Auth::guard('admin');
    }
}
