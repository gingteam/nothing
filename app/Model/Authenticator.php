<?php

declare(strict_types=1);

namespace App\Model;

use Nette;
use Nette\Security\IIdentity;
use Nette\Security\SimpleIdentity;

final class Authenticator implements Nette\Security\Authenticator, Nette\Security\IdentityHandler
{
    public function authenticate(string $id, ?string $password = null): SimpleIdentity
    {
        $row = User::query()->find($id);

        return new SimpleIdentity(
            $row->id,
            $row->getRoles()->pluck('name')->toArray(),
            $row->toArray()
        );
    }

    public function sleepIdentity(IIdentity $identity): SimpleIdentity
    {
        // we return a proxy identity, where in the ID is remember token
        return new SimpleIdentity($identity->remember_token);
    }

    public function wakeupIdentity(IIdentity $identity): ?SimpleIdentity
    {
        // replace the proxy identity with a full identity, as in authenticate()
        $row = User::query()->where('remember_token', $identity->getId())
            ->first();

        return $row
            ? new SimpleIdentity(
                $row->id,
                $row->getRoles()->pluck('name')->toArray(),
                $row->toArray()
            )
            : null;
    }
}
