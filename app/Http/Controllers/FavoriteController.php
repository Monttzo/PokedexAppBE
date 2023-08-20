<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $favorite = Favorite::all();
        return response()->json([
            'success' => true,
            'response' => $favorite
        ],201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $favorite = new Favorite();
        $favorite->user_id = $request->user_id;
        $favorite->ref_api = $request->ref_api;

        $favorite->save();

        return response()->json([
            'success' => true,
            'response' => $favorite
        ],201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $favorite = Favorite::findOrFail($request->id);
            $favorite->user_id = $request->user_id;
            $favorite->ref_api = $request->ref_api;

            $favorite->save();
            return response()->json([
                'success' => true,
                'response' => $favorite
            ],201);
        } catch(Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e
            ],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $favorite = Favorite::destroy($request->id);
        return response()->json([
            'success' => true,
            'response' => $favorite
        ],201);
    }
    /**
     * Returns all the Favorites that a user has
     */
    public function myFavs(){
        $user = auth()->user();
        return response()->json([
            'success' => true,
            'response' => $user->favorites
        ],201);
    }
}
