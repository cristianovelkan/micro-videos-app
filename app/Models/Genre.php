<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuid as TraitUuid;

class Genre extends Model
{
    use SoftDeletes;
    use TraitUuid;

    protected $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        "name",
        "is_active"
    ];

    protected $casts = [
        'id' => 'string',
        'is_active' => 'boolean'
    ];
}
