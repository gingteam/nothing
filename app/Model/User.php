<?php

declare(strict_types=1);

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'facebook_id', 'photo', 'remember_token'];

    public function getRoles()
    {
        return $this->belongsToMany(Role::class);
    }
}
