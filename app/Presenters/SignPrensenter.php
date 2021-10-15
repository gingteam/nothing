<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Helper\Ulogin;
use RedBeanPHP\R;

final class SignPresenter extends BasePresenter
{
    public function checkRequirements($element): void
    {
        if (!$this->getUser()->isAllowed($this->getResource())) {
            $this->redirect('Homepage:');
        }

        parent::checkRequirements($element);
    }

    public function actionIn()
    {
        $request = $this->getHttpRequest();

        if ($token = $request->getPost('token')) {
            try {
                $ulogin = new Ulogin($token, $this->link('this'));

                $user = R::findOneOrDispense('user', 'facebook_id = ?', [$ulogin->getId()]);

                if (!$user->id) {
                    $user->name = $ulogin->getName();
                    $user->facebook_id = $ulogin->getId();
                    $user->photo = $ulogin->getPhoto();
                    $user->remember_token = $ulogin->getToken();
                    $user->sharedRoleList[] = R::load('role', 2);

                    R::store($user);
                }

                $this->getUser()->login((string) $user->id);
                $this->flashMessage('Successfully logged in', 'success');
            } catch (\InvalidArgumentException $e) {
                $this->flashMessage($e->getMessage(), 'danger');
            }

            $this->redirect('Homepage:');
        }
    }

    public function actionOut()
    {
        $this->getUser()->logout(true);
        $this->flashMessage('Successfully logged out', 'success');
        $this->redirect('Homepage:');
    }
}
