<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case Staff = 'staff';
    case User = 'user';

    public static function hierarchy(): array
    {
        return [
            self::Admin->value => 3,
            self::Staff->value => 2,
            self::User->value => 1,
        ];
    }

    public function canManage(Role $other): bool
    {
        return self::hierarchy()[$this->value] >= self::hierarchy()[$other->value];
    }
}
