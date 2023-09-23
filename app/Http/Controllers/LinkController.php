<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Link::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $link = Link::create($request->all());

        return response()->json($link, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $link = Link::find($id);
        return response()->json($link);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $link = Link::find($id);

        $link->update($request->all());

        return response()->json($link);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $link = Link::find($id);
        $link->delete();
        return response()->json([], 204);
    }
}
