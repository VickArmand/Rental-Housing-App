<?php

namespace App\Http\Controllers;

use App\Models\Caretaker;
use Illuminate\Http\Request;

class CaretakerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Caretaker::all();
    }

    public function search(Request $request) {
        $querystring = $request->getQueryString();
        $allowedKeys = ['contact','email','is_active', 'slug'];
        $params = [];
        $query = Caretaker::query();
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
        $caretakers = $query->get();
        return $caretakers;
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
        $validated_data = $request->validate([
            'email' => 'required|string|email',
            'first_name' => 'required|string',
            'surname' => 'required|string',
            'contact' => 'required|string',
            'middle_name' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
        ]);
        //
        $caretaker = new Caretaker();
        $caretaker->fill($validated_data);
        $caretaker->setSlugAttribute($request->first_name, $request->middle_name, $request->surname);
        $caretaker->setCreatedByAttribute();
        $caretaker->setUpdatedByAttribute();
        $msg = $caretaker->save() ? response()->json(['success' => 'Caretaker Registration Success'], 201): response()->json(['error' => 'Caretaker Registration Failed'], 400);
        return $msg;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $caretaker = Caretaker::find($id);
        if (!$caretaker) {
           return response()->json(['error'=> 'Caretaker Not Found'], 404);
        }
        return $caretaker;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Caretaker $caretaker)
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
            'emergency_contact' => 'string',
            'is_active' => 'boolean',
        ]);
        
        $msg = response()->json(['error' => 'Caretaker Not Found'], 404);
        $caretaker = Caretaker::find($id);
        if ($caretaker) {
            $firstname = $request->first_name || $caretaker->first_name;
            $middlename = $request->middle_name || $caretaker->middle_name;
            $surname = $request->surname || $caretaker->surname;
            $caretaker->fill($validated_data);
            if ($request->first_name || $request->middle_name || $request->surname)
                $caretaker->setSlugAttribute($firstname, $middlename, $surname);
            $caretaker->setUpdatedByAttribute();
            $msg = $caretaker->save() ? response()->json(['success' => 'Caretaker Update Success'], 200) : response()->json(['error'=> 'Caretaker Update Failed']);
        }
        return $msg;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $msg = response()->json(['error' => 'Caretaker Not Found'], 404);
        $caretaker = Caretaker::find($id);
        if ($caretaker) {
           $msg = $caretaker->delete() ? response()->json(['success' => 'Caretaker Delete Success'], 200) : response()->json(['error'=> 'Caretaker Delete Failed'], 400);
        }
        return $msg;
    }
}
