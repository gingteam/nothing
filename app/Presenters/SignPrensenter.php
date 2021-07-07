<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\User;

final class SignPresenter extends BasePresenter
{
    public function actionIn()
    {
        $request = $this->getHttpRequest();
        if ($token = $request->getPost('token')) {
            $s = file_get_contents('http://ulogin.ru/token.php?token='.$token.'&host='.$this->link('this'));
            $user = json_decode($s);

            if (isset($user->error)) {
                $this->flashMessage('Login failed', 'error');
                $this->redirect('Homepage:');

                return;
            }

            $row = User::query()->firstOrCreate(
                ['facebook_id' => $user->uid],
                [
                    'name' => $user->first_name.' '.$user->last_name,
                    'photo' => $user->photo_big,
                    'remember_token' => $token,
                ]
            );

            $this->getUser()->login((string) $row->id);
            $this->flashMessage('Login successful', 'info');
            $this->redirect('Homepage:');
        }
    }

    public function actionOut()
    {
        $this->getUser()->logout(true);
        $this->redirect('Homepage:');
    }
}
