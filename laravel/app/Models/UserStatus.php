<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserStatus extends Model
{
    use HasFactory;
    
    protected $table = 'user_status';

    const ACTIVE = "ACTIVE";
    const DEACTIVE = "DEACTIVE";

    const GROUP_DEFAULT = [
        self::ACTIVE,
        self::DEACTIVE,
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
