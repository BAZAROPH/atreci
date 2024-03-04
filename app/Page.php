<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Page extends Model implements HasMedia
{
    use Sluggable, SoftDeletes, LogsActivity;
    protected $fillable = [
        'title',
        'keywords',
        'description',
        'type',
        'url',
    ];

    protected static $logFillable = true;
}
