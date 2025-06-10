<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Room::all();
    }

    public function search(Request $request) {
        $querystring = $request->getQueryString();
        $allowedKeys = ['is_occupied', 'slug', 'cost', 'rental_id', 'tenant_id',];
        $params = [];
        $query = Room::query();
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
        $rooms = $query->get();
        return $rooms;
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
            'name' => 'required|string',
            'description' => 'required|string',
            'cost' => 'required|numeric',
            'rental_id' => 'required|uuid',
            'tenant_id' => 'nullable|uuid',
        ]);
        //
        $room = new Room();
        $room->fill($validated_data);
        $room->setSlugAttribute($request->name);
        $room->setCreatedByAttribute();
        $room->setUpdatedByAttribute();
        $msg = $room->save() ? response()->json(['success' => 'Room Registration Success'], 201): response()->json(['error' => 'Room Registration Failed'], 400);
        return $msg;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $room = Room::find($id);
        if (!$room) {
           return response()->json(['error'=> 'Room Not Found'], 404);
        }
        return $room;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
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
            'description' => 'string',
            'cost' => 'numeric',
            'rental_id' => 'uuid',
            'tenant_id' => 'uuid',
        ]);
        $room = Room::find($id);
        $msg = response()->json(['error' => 'Room Not Found'], 404);
        if ($room) {
            $name = $request->name || $room->name;
            $room->fill($validated_data);
            if ($request->name)
                $room->setSlugAttribute($name);
            $room->setUpdatedByAttribute();
            $msg = $room->save() ? response()->json(['success' => 'Room Update Success'], 200) : response()->json(['error'=> 'Room Update Failed']);
        }
        return $msg;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $room = Room::find($id);
        $msg = response()->json(['error' => 'Room Not Found'], 404);
        if ($room) {
           $msg = $room->delete() ? response()->json(['success' => 'Room Delete Success'], 200) : response()->json(['error'=> 'Room Delete Failed'], 400);
        }
        return $msg;
    }
}
