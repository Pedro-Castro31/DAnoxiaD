<?php

namespace App\Libraries;

class UserRole
{
    public const PLAYER = 'player';
    public const DM = 'dm';
    public const ADMIN = 'admin';

    /** @var array<string, int> */
    private const LEVELS = [
        self::PLAYER => 1,
        self::DM => 2,
        self::ADMIN => 3,
    ];

    public static function resolve(bool $isAdmin, bool $isDm): string
    {
        if ($isAdmin) {
            return self::ADMIN;
        }

        if ($isDm) {
            return self::DM;
        }

        return self::PLAYER;
    }

    public static function canAccess(string $currentRole, string $requiredRole): bool
    {
        $current = self::LEVELS[$currentRole] ?? self::LEVELS[self::PLAYER];
        $required = self::LEVELS[$requiredRole] ?? self::LEVELS[self::PLAYER];

        return $current >= $required;
    }
}
