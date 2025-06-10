<?php

namespace App\Http\Controllers;

use App\Models\RentalIncome;
use Illuminate\Http\Request;

class RentalIncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return RentalIncome::all();
    }

    public function search(Request $request) {
        $querystring = $request->getQueryString();
        $allowedKeys = ['type', 'amount', 'payment_date', 'mode_of_payment', 'receipt_number', 'status', 'tenant_id', 'user_id'];
        $params = [];
        $query = RentalIncome::query();
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
        $rentalIncomes = $query->get();
        return $rentalIncomes;
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
            'type' => 'required|string',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'payment_date' => 'required|string',
            'mode_of_payment' => 'required|string',
            'tenant_id' => 'nullable|uuid',
            'receipt_number' => 'nullable|string',
            'status' => 'required|string',
        ]);
        //
        $rentalIncome = new RentalIncome();
        $rentalIncome->fill($validated_data);
        $rentalIncome->setUserIdAttribute();
        $rentalIncome->setCreatedByAttribute();
        $rentalIncome->setUpdatedByAttribute();
        $msg = $rentalIncome->save() ? response()->json(['success' => 'Rental Income Registration Success'], 201): response()->json(['error' => 'Rental Income Registration Failed'], 400);
        return $msg;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $rentalIncome = RentalIncome::find($id);
        if (!$rentalIncome) {
           return response()->json(['error'=> 'Rental Income Not Found'], 404);
        }
        return $rentalIncome;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RentalIncome $rentalIncome)
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
            'type' => 'string',
            'description' => 'string',
            'amount' => 'numeric',
            'payment_date' => 'string',
            'mode_of_payment' => 'string',
            'tenant_id' => 'uuid',
            'receipt_number' => 'string',
            'status' => 'string',
        ]);
        $msg = response()->json(['error' => 'RentalIncome Not Found'], 404);
        $rentalIncome = RentalIncome::find($id);
        if ($rentalIncome) {
            $rentalIncome->fill($validated_data);
            $rentalIncome->setUpdatedByAttribute();
            $msg = $rentalIncome->save() ? response()->json(['success' => 'Rental Income Update Success'], 200) : response()->json(['error'=> 'Rental Income Update Failed']);
        }
        return $msg;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $rentalIncome = RentalIncome::find($id);
        $msg = response()->json(['error' => 'RentalIncome Not Found'], 404);
        if ($rentalIncome) {
           $msg = $rentalIncome->delete() ? response()->json(['success' => 'Rental Income Delete Success'], 200) : response()->json(['error'=> 'Rental Income Delete Failed'], 400);
        }
        return $msg;
    }
}
