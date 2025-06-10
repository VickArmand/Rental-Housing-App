<?php

namespace App\Http\Controllers;

use App\Models\User;
use Faker\Core\Uuid;
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

    public function search(Request $request) {
        $querystring = $request->getQueryString();
        $allowedKeys = ['contact','email', 'slug', 'is_active'];
        $params = [];
        $query = User::query();
        parse_str(str_replace(';', '&', $querystring), $params);
        $firstCondition = true;
        foreach ($params as $key => $val) {
            if (in_array($key, $allowedKeys)) {
                if ($firstCondition) {
                    $query->where($key, 'like', '%'.$val.'%');
                    $firstCondition = false;
                }
                else
                    $query->orWhere($key, 'like', '%'.$val.'%');
            }
        }
        $users = $query->get();
        return $users;
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
            if (Hash::check($request->password, $user->password) && $user->is_approved) {
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
        $validated_data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'surname' => 'required|string',
            'contact' => 'required|string',
        ]);
        //
        $user = new User();
        $user->fill($validated_data);
        $user->setSlugAttribute($request->first_name, $request->middle_name, $request->surname);
        $user->setCreatedByAttribute();
        $user->setUpdatedByAttribute();
        $user->password = bcrypt($request->password);
        $msg = $user->save() ? response()->json(['success' => 'User Registration Success'], 201): response()->json(['error' => 'User Registration Failed'], 400);
        return $msg;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $user = User::find($id);
        if (!$user) {
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
    public function update(Request $request, $id)
    {
        //
        $validated_data = $request->validate([
            'email' => 'string|email',
            'first_name' => 'string',
            'surname' => 'string',
            'contact' => 'string',
            'middle_name' => 'string',
            'is_approved' => 'boolean',
        ]);
        $user = User::find($id);
        $msg = response()->json(['error' => 'User Not Found'], 404);
        if ($user) {
            $firstname = $request->first_name || $user->first_name;
            $middlename = $request->middle_name || $user->middle_name;
            $surname = $request->surname || $user->surname;
            $user->fill($validated_data);
            if ($request->first_name || $request->middle_name || $request->surname)
                $user->setSlugAttribute($firstname, $middlename, $surname);
            $user->setUpdatedByAttribute();
            $msg = $user->save() ? response()->json(['success' => 'User Update Success'], 200) : response()->json(['error'=> 'User Update Failed']);
        }
        return $msg;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $msg = response()->json(['error' => 'User Not Found'], 404);
        $user = User::find($id);
        if ($user) {
           $msg = $user->delete() ? response()->json(['success' => 'User Delete Success'], 200) : response()->json(['error'=> 'User Delete Failed'], 400);
        }
        return $msg;
    }
}
