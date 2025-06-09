<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Reminder extends Model
{
    //
    protected $fillable = [
        'title',
        'remind_at',
        'type',
        'repeat_interval',
        'completed_at',
        'description',
    ];

    protected $hidden = [
        'slug'
    ];

    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime',
            'remind_at' => 'datetime',
        ];
    }

    public function setSlugAttribute($title) {
        $this->attributes['slug'] = strtolower(preg_replace('/\s+/', '', $title));
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
