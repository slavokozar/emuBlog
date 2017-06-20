<?php

/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 30/05/2017
 */


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Region
 *
 * @property int                                                                $id
 * @property int                                                                $state_id
 * @property string                                                             $name
 * @property \Carbon\Carbon                                                     $created_at
 * @property \Carbon\Carbon                                                     $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\County[] $cities
 * @property-read \App\Models\Country                                             $state
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Region whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Region whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Region whereStateId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Region whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\County[] $counties
 * @property-read \App\Models\Country $country
 */
class Region extends Model
{

    protected $table = "sportemu_regions";
    protected $fillable = [
        'name',
        'country_id'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function counties()
    {
        return $this->hasMany(County::class);
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
