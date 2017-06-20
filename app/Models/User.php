<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int                                                                      $id
 * @property string                                                                   $google_id
 * @property string                                                                   $facebook_id
 * @property string                                                                   $name
 * @property string                                                                   $surname
 * @property string                                                                   $email
 * @property string                                                                   $password
 * @property string                                                                   $nickname
 * @property bool                                                                     $agreement
 * @property int                                                                      $age
 * @property bool                                                                     $gender
 * @property string                                                                   $phone
 * @property string                                                                   $iban
 * @property bool                                                                     $instructor
 * @property int                                                                      $role
 * @property string                                                                   $remember_token
 * @property string                                                                   $deleted_at
 * @property \Carbon\Carbon                                                           $created_at
 * @property \Carbon\Carbon                                                           $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Credit[]       $credits
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Image[]        $images
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Notification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Rating[]       $ratings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reservation[]  $reservations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Resort[]       $resorts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Sport[]        $sports
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Team[]         $teams
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereAge($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereAgreement($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereFacebookId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereGoogleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereIban($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereInstructor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereNickname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereSurname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Credit                                                  $credit
 * @property int                                                                      $city_id
 * @property string                                                                   $address
 * @property string                                                                   $postal_code
 * @property string                                                                   $ico
 * @property-read \App\Models\County                                                  $city
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereIco($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePostalCode($value)
 * @property int                                                                      $county_id
 * @property-read \App\Models\County                                                  $county
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCountyId($value)
 * @property string                                                                   $address_city
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereAddressCity($value)
 * @property string $country
 * @property string $state
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereState($value)
 */
class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'sportemu_users';
    protected $fillable = [
        'google_id',
        'facebook_id',
        'name',
        'surname',
        'email',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function sports()
    {
        return $this->belongsToMany(Sport::class, "sportemu_sports_users")->withPivot(['skill']);
    }

    public function resorts()
    {
        return $this->belongsToMany(Resort::class, "sportemu_resorts_admins");
    }

    public function county()
    {
        return $this->belongsTo(County::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function () {
        });

        static::updated(function () {
        });

        static::deleting(function ($user) {
            foreach ($user->resorts as $resort) {
                $user->resorts()->detach($resort->id);
            }
        });
    }
}
