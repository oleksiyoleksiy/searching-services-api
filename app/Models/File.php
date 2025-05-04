<?php

namespace App\Models;

use App\Observers\FileObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $table = 'files';

    protected $fillable = [
        'type',
        'path',
        'model',
        'model_id',
    ];

    protected static function boot()
    {
        self::observe(FileObserver::class);
    }

    public function getURL()
    {
        return Storage::url($this->path);
    }
}
