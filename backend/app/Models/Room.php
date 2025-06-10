<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Room extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'cost',
        'rental_id',
        'tenant_id',
    ];

    protected $hidden = [
        'slug'
    ];

    public function setSlugAttribute($name) {
        $this->attributes['slug'] = strtolower(preg_replace('/\s+/', '', $name));
    }
    
    public function setCreatedByAttribute() {
        $this->attributes['created_by'] = Auth::user()->id;
    }

    public function setUpdatedByAttribute() {
        $this->attributes['updated_by'] = Auth::user()->id;
    }
}
