<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Books extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'name',
        'image',
        'description',
        'author',
        'price',
        'quantity',
        'status_id	',
    ];

    /**
     * Relation
     *********************/

    public function status(): BelongsTo
    {
        return $this->belongsTo(BookStatus::class, 'status_id');
    }

    public function callSlips(): BelongsToMany
    {
        return $this->belongsToMany(CallSlip::class, 'call_slip_book', 'book_id', 'call_slip_id');
    }

    public function callSlipBooks(): HasMany
    {
        return $this->hasMany(CallSlipBook::class);
    }

}
