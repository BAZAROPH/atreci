<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Spatie\Activitylog\Traits\LogsActivity;

class Commande extends Model
{
    use SoftDeletes, LogsActivity;
    protected $fillable = [
        'reference',
        'quantite_produit',
        'cout_commande',
        'cout_livraison',
        'total_commande',
        'date_livraison',
        'type',
        'user_id',
        'adresse_id',
        'livraison_mode_id',
        'livraison_point_id',
        'livraison_agence_id',
        'etat_id',
        'source_id',
        'heure_id',
        'mode_paiement_id',
        'commercial_id',
        'token',
        'created_at',
        'updated_at',
        'deleted_at',
        'original',
        'original_id',
        'created_ip',
    ];

    protected static $logFillable = true;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->reference = IdGenerator::generate([
                'table' => 'commandes',
                'field' => 'reference',
                'length' => 10,
                'prefix' => 'ATR',
                'reset_on_prefix_change' => false,
            ]);
        });
    }

    // Liste des produits d'une commande
    public function produits()
    {
        return $this->belongsToMany('App\Post', 'commandes_posts')
        ->withPivot('cout', 'quantite', 'options', 'created_at', 'updated_at')
        ->withTimestamps();
    }

    // Liste des modes de paiement d'une commande
    public function mode_paiements()
    {
        return $this->belongsToMany('App\Categorie', 'versements', 'commande_id', 'mode_paiement_id')/* ->where([
            'type' => 'choix',
        ]) */
        ->withPivot('cout', 'frais', 'total', 'type', 'token', 'valide', 'user_id', 'paiement', 'created_at', 'updated_at', 'original_id', 'original')
        ->withTimestamps();
    }

    // Premier mode de paiement d'une commande
    public function mode_paiement()
    {
        return $this->belongsTo('App\Categorie', 'mode_paiement_id');
    }

    // le user de la commande
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // L'adresse de livraison
    public function adresse()
    {
        return $this->belongsTo('App\Categorie', 'adresse_id');
    }

    // Le mode de livraison
    public function livraison_mode()
    {
        return $this->belongsTo('App\Categorie', 'livraison_mode_id');
    }

    // L'état de la commande ou du panier
    public function etat()
    {
        return $this->belongsTo('App\Categorie', 'etat_id');
    }

    // A partir de quel devise la commande a été passée
    public function source()
    {
        return $this->belongsTo('App\Categorie', 'source_id');
    }

    // Heure de livraison de la commande
    public function heure()
    {
        return $this->belongsTo('App\Categorie', 'heure_id');
    }

    // Commercial de la commande
    public function commercial()
    {
        return $this->belongsTo('App\User', 'commercial_id');
    }
}
