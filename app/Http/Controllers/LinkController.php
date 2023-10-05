<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = Link::where('user_id', Auth::user()->id)->get();

        if ($links->isEmpty()) {
            return response()->json([], 204);
        }

        return response()->json($links);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'destination' => 'required|max:400',
            'short_link' => 'required|max:255|unique:links', 
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $link = new Link();
        $link->user_id = Auth::user()->id;
        $link->title = $request->title;
        $link->destination = $request->destination;
        $link->short_link = $request->short_link;
        $link->save();

        return response()->json($link, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $link = Link::where('user_id', Auth::user()->id)->where('id', $id)->first();

        if (!$link) {
            return response()->json(['error' => 'Link not found'], 404);
        }

        return response()->json($link);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {   
        // Check if the link exists 
        $link = Link::where('user_id', Auth::user()->id)->where('id', $id)->first();

        if (!$link) {
            return response()->json(['error' => 'Link not found'], 404);
        }

        // Validate data
        $rules = [
            'title' => 'max:255|min:1',
            'destination' => 'max:400|min:1',
            'short_link' => 'max:255|unique:links|min:1', 
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $link->update($request->all());

        $updatedLink = Link::find($id);

        return response()->json($updatedLink, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $link = Link::where('user_id', Auth::user()->id)->where('id', $id)->first();

        if (!$link) {
            return response()->json(['error' => 'Link not found'], 404);
        }

        $link->delete();

        return response()->json([], 204);
    }

}
