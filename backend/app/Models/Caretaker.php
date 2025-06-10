<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Caretaker extends Model
{
    protected $fillable = [
        'first_name',
        'middle_name',
        'surname',
        'contact',
        'emergency_contact',
        'email',
        'is_active',
    ];

    protected $hidden = [
        'slug'
    ];

    public function setSlugAttribute($firstname, $middlename, $surname) {
        $fullName = $firstname.$middlename.$surname;
        $this->attributes['slug'] = strtolower(preg_replace('/\s+/', '', $fullName));
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
