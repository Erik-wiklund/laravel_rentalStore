<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
   public function home()
   {
      $users = User::latest()->paginate(20);
      return view('admin.pages.home', compact(['users']));
   }
}
