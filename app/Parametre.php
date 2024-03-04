<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\File;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Parametre extends Model implements HasMedia
{
    use HasMediaTrait, SoftDeletes, LogsActivity;
    protected $fillable = [
        'libelle',
        'title',
        'sous_titre',
        'description',
        'keywords',
        'url',
        'email',
        'type_id',
    ];

    protected static $logFillable = true;

    //  Type de site web
    public function type_website()
    {
        return $this->belongsTo('App\Categorie', 'type_id')->withDefault();
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    /* public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'libelle'
            ]
        ];
    } */

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(350)
            ->height(350);

        $this->addMediaConversion('normal')
            ->width(1000)
            ->height(1000);

        $this
            ->addMediaConversion('my-conversion')
            ->withResponsiveImages();

        /* $this->addMediaConversion('vidthumb')
            ->width(800)
            ->height(800)
            ->extractVideoFrameAtSecond(7)
            ->performOnCollections('video'); */
    }
}
