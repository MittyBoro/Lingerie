<?php

namespace App\Models\Admin;

use App\Models\User as ModelsUser;


class User extends ModelsUser
{

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
