<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isArray;

class UserController extends Controller
{
    /**
     * Register a user if data is valid
     */
    public function register(UserRegistrationRequest $request){
        try{
            $userInfos = $request->validated();
            $user = User::create($userInfos);

            if ($user && $userInfos &&
            isArray($userInfos) &&
            Auth::attempt(['email' => $userInfos['email'], 'password' => $userInfos['password']])){

                $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
                return response()->json($user, 201);
            }

            return response()->json(['data' => $userInfos], 201);

        } catch(Exception $ex){
            return response()->json([
                'message' => $ex->getMessage()
            ], 500);
        }
    }


    /**
     * Login a user if data is valid
     */
    public function login(UserLoginRequest $request){

        try{
         $loginUserData = $request->validated();
        $user = User::where('email',$loginUserData['email'])->first();

        if(!$user || !Hash::check($loginUserData['password'],$user->password)){

            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }

        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user_id' => $user->id,
        ], 200);

        } catch (Exception $ex){
            return response()->json([
                'message' => $ex->getMessage()
            ], 500);
        }
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
