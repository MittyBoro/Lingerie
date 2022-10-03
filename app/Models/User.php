<?php

namespace App\Models;

use App\Models\Product\ProductOrder;
use App\Services\SpatieMedia\InteractsWithCustomMedia;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\MustVerifyEmail as AuthMustVerifyEmail;
use Illuminate\Foundation\Auth\Access\Authorizable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

use Laravel\Sanctum\HasApiTokens;

use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Manipulations;

use Propaganistas\LaravelPhone\Casts\RawPhoneNumberCast;
use Propaganistas\LaravelPhone\PhoneNumber;


use Nicolaslopezj\Searchable\SearchableTrait;


class User extends BaseModel implements
	AuthenticatableContract,
	AuthorizableContract,
	CanResetPasswordContract,
	HasMedia,
	AuthMustVerifyEmail
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
	use HasApiTokens;
	use HasFactory;
	use Notifiable;
	use SoftDeletes;
    use InteractsWithCustomMedia;
	use SearchableTrait;

	const MEDIA_COLLECTION = 'users';

	const ROLE_BLOCKED = 'blocked';
	const ROLE_USER = 'user';
	const ROLE_EDITOR = 'editor';
	const ROLE_ADMIN = 'admin';

	protected $fillable = [
		'name',
		'username',
		'email',
		'phone',
		'password',
		'role',
		'vk_id',
		'bonuses',
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

		static::deleted( function($model)
		{
			$model->bonus_list->each->delete();
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

	public function orders()
	{
		return $this->hasMany(ProductOrder::class)->ordered();
	}

	public function bonus_list()
	{
		return $this->hasMany(Bonus::class)->ordered();
	}

	public function paidOrders()
	{
		return $this->orders()->isPaid();
	}

	public static function roleList()
	{
		return [
			self::ROLE_ADMIN => 'Админ',
			self::ROLE_EDITOR => 'Редактор',
			self::ROLE_USER => 'Пользователь',
			self::ROLE_BLOCKED => 'Заблокирован',
		];
	}
	public static function roleTypes()
	{
		return array_keys( self::roleList() );
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

	public function getPaidAttribute()
	{
		return $this->paidOrders->sum('amount');
	}

	public function getIsAdminAttribute()
	{
		return $this->role == self::ROLE_ADMIN;
	}
	public function getIsEditorAttribute()
	{
		return $this->role == self::ROLE_ADMIN || $this->role == self::ROLE_EDITOR;
	}

	public function getAdminAvatarAttribute()
	{
		return $this->getAdminMedia(self::MEDIA_COLLECTION);
	}

	public function getAvatarAttribute($value)
	{
		return $this->getFirstMediaUrl(self::MEDIA_COLLECTION, 'thumb');
	}

	public function getFirstNameAttribute()
	{
		return explode(' ', $this->name)[0];
	}


	public function scopeUpdateUser($query, $data)
	{
		$this->update($data);

		if ( isset($data['admin_avatar']) )
			$this->syncMedia($data['admin_avatar'], self::MEDIA_COLLECTION);
	}

	private function getDefaultAvatar()
	{
		$ui = 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=fff&background=AC2CDB';
		$gravatar = 'https://www.gravatar.com/avatar/' . md5( $this->email ) . '?' . urlencode($ui);

		return $gravatar;
	}

	public function scopeFilter($query, array $filter)
	{
		if ( isset($filter['role']) ) {
			$query->where('role', $filter['role']);
		}

		if ( isset($filter['q']) ) {
			$query->search($filter['q']);
		}
	}

	public function recalculateBonuses()
	{
		$sum = Bonus::where('user_id', $this->id)->sum('amount');
		$newBonuses = max(0, $sum);

		$this->update(['bonuses' => $newBonuses]);
	}
}
