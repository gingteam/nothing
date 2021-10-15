<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use RedBeanPHP\ToolBox;

class BasePresenter extends Nette\Application\UI\Presenter
{
    protected ToolBox $toolBox;

    public function __construct()
    {
        $this->absoluteUrls = true;
    }

    public function injectToolBox(ToolBox $toolBox)
    {
        $this->toolBox = $toolBox;
    }

    protected function getResource()
    {
        return sprintf('%s:%s', $this->getName(), $this->getAction());
    }
}
