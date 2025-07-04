<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\City;
use App\Models\Prefecture;
use App\Models\BodyMeasurement;
use App\Models\BodyCorrection;
use App\Models\FittingTolerance;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Constants\Common;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nickname',
        'email',
        'password',
        'role',
        'gender',
        'is_active',
        'prefecture_id',
        'city_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function bodymeasurements()
    {
        return $this->hasMany(BodyMeasurement::class);
    }

    public function bodycorrections()
    {
        return $this->hasOne(BodyCorrection::class);
    }

    public function fittingtolerance()
    {
        return $this->hasMany(FittingTolerance::class);
    }

    public function Coordinates()
    {
        return $this->hasMany(Coordinate::class);
    }

    public function CoordinateWearingLogs()
    {
        return $this->hasMany(CoordinateWearingLog::class);
    }

    public function scopeOfUser($query)
    {
        return $query->with(['prefecture', 'city'])
            ->where('role', 'user');
    }
    public function scopeIsActive($query, $flag)
    {
        if ($flag === '0' || $flag === '1') {
            return $query->where('is_active', (bool)$flag);
        }
        return $query;
    }

    public function scopeSortOrder($query, $sortOrder)
    {
        switch ($sortOrder) {
            case Common::SORT_ORDER['oldRegisteredItem']:
                return $query->orderBy('created_at', 'asc');
            case Common::SORT_ORDER['oldDeletedUser']:
                return $query->orderBy('deleted_at', 'asc');
            case Common::SORT_ORDER['latestDeletedUser']:
                return $query->orderBy('deleted_at', 'desc');
            default:
                return $query->orderBy('created_at', 'desc');
        }
    }

    public function scopeSearchKeyword($query, $keyword)
    {
        if (!is_null($keyword)) {
            $spaceConvert = mb_convert_kana($keyword, 's'); //全角スペースを半角に
            $keywords = preg_split('/[\s]+/', $spaceConvert, -1, PREG_SPLIT_NO_EMPTY); //空白で区切る

            foreach ($keywords as $word) //単語をループで回す
            {
                $query->where('users.email', 'like', '%' . $word . '%');
            }
            return $query;
        } else {
            return;
        }
    }
}
