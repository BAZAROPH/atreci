<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\File;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\Activitylog\Traits\LogsActivity;

class Apparence extends Model implements HasMedia
{
    use Sluggable, HasMediaTrait, SoftDeletes, LogsActivity;
    protected $fillable = [
        'libelle',
        'debut',
        'fin',
        'description',
        'icon',
        'slug',
        'parent_id',
        'type_apparence_id',
        'user_id'
    ];

    protected static $logFillable = true;

    // Liste des categories d'une apparence
    public function categories()
    {
        return $this->belongsToMany('App\Categorie', 'apparences_categories');
    }

    //  Type apparence : blog, service
    public function type_apparence()
    {
        return $this->belongsTo('App\Categorie', 'type_apparence_id')->withDefault();
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'libelle'
            ]
        ];
    }

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
