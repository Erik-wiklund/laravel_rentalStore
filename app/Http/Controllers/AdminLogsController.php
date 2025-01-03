<?php

namespace App\Http\Controllers;

use App\Models\AdminLog;
use Illuminate\Http\Request;

class AdminLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $adminLogs = AdminLog::latest()->paginate(20);
        return view('admin.logs.index', ['adminLogs' => $adminLogs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Define context descriptions
        $contextDescriptions = [
            'forum' => 'Forum Ban',
            'unbanForum' => 'Remove Forum Ban',
            'addMovie' => 'Add movie',
            'addTVShow' => 'Add TV Show',
            'editTVShow' => 'Edit TV Show'
        ];

        // Determine the context based on the 'context' input
        $context = $request->input('context');
        $actionDescription = $contextDescriptions[$context] ?? 'Unknown Action';

        // Log the action with the determined context
        AdminLog::create([
            'user_id' => $request->user_id,
            'action' => $actionDescription,
            'resource_type' => $request->resource_type,
            'resource_id' => $request->resource_id,
        ]);

        return redirect()->route('logs.index');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
