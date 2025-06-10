<?php

namespace App\Http\Controllers;

use App\Models\RentalExpense;
use Illuminate\Http\Request;

class RentalExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return RentalExpense::all();
    }

    public function search(Request $request) {
        $querystring = $request->getQueryString();
        $allowedKeys = ['type', 'amount', 'payment_date', 'recipient', 'mode_of_payment', 'receipt_number', 'status', 'user_id'];
        $params = [];
        $query = RentalExpense::query();
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
        $rentalExpenses = $query->get();
        return $rentalExpenses;
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
            'recipient' => 'required|string',
            'mode_of_payment' => 'required|string',
            'receipt_number' => 'nullable|string',
            'status' => 'required|string',
        ]);
        //
        $rentalExpense = new RentalExpense(); 
        $rentalExpense->fill($validated_data);
        $rentalExpense->setUserIdAttribute();
        $rentalExpense->setCreatedByAttribute();
        $rentalExpense->setUpdatedByAttribute();
        $msg = $rentalExpense->save() ? response()->json(['success' => 'Rental Expense Registration Success'], 201): response()->json(['error' => 'Rental Expense Registration Failed'], 400);
        return $msg;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $rentalExpense = RentalExpense::find($id);
        if (!$rentalExpense) {
           return response()->json(['error'=> 'RentalExpense Not Found'], 404);
        }
        return $rentalExpense;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RentalExpense $rentalExpense)
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
            'recipient' => 'string',
            'mode_of_payment' => 'string',
            'receipt_number' => 'string',
            'status' => 'string',
        ]);
        $msg = response()->json(['error' => 'RentalExpense Not Found'], 404);
        $rentalExpense = RentalExpense::find($id);
        if ($rentalExpense) {
            $rentalExpense->fill($validated_data);
            $rentalExpense->setUpdatedByAttribute();
            $msg = $rentalExpense->save() ? response()->json(['success' => 'Rental Expense Update Success'], 200) : response()->json(['error'=> 'Rental Expense Update Failed']);
        }
        return $msg;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $rentalExpense = RentalExpense::find($id);
        $msg = response()->json(['error' => 'RentalExpense Not Found'], 404);
        if ($rentalExpense) {
           $msg = $rentalExpense->delete() ? response()->json(['success' => 'Rental Expense Delete Success'], 200) : response()->json(['error'=> 'Rental Expense Delete Failed'], 400);
        }
        return $msg;
    }
}
