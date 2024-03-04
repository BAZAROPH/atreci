<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword;

use Cache;
use Carbon\Carbon;
use Spatie\Permission\Traits\HasRoles;
use Cviebrock\EloquentSluggable\Sluggable;

use Spatie\MediaLibrary\File;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\Image\Manipulations;

use Spatie\Activitylog\Traits\LogsActivity;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasPermissions;

class User extends Authenticatable implements HasMedia
{
    use Notifiable, HasRoles, HasPermissions, Sluggable, HasMediaTrait, LogsActivity, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'matricule',
        'name',
        'prenom',
        'slug',
        'login',
        'telephone',
        'indicatif_telephone',
        'whatsapp',
        'indicatif_whatsapp',
        'biographie',
        'adresse',
        'sexe',
        'date_naissance',
        'poste',
        'email',
        'type_piece',
        'numero_piece',
        'password',
        'remember_token',
        'corbeille',
        'valide',
        'created_user',
        'parent_id',
        'provider',
        'provider_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'original',
        'original_id',
        'source_id',
    ];

    protected static $logFillable = true;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->matricule = IdGenerator::generate([
                'table' => 'users',
                'field' => 'matricule',
                'length' => 8,
                'prefix' =>date('y'),
                'reset_on_prefix_change' => false,
            ]);
        });
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
                'source' => 'name'
            ]
        ];
    }
    /**
     * hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function isOnline()
    {
        return Cache::has('user-is-online-'. $this->id);
    }


    // Liste des posts d'un user
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    // Liste de la session d'un user
    public function session()
    {
        return $this->hasMany('App\Session');
    }


    // Liste des apparences d'un user
    public function apparences()
    {
        return $this->hasMany('App\Apparence');
    }

    // Liste des categories d'un user
    public function categories()
    {
        return $this->hasMany('App\Categorie');
    }

    // Liste des adresses de livraison d'un user
    public function adresses()
    {
        return $this->hasMany('App\Categorie')->where([
            'taxonomie_id' => 33,
        ]);
    }

    // Liste des commandes d'un user
    public function commandes()
    {
        return $this->hasMany('App\Commande')->orderBy('created_at', 'desc');
    }

    // Liste des commandes d'un user
    public function commandes_sum()
    {
        return $this->hasMany('App\Commande');
    }

    // Parent direct
    public function parent()
    {
        return $this->hasOne('App\User', 'id', 'parent_id')->withDefault();
    }

    // Source d'inscription : Appareil utilisé
    public function source()
    {
        return $this->hasOne('App\Categorie', 'id', 'source_id');
    }

    // Enfants directs
    public function childrens()
    {
        return $this->hasMany('App\User', 'parent_id', 'id');
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
