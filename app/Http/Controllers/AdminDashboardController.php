<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
   public function home()
   {
      $users = User::latest()->paginate(20);
      $contactMessages = Contact::count();
      return view('admin.pages.home', compact(['users', 'contactMessages']));
   }
}
