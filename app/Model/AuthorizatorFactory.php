<?php

declare(strict_types=1);

namespace App\Model;

use Nette;

class AuthorizatorFactory
{
    public static function create(): Nette\Security\Permission
    {
        $acl = new Nette\Security\Permission();

        $acl->addRole('guest');
        $acl->addRole('user', ['guest']);
        $acl->addRole('admin', ['user']);

        // Sign in
        $acl->addResource('Sign:in');
        $acl->allow('guest', 'Sign:in');
        $acl->deny('user', 'Sign:in');

        // Sign out
        $acl->addResource('Sign:out');
        $acl->allow('user', 'Sign:out');
        $acl->deny('guest', 'Sign:out');

        return $acl;
    }
}
