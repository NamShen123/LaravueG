<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CallSlip extends Model
{
    use HasFactory;

    const DEADLINE_MONTH = 3;
    
    const NEW = "NEW";

    protected $table = 'call_slip';

    protected $fillable = [
        'name',
        'start',
        'end',
        'return_date',
        'deposit',
        'user_id',
        'staff_id',
        'cancel_reason',
        'status',
    ];

    /**
     * Relation
     *********************/

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Books::class, 'call_slip_book', 'call_slip_id', 'book_id' );
    }

    public function callSlipBooks(): HasMany
    {
        return $this->hasMany(CallSlipBook::class);
    }


}
