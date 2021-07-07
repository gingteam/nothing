<?php

declare(strict_types=1);

namespace App\Presenters;

use Illuminate\Database\Connection;
use Nette;

class BasePresenter extends Nette\Application\UI\Presenter
{
    protected Connection $database;

    /**
     * Auto Inject.
     *
     * @return void
     */
    public function injectDatabase(Connection $database)
    {
        $this->absoluteUrls = true;
        $this->database = $database;
    }
}
