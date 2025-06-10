<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Tenant::all();
    }

    public function search(Request $request) {
        $querystring = $request->getQueryString();
        $allowedKeys = ['contact','email','is_active', 'slug'];
        $params = [];
        $query = Tenant::query();
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
        $tenants = $query->get();
        return $tenants;
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
        $tenant = new Tenant();
        $tenant->fill($validated_data);
        $tenant->setSlugAttribute($request->first_name, $request->middle_name, $request->surname);
        $tenant->setCreatedByAttribute();
        $tenant->setUpdatedByAttribute();
        $msg = $tenant->save() ? response()->json(['success' => 'Tenant Registration Success'], 201): response()->json(['error' => 'Tenant Registration Failed'], 400);
        return $msg;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $tenant = Tenant::find($id);
        if (!$tenant) {
           return response()->json(['error'=> 'Tenant Not Found'], 404);
        }
        return $tenant;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
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
        $tenant = Tenant::find($id);
        $msg = response()->json(['error' => 'Tenant Not Found'], 404);
        if ($tenant) {
            $firstname = $request->first_name || $tenant->first_name;
            $middlename = $request->middle_name || $tenant->middle_name;
            $surname = $request->surname || $tenant->surname;
            $tenant->fill($validated_data);
            if ($request->first_name || $request->middle_name || $request->surname)
                $tenant->setSlugAttribute($firstname, $middlename, $surname);
            $tenant->setUpdatedByAttribute();
            $msg = $tenant->save() ? response()->json(['success' => 'Tenant Update Success'], 200) : response()->json(['error'=> 'Tenant Update Failed']);
        }
        return $msg;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $tenant = Tenant::find($id);
        $msg = response()->json(['error' => 'Tenant Not Found'], 404);
        if ($tenant) {
           $msg = $tenant->delete() ? response()->json(['success' => 'Tenant Delete Success'], 200) : response()->json(['error'=> 'Tenant Delete Failed'], 400);
        }
        return $msg;
    }
}
