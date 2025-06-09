<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Tenant extends Model
{
    //
    protected $fillable = [
        'first_name',
        'middle_name',
        'surname',
        'contact',
        'emergency_contact',
        'email',
    ];

    protected $hidden = [
        'slug'
    ];

    public function setSlugAttribute($firstname, $middlename, $surname) {
        $fullName = $firstname.$middlename.$surname;
        $this->attributes['slug'] = strtolower(preg_replace('/\s+/', '', $fullName));
    }

    public function setCreatedByAttribute() {
        $this->attributes['created_by'] = Auth::user();
    }

    public function setUpdatedByAttribute() {
        $this->attributes['updated_by'] = Auth::user();
    }
}
