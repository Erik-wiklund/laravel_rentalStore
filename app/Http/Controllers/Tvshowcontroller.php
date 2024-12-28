<?php

namespace App\Http\Controllers;

use App\Models\TVShow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Laravel\Facades\Image;

class Tvshowcontroller extends Controller
{
    public function index()
    {
        $tvshows = TVShow::latest()->paginate(20);

        return view('admin.pages.tvshows', compact(['tvshows']));
    }

    public function edit(string $tvshowId)
    {
        $tvshow = TVShow::find($tvshowId);
        return view('admin.pages.edit_tvshows', compact(['tvshow']));
    }

    public function update(Request $request, string $tvshowId)
    {
        $image = '';
        $imageFileName = '';
        $newImageFileName = '';

        // Validate the incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'featured' => 'nullable|boolean',
            'order' => 'nullable|integer',
            'desc' => 'nullable|string',
        ]);

        // Handle image upload if present
        if ($request->image) {
            $image = $request->image;
            $imageFileName = $image->getClientOriginalName();
            $newImageFileName = time() . $imageFileName;

            // Move the uploaded image to the public/images folder with the new filename
            $imagePath = public_path('images/' . $newImageFileName);
            $request->image->move(public_path('images'), $newImageFileName);

            // Resize the image to fit within a 300x300 pixel box
            Image::make($imagePath)->fit(300, 300)->save($imagePath);
        }

        $tvshow = TVShow::find($tvshowId);

        // Update the TV show attributes
        if ($request->filled('title')) {
            $tvshow->name = $request->title;
        }
        if ($request->filled('desc')) {
            $tvshow->description = $request->desc;
        }
        if ($request->filled('order')) {
            $tvshow->order = $request->order;
        }

        // If 'featured' is checked, set it to true, else false
        $tvshow->featured = $request->has('featured') ? true : false;

        if ($request->image) {
            $tvshow->image = $newImageFileName;
        }

        $request = request()->merge([
            'user_id' => auth()->check() ? auth()->user()->id : null,
            'resource_type' => 'tvshow',
            'resource_id' => $tvshowId,
            'context' => 'editTVShow',
            'message' => "TVShow Updated successfully successfully.",
        ]);

        app(AdminLogsController::class)->store($request);

        $tvshow->save();

        Session::flash('message', 'TV-Show updated successfully');
        Session::flash('alert-class', 'alert-success');

        return redirect()->route('tvshows');
    }

    public function show(string $tvshowId)
    {
        $tvshow = TVShow::find($tvshowId);
        return view('admin.pages.show_tvshow', compact(['tvshow']));
    }
}
