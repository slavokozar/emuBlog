<?php

/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 30/05/2017
 */


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\City
 *
 * @property int                                                              $id
 * @property int                                                              $region_id
 * @property string                                                           $name
 * @property \Carbon\Carbon                                                   $created_at
 * @property \Carbon\Carbon                                                   $updated_at
 * @property-read \App\Models\Region                                          $region
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Models\County whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\County whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\County whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\County whereRegionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\County whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Resort[] $resorts
 */
class County extends Model
{
    protected $table = "sportemu_counties";
    protected $fillable = [
        'name',
        'region_id'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function resorts()
    {
        return $this->hasMany(Resort::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
        });
        static::deleting(function ($item) {
        });
    }
}
