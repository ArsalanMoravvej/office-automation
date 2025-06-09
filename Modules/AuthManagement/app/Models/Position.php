<?php

namespace Modules\AuthManagement\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;
use Modules\AuthManagement\Database\Factories\PositionFactory;

// use Modules\AuthManagement\Database\Factories\PositionFactory;

class Position extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);

    }

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

     protected static function newFactory(): PositionFactory
     {
          return PositionFactory::new();
     }
}
