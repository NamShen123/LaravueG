<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departments extends Model
{
    use HasFactory;

    protected $table = 'departments';

    const ADMIN = "ADMIN";
    const STAFF = "STAFF";
    const USER = "USER";

    const GROUP_DEFAULT = [
        self::ADMIN,
        self::STAFF,
        self::USER,
    ];

    protected $fillable = [
        'name',
    ];

    /**
     * Relation
     *********************/

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
