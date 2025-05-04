<?php

namespace App\Traits;

use App\Models\File;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait FileTrait
{
    public function files(string $type): HasMany
    {
        return $this->hasMany(File::class)
            ->where('object', $this->class)
            ->where('object_id', $this->id)
            ->where('type', $type);
    }
}
