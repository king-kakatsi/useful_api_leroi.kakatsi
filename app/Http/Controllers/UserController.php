<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isArray;

class UserController extends Controller
{
    /**
     * Register a user if data is valid
     */
    public function register(UserRegistrationRequest $request){
        try{
            $validatedFields = $request->validated();
            $user = User::create($validatedFields);

            if ($user && $validatedFields &&
            isArray($validatedFields) &&
            Auth::attempt(['email' => $validatedFields['email'], 'password' => $validatedFields['password']])){

                $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
                return response()->json($user, 201);
            }

            return response()->json(['data' => $validatedFields], 201);

        } catch(Exception $ex){
            return response()->json(["exception" => $ex], 401);
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
