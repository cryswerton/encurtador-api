<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LinkController extends Controller
{

    public function index()
    {
        $links = Link::where('user_id', Auth::user()->id)->get();

        if ($links->isEmpty()) {
            return response()->json([], 204);
        }

        return response()->json($links);
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:255|unique:links',
            'destination' => 'required|max:400', 
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $slug = Str::slug($request->title);

        $link = new Link();
        $link->user_id = Auth::user()->id;
        $link->title = $request->title;
        $link->slug = $slug;
        $link->clicks = 0;
        $link->destination = $request->destination;
        $link->short_link = env('APP_URL') . '/' . $slug;
        $link->save();

        return response()->json($link, 201);
    }

    public function show($id)
    {
        $link = Link::where('user_id', Auth::user()->id)->where('id', $id)->first();

        if (!$link) {
            return response()->json(['error' => 'Link not found'], 404);
        }

        return response()->json($link);
    }

    public function update(Request $request, $id)
    {   
        // Check if the link exists 
        $link = Link::where('user_id', Auth::user()->id)->where('id', $id)->first();

        if (!$link) {
            return response()->json(['error' => 'Link not found'], 404);
        }

        // Validate data
        $rules = [
            'title' => 'max:255|unique:links|min:1',
            'destination' => 'max:400|min:1',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $link->update($request->all());

        return response()->json($link->refresh(), 200);
    }

    public function destroy($id)
    {
        $link = Link::where('user_id', Auth::user()->id)->where('id', $id)->first();

        if (!$link) {
            return response()->json(['error' => 'Link not found'], 404);
        }

        $link->delete();

        return response()->json([], 204);
    }

    public function reset($id)
    {
        $link = Link::where('user_id', Auth::user()->id)->where('id', $id)->first();

        if (!$link) {
            return response()->json(['error' => 'Link not found'], 404);
        }

        $link->clicks = 0;
        $link->save();

        return response()->json([], 200);
    }

}
