<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserDetail extends Model
{
    protected $table = 'user_details';

    protected $fillable = [
        'name',
        'nik',
        'gender',
        'phone_number',
        'quota',
        'user_id'
    ];

    /**
     * Get the user that owns the user detail
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all visits where this user is the doctor
     */
    public function doctorVisits(): HasMany
    {
        return $this->hasMany(Visit::class, 'docter_id');
    }
}
