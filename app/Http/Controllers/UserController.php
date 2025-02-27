<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\Subscription;
use App\Models\User;
// use Intervention\Image\Facades\Image;
use App\Models\User_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(20);
        $subscriptions = Subscription::all();

        return view('admin.pages.users', compact(['users', 'subscriptions']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user_roles = User_role::all();
        return view('admin.pages.new_user', compact(['user_roles']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => 'required',
            'image' => 'image', // Add validation rule for the image upload
        ]);
        $manager = new ImageManager(new Driver());
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->password = Hash::make($request->password);

        if ($request->hasFile('image')) {
            // An image was uploaded
            // Generate a unique filename for the uploaded image
            $imageFileName = time() . '.' . $request->image->extension();

            // Move the uploaded image to the public/images folder with the generated filename
            $imagePath = public_path('images/' . $imageFileName);
            $request->image->move(public_path('images'), $imageFileName);
            $image = $manager->read($imagePath);
            $image->scale(width: 300, height: 300)->save($imagePath);

            $user->image = $imageFileName;
        } else {
            // No image was uploaded, use the default image
            $user->image = 'default_image.webp'; // Set to the default image filename
        }

        $user->save();

        Session::flash('message', 'User created successfully');
        Session::flash('alert-class', 'alert-success');
        return back();
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $userId)
    {
        $users = User::find($userId);
        $user_roles = User_role::all();
        return view('admin.pages.edit_user', compact(['users', 'user_roles']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $userId)
    {

        $user = User::find($userId);

        $request->validate([

            'email' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],

        ]);

        if ($request->has('password')) {
            // New password is provided, validate and update it
            $request->validate([
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
            $user->password = Hash::make($request->password);
        }

        $image = '';
        $imageFileName = '';
        $newImageFileName = '';

        if ($request->image) {
            $image = $request->image;
            $imageFileName = $image->getClientOriginalName();
            $newImageFileName = time() . $imageFileName;

            // Move the uploaded image to the public/images folder with the new filename
            $imagePath = public_path('images/' . $newImageFileName);
            $request->image->move(public_path('images'), $newImageFileName);
            $image->scale(width: 300, height: 300)->save($imagePath);

            $user->image = $imageFileName;
        }

        if ($request->name) {
            $user->name = $request->name;
        }
        if ($request->email) {
            $user->email = $request->email;
        }
        if ($request->image) {
            $user->image = $newImageFileName;
        }
        if ($request->role_id) {
            $user->role_id = $request->role_id;
        }
        // if ($request->has('password')) {
        //     $user->password = Hash::make($request->password);
        // }


        $user->save();
        Session::flash('message', 'User updated successfully');
        Session::flash('alert-class', 'alert-success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function add_forum_ban(Request $request, $userId)
    {
        $user = User::find($userId);

        // Get the selected ban duration
        $banDuration = $request->input('ban_duration');

        // Set the ban duration based on the selected option
        if ($banDuration === 'permanent') {
            // Permanent ban
            $user->is_permbanned = 1;
        } else {
            // Temporary ban
            $user->banned_until = now()->addDays($banDuration);
        }
        $user->save();

        $banDurationText = ($banDuration === 'permanent') ? 'Permanent' : "$banDuration days";

        $request = request()->merge([
            'user_id' => auth()->check() ? auth()->user()->id : null,
            'resource_type' => 'user',
            'resource_id' => $userId,
            'context' => 'forum',
            'message' => "Forum ban added successfully. Duration: $banDurationText",
        ]);

        app(AdminLogsController::class)->store($request);

        return redirect()->route('users')->with('success', 'Forum ban added successfully');
    }


    public function del_forum_ban($userId)
    {
        $user = User::find($userId);

        $user->banned_until = null;
        $user->is_permbanned = null;

        $user->save();
        $request = request()->merge(['user_id' => auth()->user()->id, 'resource_type' => 'user', 'resource_id' => $userId, 'context' => 'unbanForum']);
        app(AdminLogsController::class)->store($request);

        return redirect()->route('users')->with('success', 'Forum ban added successfully');
    }

    public function search(Request $request)
    {
        $query = $request->query('query');
        $users = User::where('username', 'like', $query . '%')->limit(5)->get();
        return response()->json(['users' => $users]);
    }

    public function show(string $userId)
    {
        $users = User::find($userId);
        $user_roles = User_role::all();
        return view('admin.pages.view_user', compact(['users', 'user_roles']));
    }
}
