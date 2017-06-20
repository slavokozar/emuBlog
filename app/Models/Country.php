<?php

/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 30/05/2017
 */


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Region[] $regions
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Country extends Model
{
    protected $table = "sportemu_countries";
    protected $fillable = [
        'name'
    ];

    public function regions(){
        return $this->hasMany(Region::class);
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
