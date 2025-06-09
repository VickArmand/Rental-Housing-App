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
        $this->attributes['user_id'] = Auth::user();
    }

    public function setCreatedByAttribute() {
        $this->attributes['created_by'] = Auth::user();
    }

    public function setUpdatedByAttribute() {
        $this->attributes['updated_by'] = Auth::user();
    }
}
