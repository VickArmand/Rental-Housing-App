<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Reminder::all();
    }

    public function search(Request $request) {
        $querystring = $request->getQueryString();
        $allowedKeys = ['type', 'repeat_interval','completed_at', 're$reminder_id', 'slug'];
        $params = [];
        $query = Reminder::query();
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
        $reminders = $query->get();
        return $reminders;
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
            'title' => 'required|string',
            'remind_at' => 'required|string',
            'completed_at' => 'nullable|string',
            'type' => 'required|string',
            'repeat_interval' => 'nullable|integer',
            'description' => 'nullable|string',
            'status' => 'required|string',
        ]);
        //
        $reminder = new Reminder();
        $reminder->fill($validated_data);
        $reminder->setSlugAttribute($request->title);
        $reminder->setUserIdAttribute();
        $reminder->setCreatedByAttribute();
        $reminder->setUpdatedByAttribute();
        $msg = $reminder->save() ? response()->json(['success' => 'Reminder Registration Success'], 201): response()->json(['error' => 'Reminder Registration Failed'], 400);
        return $msg;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $reminder = Reminder::find($id);
        if (!$reminder) {
           return response()->json(['error'=> 'Reminder Not Found'], 404);
        }
        return $reminder;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reminder $reminder)
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
            'title' => 'string',
            'remind_at' => 'string',
            'completed_at' => 'string',
            'type' => 'string',
            'repeat_interval' => 'integer',
            'description' => 'string',
            'status' => 'string',
        ]);
        $msg = response()->json(['error' => 'Reminder Not Found'], 404);
        $reminder = Reminder::find($id);
        if ($reminder) {
            $title = $request->title || $reminder->title;
            $reminder->fill($validated_data);
            if ($request->title)
                $reminder->setSlugAttribute($title);
            $reminder->setUpdatedByAttribute();
            $msg = $reminder->save() ? response()->json(['success' => 'Reminder Update Success'], 200) : response()->json(['error'=> 'Reminder Update Failed']);
        }
        return $msg;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $msg = response()->json(['error' => 'Reminder Not Found'], 404);
        $reminder = Reminder::find($id);
        if ($reminder) {
           $msg = $reminder->delete() ? response()->json(['success' => 'Reminder Delete Success'], 200) : response()->json(['error'=> 'Reminder Delete Failed'], 400);
        }
        return $msg;
    }
}
