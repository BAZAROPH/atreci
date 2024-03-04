<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Taxonomie extends Model
{
    use Sluggable, SoftDeletes, LogsActivity;
    protected $fillable = [
        'libelle',
        'sous_titre',
        'cout',
        'description',
        'icon',
        'slug',
        'type_taxonomie_id',
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
    // le type taxonomie d'une taxonomie
    public function type_taxonomie()
    {
        return $this->belongsTo('App\TypeTaxonomie');
    }
    // les categories d'une taxonomie
    public function categories()
    {
        return $this->hasMany('App\Categorie');
    }



}
