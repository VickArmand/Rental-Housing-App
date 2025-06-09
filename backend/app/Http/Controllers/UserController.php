<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return User::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);
        $user = User::where('email', $request->email)->first();
        $msg = response()->json(['error' => 'Invalid User'], 404);
        if($user){
            if (Hash::check($request->password, $user->password)) {
                $authToken = $user->createToken('authToken')->plainToken;
                $msg = response()->json(['success' => 'Login Success', 'token' => $authToken], 200);
            }
            else  
                $msg = response()->json(['error' => 'Invalid Credentials'], 400);
        }
        return $msg; 
    }

    public function logout(Request $request) {
        if (Auth::check()) {
            $request->user()->tokens()->delete();
            return response()->json(['success' => 'Logout Success'], 205);
        }
        return response()->json(['error' => 'Unauthorized Access'], 403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
            'first_name' => 'required|string',
            'surname' => 'required|string',
            'contact' => 'required|number',
        ]);
        //
        $user = new User();
        $user->email = $request->email;
        $user->first_name = $request->first_name;
        $user->surname = $request->surname;
        $user->contact = $request->contact;
        $user->password = bcrypt($request->password);
        $msg = $user->save() ? response()->json(['success' => 'User Registration Success'], 201): response()->json(['error' => 'User Registration Failed'], 400);
        return $msg;
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        if (!$user->id) {
           return response()->json(['error'=> 'User Not Found'], 404);
        }
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
        $msg = response()->json(['error' => 'User Not Found'], 404);
        if ($user) {
            $msg = $user->update($request->all()) ? response()->json(['success' => 'User Update Success'], 200) : response()->json(['error'=> 'User Update Failed']);
        }
        return $msg;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
        $msg = response()->json(['error' => 'User Not Found'], 404);
        if ($user) {
           $msg = User::delete($user) ? response()->json(['success' => 'User Delete Success'], 200) : response()->json(['error'=> 'User Delete Failed'], 400);
        }
        return $msg;
    }
}
