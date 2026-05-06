<?php

namespace App\Http\Controllers;

use App\Models\ResponseProgress;
use Illuminate\Http\Request;
use App\Models\Response;


class ResponseProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, $id) {
        $response = Response::where('report_id', $id)->first();

        $validated = $request->validate([
            'response_progress' => 'required|string|max:1000'
        ]);

        $responseProgress = ResponseProgress::firstOrNew([
            'response_id' => $response->id
        ]);

        $histories = $responseProgress->histories ?? [];
        $histories[] = [
            'response_progress' => $validated['response_progress'],
            'created_at' => now()->toDateTimeString()
        ];

        $responseProgress->histories = $histories;
        $responseProgress->save();

        return redirect()->back()->with('success', 'Progress berhasil ditambahkan');
        // Validate data received
    }


    /**
     * Display the specified resource.
     */
    public function show(ResponseProgress $responseProgress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResponseProgress $response_progress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ResponseProgress $responseProgress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResponseProgress $responseProgress)
    {
        //
    }
}
