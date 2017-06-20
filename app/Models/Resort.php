<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\Resort
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $admins
 * @property-read \App\Models\County $county
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Sport[] $sports
 * @mixin \Eloquent
 */
class Resort extends Model
{
    use SoftDeletes;

    protected $table = 'sportemu_resorts';

    protected $fillable = [
        'name',
        'description',
        'address_street',
        'address_city',
        'address_zip',
        'address_county_id',
        'address_latitude',
        'address_longitude',
        'contact_phone',
        'contact_email'
    ];

    public function admins()
    {
        return $this->belongsToMany(User::class, 'sportemu_resorts_admins')->withPivot(['owner']);
    }

    public function county()
    {
        return $this->belongsTo(County::class, 'address_county_id');
    }

    public function sports()
    {
        return $this->belongsToMany(Sport::class, 'sportemu_resorts_sports', 'resort_id', 'sport_id');
    }


    protected static function boot()
    {
        parent::boot();

        static::created(function () {
        });

        static::updated(function () {
        });

        static::deleting(function ($resort) {
            foreach ($resort->admins as $user) {
                $resort->admins()->detach($user->id);
            }

            foreach ($resort->sports as $facility) {
                $resort->sports()->detach($facility->id);
            }

        });
    }
}