<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class TypeTaxonomie extends Model
{
    use Sluggable, SoftDeletes, LogsActivity;
    protected $fillable = [
        'libelle',
        'description',
        'icon',
        'slug',
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

    public function taxonomies()
    {
        return $this->hasMany('App\Taxonomie', 'type_taxonomie_id');
    }
}
