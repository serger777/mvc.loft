<?php

namespace App\Controllers;

use App\Core\MainController;
use App\Models\File;

use App\Models\User as User;
use Intervention\Image\ImageManagerStatic as Image;

class Users extends MainController
{

    protected function checkRights(
        $login
    ) {
        return (isset($_SESSION['logged_user']) && $_SESSION['logged_user'] == $login);
    }

    public function enter()
    {
        $this->view->twigRender('enter', []);
    }

    public function login()
    {
        $this->view->twigRender('login', []);
    }

    public function register_form()
    {
        $this->view->twigRender('register_form', []);
    }

    public function menu()
    {
        $login = $_GET['login'];
        if (!$this->checkRights($login)) {
            $this->view->twigRender('error', []);
            return;
        };

        $this->view->twigRender('menu', ['login' => $login]);
    }

    public function authorization()
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $isAuthorized = true;
        if (!User::isExists($login)) {
            $isAuthorized = false;
        } else {
            $passwordHash = User::getPasswordHash($login);
            if (!password_verify($password, $passwordHash)) {
                $isAuthorized = false;
            };
        };
        if ($isAuthorized) {
            $_SESSION['logged_user'] = $login;
            header("Location: {$_SERVER['HTTP_ORIGIN']}/users/menu?login={$login}");
        } else {
            $this->view->twigRender('authorization_error', []);
        };
    }

    public function registration()
    {
        $login = $_POST['login'];
        if (User::isExists($login)) {
            $message = "Пользователь {$login} уже зарегистрирован в системе, выберите другой логин.";
            $this->view->twigRender('registration_error', ['message' => $message]);
            return;
        };


        $name = $_POST['name'];
        $age = $_POST['age'];
        $description = $_POST['description'];
        $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $img = Image::make($_FILES['avatar_file']['tmp_name']);
        $img->fit(50, 50);

        $img->save('img/avatar/' . $login . '.jpg');
        $img_path = 'img/avatar/' . $login . '.jpg';

        $data_file = [

            'login' => $login,
        ];
        File::create($data_file);


        $user = User::createUser($login, $passwordHash, $name, $age, $description, $img_path);
        if ($user) {
            $this->view->twigRender('registration_success', ['login' => $login]);
        } else {
            $message = "При регистрации пользователя {$login} возникла ошибка.";
            $this->view->twigRender('registration_error', ['message' => $message]);
        };
    }


    public function profile()
    {
        $login = $_GET['login'];
        if (!$this->checkRights($login)) {
            $this->view->twigRender('error', []);
            return;
        };

        $user = User::getByLogin($login);
        $name = $user->name;
        $age = $user->age;
        $description = $user->description;
        $userId = $user->id;
        $avatarPath = '/' . $user->avatar_path;

        $this->view->twigRender(
            'user_profile',
            [
                'id' => $userId,
                'login' => $login,
                'name' => $name,
                'age' => $age,
                'description' => $description,
                'avatar_path' => $avatarPath
            ]
        );

    }

    public function upload()
    {
        $login = $_GET['login'];
        if (!$this->checkRights($login)) {
            $this->view->twigRender('error', []);
            return;
        };

        $files = File::getByUser($login);


        $this->view->twigRender('upload_form', ['login' => $login, 'files' => $files]);
    }


    public function save_file()
    {
        $login = $_POST['login'];
        // Проверяем, на свою ли страницу заходит пользователь
        if (!$this->checkRights($login)) {
            $this->view->twigRender('rights_error', []);
            return;
        };

        $user = User::getByLogin($login);
        if (!$user) {
            return;
        };

//        Создаем каталог для файлов пользователя
        $imagePath = 'img/' . $login;
        if (!file_exists($imagePath)) {
            mkdir($imagePath);
        };
        //Копируем загруженный файл в каталог пользователя
        if (isset($_FILES) && $_FILES['upload_file']['error'] == 0) {

            $uploadFilePath = $imagePath . '/' . $_FILES['upload_file']['name'];
            move_uploaded_file($_FILES['upload_file']['tmp_name'], $uploadFilePath);
            $fileLink = '/img/' . $login . '/' . $_FILES['upload_file']['name'];
            $data_file = [

                'login' => $login,
                'file_path' => $fileLink,
            ];
            File::create($data_file);
        };

        header("Location: {$_SERVER['HTTP_ORIGIN']}/users/upload?login={$login}");
    }
}