<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Sport
 *
 * @property int                                                                $id
 * @property string                                                             $name
 * @property \Carbon\Carbon                                                     $created_at
 * @property \Carbon\Carbon                                                     $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Field[]  $fields
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Resort[] $resorts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Resort[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sport whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sport whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sport whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sport whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Sport extends Model
{
    protected $table = "sportemu_sports";
    protected $fillable = [
        'name',
    ];


    public function resorts()
    {
        return $this->belongsToMany(Resort::class, 'sportemu_resorts_sports');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'sportemu_sports_users')->withPivot(['skill']);;
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function () {
        });

        static::updated(function () {
        });

        static::deleting(function ($sport) {
            foreach ($sport->users as $user) {
                $user->sports()->detach($sport->id);
            }
            foreach ($sport->resorts as $resorts) {
                $resorts->sports()->detach($sport->id);
            }
            foreach ($sport->fields as $fields) {
                $fields->sports()->detach($sport->id);
            }
        });
    }


}
