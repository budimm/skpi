<?php

namespace App\Entities;

use Myth\Auth\Entities\User as MythUser;

class User extends MythUser
{
    protected $attributes = [
        'fakultas_id' => null,
        'prodi_id' => null,
        'avatar' => 'frist-avatar.png',
        'name' => 'nama'
    ];
}
