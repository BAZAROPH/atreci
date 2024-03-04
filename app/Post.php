<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

use Spatie\MediaLibrary\File;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\Image\Manipulations;

use Spatie\Activitylog\Traits\LogsActivity;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model implements HasMedia, Viewable
{
    use HasMediaTrait, Sluggable, LogsActivity, SoftDeletes, InteractsWithViews;
    protected $fillable = [
        'reference',
        'slug',
        'rang',
        'visibilite',
        'corbeille',
        'est_vendu',
        'est_nouveau',
        'libelle',
        'sous_titre',
        'description',
        'resume',
        'caracteristique',
        'lien',
        'fonction',
        'localisation',
        'prix_nouveau',
        'prix_ancien',
        'poids',
        'x_produit',
        'x_utilisation',
        'icon',
        'date_debut',
        'date_fin',
        'nom',
        'prenom',
        'telephone',
        'email',
        'surface',
        'piece',
        'salle_bain',
        'etage',
        'annee',
        'kilometrage',
        'date_planification',
        'user_id',
        'lier_id',
        'antidater',
        'created_at',
        'updated_at',
        'deleted_at',
        'original',
        'original_id',
        'date_action',
        'quantite',
        'variete',
        'technique',
        'intrant',
        'certification',
        'fournisseur_id',
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

    // user d'un post
    public function user()
    {
         return $this->belongsTo('App\User');
    }

    // fournisseur d'un post
    public function fournisseur()
    {
         return $this->belongsTo('App\User');
    }

       // Liste des commandes d'un post
    public function commandes()
    {
        return $this->belongsToMany('App\Commande', 'commandes_posts');
    }

    // Liste des categories d'un post
    public function categories()
    {
        return $this->belongsToMany('App\Categorie', 'categories_posts')
        ->withPivot('type', 'user_id')
        ->withTimestamps();
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

