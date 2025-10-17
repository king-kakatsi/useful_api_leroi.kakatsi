<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShortLinkRequest;
use App\Models\ShortUrl;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = ShortUrl::all()->where('user_id',Auth::user()->id);
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
     * Redirects to the original link.
     */
    public function goToOriginal($code)
    {
        $link = ShortUrl::where('custom_code', $code)->first();
        $link->clicks += 1;
        $link->save();
        Redirect::to($link->original_url, 302);
        return response()->json($link,302);
    }

    /**
     * Remove the specified resource from storage.
    */
    public function destroy(ShortUrl $shortUrl)
    {
        try{
            if ($shortUrl->user_id === Auth::user()->id){
                $shortUrl->delete();
                return response()->json((object)[
                    'message' => "Link deleted successfully"
                ], 200);
            }
            return response()->json(404);
        } catch (Exception $ex){
            return response()->json(404);
        }
    }
}
