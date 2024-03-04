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

class Categorie extends Model implements HasMedia
{
    use Sluggable, HasMediaTrait, SoftDeletes, LogsActivity;
    protected $fillable = [
        'reference',
        'libelle',
        'sous_titre',
        'description',
        'lien',
        'requete',
        'cout',
        'icon',
        'slug',
        'indicateur',
        'corbeille',
        'rang',
        'user_id',
        'taxonomie_id',
        'parent_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'original',
        'original_id',
        'source_id',
        'original_table',
    ];

    protected static $logFillable = true;

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

    // Liste des champs d'une catégorie
    public function champs()
    {
        return $this->belongsToMany('App\Champ', 'categories_champs')
        ->withPivot('obligatoire', 'rang')
        ->withTimestamps();
    }

    // Liste des posts d'une catégorie
    public function posts()
    {
        return $this->belongsToMany('App\Post', 'categories_posts');
    }

    public function taxonomie()
    {
        return $this->belongsTo('App\Taxonomie');
    }

    // Liste des apparences d'une catégorie
    public function apparences()
    {
        return $this->belongsToMany('App\Apparence', 'apparences_categories')
        ->withPivot('default')
        ->withTimestamps();
    }

    // Parent direct
    public function parent()
    {
        return $this->hasOne('App\Categorie', 'id', 'parent_id');
    }

    // Enfants directs
    public function childrens()
    {
        return $this->hasMany('App\Categorie', 'parent_id', 'id');
    }

    // Liste des commandes d'une adresse
    public function commandes()
    {
        return $this->hasManyThrough('App\Commande', 'App\Categorie', 'id', 'adresse_id')->where([
            'taxonomie_id' => 33,
        ]);
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
