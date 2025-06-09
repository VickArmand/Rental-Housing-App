<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RentalIncome extends Model
{
    //
    protected $fillable = [
        'type',
        'description',
        'amount',
        'payment_date',
        'mode_of_payment',
        'tenant_id',
        'receipt_number',
        'status',
    ];

    protected function casts(): array {
        return [
            'payment_date' => 'datetime',
        ];
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
