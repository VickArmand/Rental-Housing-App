<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Rental::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function search(Request $request) {
        $querystring = $request->getQueryString();
        $allowedKeys = ['slug','is_active', 'caretaker_id', 'user_id'];
        $params = [];
        $query = Rental::query();
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
        $rentals = $query->get();
        return $rentals;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated_data = $request->validate([
            'name' => 'required|string',
            'caretaker_id' => 'nullable|uuid',
        ]);
        //
        $rental = new Rental();
        $rental->fill($validated_data);
        $rental->setSlugAttribute($request->first_name, $request->middle_name, $request->surname);
        $rental->setUserIdAttribute();
        $rental->setCreatedByAttribute();
        $rental->setUpdatedByAttribute();
        $msg = $rental->save() ? response()->json(['success' => 'Rental Registration Success'], 201): response()->json(['error' => 'Rental Registration Failed'], 400);
        return $msg;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $rental = Rental::find($id);
        if (!$rental) {
           return response()->json(['error'=> 'Rental Not Found'], 404);
        }
        return $rental;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rental $rental)
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
            'name' => 'string',
            'caretaker_id' => 'uuid',
            'is_active' => 'boolean',
        ]);
        $msg = response()->json(['error' => 'Rental Not Found'], 404);
        $rental = Rental::find($id);
        if ($rental) {
            $rental->fill($validated_data);
            $rental->setUpdatedByAttribute();
            $msg = $rental->save() ? response()->json(['success' => 'Rental Update Success'], 200) : response()->json(['error'=> 'Rental Update Failed']);
        }
        return $msg;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $rental = Rental::find($id);
        $msg = response()->json(['error' => 'Rental Not Found'], 404);
        if ($rental) {
           $msg = $rental->delete() ? response()->json(['success' => 'Rental Delete Success'], 200) : response()->json(['error'=> 'Rental Delete Failed'], 400);
        }
        return $msg;
    }
}
