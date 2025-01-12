<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subs = Subscription::all();
        return view('admin.pages.subscriptions.index', compact(['subs']));
    }
}
