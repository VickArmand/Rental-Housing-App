<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RentalExpense extends Model
{
    //
    protected $fillable = [
        'type',
        'description',
        'amount',
        'payment_date',
        'recipient',
        'mode_of_payment',
        'receipt_number',
        'status',
    ];

    protected function casts(): array {
        return [
            'payment_date' => 'datetime',
        ];
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
