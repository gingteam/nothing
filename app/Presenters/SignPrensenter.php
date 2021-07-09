<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Helper\Ulogin;
use App\Model\User;
use InvalidArgumentException;

final class SignPresenter extends BasePresenter
{
    public function actionIn()
    {
        $request = $this->getHttpRequest();

        if ($token = $request->getPost('token')) {
            try {
                $ulogin = new Ulogin($token, $this->link('this'));

                $row = User::query()->firstOrCreate(
                    ['facebook_id' => $ulogin->getId()],
                    [
                        'name' => $ulogin->getName(),
                        'photo' => $ulogin->getPhoto(),
                        'remember_token' => $token,
                    ]
                );

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
