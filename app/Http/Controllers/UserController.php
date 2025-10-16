<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Register a user if data is valid
     */
    public function register(UserRegistrationRequest $request){
        try{
            
            $validatedFields = $request->validated();
            return response()->json(['data' => $validatedFields], 201);

        } catch(Exception $ex){
            $validatedFields = $request->validated();
            return response()->json([$ex, $validatedFields], 401);
        }
    }


    /**
     * Login a user if data is valid
     */
    public function login(){
        return response()->json(['test' => 'succeed'], 201);
    }


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
    public function store(Request $request)
    {
        //
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
