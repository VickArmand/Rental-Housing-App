<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Rental extends Model
{
    //
    protected $fillable = [
        'name',
        'is_active',
        'caretaker_id',
    ];

    protected $hidden = [
        'slug'
    ];
    
    public function setSlugAttribute($name) {
        $this->attributes['slug'] = strtolower(preg_replace('/\s+/', '', $name));
    }

    public function setUserIdAttribute() {
        if (Auth::check())
            $this->attributes['user_id'] = Auth::user()->id;
    }

    public function setCreatedByAttribute() {
        if (Auth::check())
            $this->attributes['created_by'] = Auth::user()->id;
    }

    public function setUpdatedByAttribute() {
        if (Auth::check())
            $this->attributes['updated_by'] = Auth::user()->id;
    }
}
