<?php

namespace App\Models;

use App\Services\SpatieMedia\InteractsWithCustomMedia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Manipulations;

use Propaganistas\LaravelPhone\Casts\RawPhoneNumberCast;
use Propaganistas\LaravelPhone\PhoneNumber;

use Nicolaslopezj\Searchable\SearchableTrait;


class User extends Authenticatable implements HasMedia {
    use HasApiTokens, HasFactory, Notifiable;

    use SoftDeletes;
    use InteractsWithCustomMedia;
    use SearchableTrait;

    const MEDIA_COLLECTION = 'users';

    const ROLE_BLOCKED = 'blocked';
    const ROLE_USER = 'user';
    const ROLE_EDITOR = 'editor';
    const ROLE_ADMIN = 'admin';

    const ROLES = [
        self::ROLE_BLOCKED,
        self::ROLE_USER,
        self::ROLE_EDITOR,
        self::ROLE_ADMIN,
    ];

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'role',
    ];

    protected $hidden = [
        'media',
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_published' => 'bool',
        'phone' => RawPhoneNumberCast::class
    ];

    protected $appends = [
        'avatar',
    ];

    protected $orderFileds = [
        'created_at', 'id', 'username', 'email', 'name', 'role',
    ];

    protected $searchable = [
        'columns' => [
            'name' => 1,
            'email' => 1,
            'phone' => 1,
            'username' => 1,
        ],
    ];

    public static function boot()
    {
        parent::boot();

        static::saving( function($model)
        {
            if ( !$model->username )
                $model->username = email_to_username($model->email) . '_' . Str::random(5);
        });
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection(self::MEDIA_COLLECTION)
            ->singleFile()
            ->useFallbackUrl( $this->getDefaultAvatar() )
            ->registerMediaConversions(function () {
                $this
                    ->addMediaConversion('thumb')
                    ->fit(Manipulations::FIT_CROP, 100, 100)
                    ->nonQueued();
            });
    }


    public function setPhoneAttribute($val)
    {
        if ($val)
            $this->attributes['phone'] = PhoneNumber::make($val)->formatE164();
    }

    public function setPasswordAttribute($val)
    {
        $this->attributes['password'] = Hash::make($val);
    }

    public function getIsAdminAttribute()
    {
        return $this->role == self::ROLE_ADMIN;
    }
    public function getIsEditorAttribute()
    {
        return $this->role == self::ROLE_ADMIN || $this->role == self::ROLE_EDITOR;
    }

    public function getAvatarAttribute()
    {
        return $this->getFirstMediaUrl(self::MEDIA_COLLECTION, 'thumb');
    }

    public function getFirstNameAttribute()
    {
        return explode(' ', $this->name)[0];
    }

    private function getDefaultAvatar()
    {
        $ui = 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=fff&background=AC2CDB';
        $gravatar = 'https://www.gravatar.com/avatar/' . md5( $this->email ) . '?' . urlencode($ui);

        return $gravatar;
    }

}
