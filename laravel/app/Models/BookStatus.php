<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class BookStatus extends Model
{
    use HasFactory;

    const ACTIVE = 'ACTIVE';
    const DEACTIVE = 'DEACTIVE';

    const GROUP_DEFAULT = [
        self::ACTIVE,
        self::DEACTIVE,
    ];

    protected $table = 'book_status';

    protected $fillable = [
        'name',
    ];

    /**
     * Relation
     *********************/

    public function books(): HasMany
    {
        return $this->hasMany(Books::class);
    }


    /** Scope 
     * 
     ****************/

    function scopeActive(Builder $query)
    {
        $query->where('status', BookStatus::ACTIVE);
    }

    function scopeDeActive(Builder $query)
    {
        $query->where('status', BookStatus::DEACTIVE);
    }
}
