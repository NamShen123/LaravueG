<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CallSlipBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'call_slip_id',
        'book_id',
    ];

    /**
     * Relation
     *********************/

    function callSlip(): BelongsTo
    {
        return $this->belongsTo(CallSlip::class, 'call_slip_id');
    }

    function book(): BelongsTo
    {
        return $this->belongsTo(Books::class, 'book_id');
    }
}
