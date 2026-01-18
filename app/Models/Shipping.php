<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ScopedBy([UserScope::class])]
class Shipping extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'street',
        'city',
        'state',
        'zip',
        'country',
        'phone',
        'email',
        'length',
        'width',
        'height',
        'weight',
        'label_url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
