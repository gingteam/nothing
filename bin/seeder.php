<?php

declare(strict_types=1);

use RedBeanPHP\R;
use RedBeanPHP\ToolBox;

require __DIR__.'/../vendor/autoload.php';

App\Bootstrap::boot()
    ->createContainer()
    ->getByType(ToolBox::class);

[$admin, $user] = R::dispense('role', 2);

$admin->name = 'admin';
$user->name = 'user';

R::storeAll([$admin, $user]);
