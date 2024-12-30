<?php

namespace App\Http\Controllers;

use App\Models\TVShow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

// create new manager instance with desired driver


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
        $manager = new ImageManager(new Driver());

        // Handle image upload if present
        if ($request->image) {
            $image = $request->image;
            $imageFileName = $image->getClientOriginalName();

            // Define the path where images will be stored
            $imagePath = public_path('images/' . $imageFileName);

            // Check if the image already exists, and if so, skip the upload
            if (file_exists($imagePath)) {
                // If the file already exists, just skip the upload and don't change the image
                $newImageFileName = $imageFileName;  // Keep the current image filename
            } else {
                // If the file does not exist, proceed with the upload
                $newImageFileName = time() . $imageFileName;  // Optional: keep the timestamp-based name
                $image->move(public_path('images'), $newImageFileName);

                // Process the image (resize, etc.)
                $image = $manager->read(public_path('images/' . $newImageFileName));
                $image->scale(width: 300, height: 300)->save(public_path('images/' . $newImageFileName));
            }
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

        // If a new image was uploaded, update the TV show image filename
        if ($request->image) {
            $tvshow->image = $newImageFileName;
        }

        // Log the changes
        $request = request()->merge([
            'user_id' => auth()->check() ? auth()->user()->id : null,
            'resource_type' => 'tvshow',
            'resource_id' => $tvshowId,
            'context' => 'editTVShow',
            'message' => "TVShow Updated successfully.",
        ]);

        app(AdminLogsController::class)->store($request);

        // Save the updated TV show
        $tvshow->save();

        // Flash message and redirect
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
