<?php

namespace App\Models\Admin;

use App\Models\Traits\RetrievingTrait;
use App\Models\User as BaseUser;


class User extends BaseUser
{
    use RetrievingTrait;

    protected $sortable = [
        'created_at', 'id', 'username', 'email', 'name', 'role',
    ];
    protected $defaultSort = 'id-desc';

    public static function roleList()
    {
        return [
            self::ROLE_ADMIN => 'Админ',
            self::ROLE_EDITOR => 'Редактор',
            self::ROLE_USER => 'Пользователь',
            self::ROLE_BLOCKED => 'Заблокирован',
        ];
    }

    public function getAdminAvatarAttribute()
    {
        return $this->getAdminMedia(self::MEDIA_COLLECTION);
    }

    public function scopeUpdateUser($query, $data)
    {
        $this->update($data);

        if ( isset($data['admin_avatar']) )
            $this->syncMedia($data['admin_avatar'], self::MEDIA_COLLECTION);
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
}
