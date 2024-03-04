<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Champ extends Model
{
    use Sluggable, SoftDeletes, LogsActivity;
    protected $fillable = [
        'libelle',
        'titre',
        'description',
        'icon',
        'slug',
        'requete',
        'visible',
        'type_champ_id',
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
    public function categories()
    {
        return $this->belongsToMany('App\Categorie', 'categories_champs');
    }

    // Type de champ d'un champ
    public function type_champ()
    {
         return $this->belongsTo('App\Categorie', 'type_champ_id')->withDefault();
    }

}
