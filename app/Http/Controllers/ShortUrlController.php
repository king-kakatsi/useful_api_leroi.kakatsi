<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShortLinkRequest;
use App\Models\ShortUrl;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = ShortUrl::where('user_id',Auth::user()->id)->pluck('user_id')->toArray();
        return response()->json((object)[
            $links
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Stores a short url with the original one attached
     */
    public function store(StoreShortLinkRequest $request)
    {
        try{
            $validatedFields = $request->validated();
            $validatedFields['user_id'] = Auth::user()->id;
            $validatedFields['clicks'] = 0;

            if (!$validatedFields['custom_code']){
                $validatedFields['custom_code'] = Str::random(10);
                // TODO: check if this already exists in db
            }
            
            $link = ShortUrl::create($validatedFields);
            unset($link->updated_at);
            return response()->json($link, 201);

        } catch(Exception $ex){
            return response()->json((object)[
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ShortUrl $shortUrl)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShortUrl $shortUrl)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShortUrl $shortUrl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShortUrl $shortUrl)
    {
        //
    }
}
