<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Helper\Ulogin;
use App\Model\User;
use InvalidArgumentException;

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

                $row = User::query()->where('facebook_id', $ulogin->getId())
                    ->firstOr(function () use ($ulogin) {
                        $user = new User();
                        $user->name = $ulogin->getName();
                        $user->facebook_id = $ulogin->getId();
                        $user->photo = $ulogin->getPhoto();
                        $user->remember_token = $ulogin->getToken();
                        $user->save();
                        $user->getRoles()->attach(1); // role: user

                        return $user;
                    });

                $this->getUser()->login((string) $row->id);
                $this->flashMessage('Successfully logged in', 'success');
            } catch (InvalidArgumentException $e) {
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
