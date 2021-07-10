<?php

declare(strict_types=1);

namespace App\Presenters;

use Illuminate\Database\Connection;
use Nette;

class BasePresenter extends Nette\Application\UI\Presenter
{
    protected Connection $database;

    public function __construct()
    {
        $this->absoluteUrls = true;
    }

    /**
     * Auto Inject.
     *
     * @return void
     */
    public function injectDatabase(Connection $database)
    {
        $this->database = $database;
    }

    protected function getResource()
    {
        return sprintf('%s:%s', $this->getName(), $this->getAction());
    }
}
