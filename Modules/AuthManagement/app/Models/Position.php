<?php

namespace Modules\AuthManagement\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;
use Modules\AuthManagement\Database\Factories\PositionFactory;
use Spatie\Permission\Traits\HasRoles;

// use Modules\AuthManagement\Database\Factories\PositionFactory;

class Position extends Model
{
    use HasFactory, HasApiTokens, HasRoles;

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'is_active',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);

    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

     protected static function newFactory(): PositionFactory
     {
          return PositionFactory::new();
     }
}
