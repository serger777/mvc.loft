<?php

namespace App\Controllers;

use App\Core\MainController;
use App\Models\User as User;


class Main extends MainController
{

    public function index()
    {

        $sortAge = 'asc';
        if (isset($_GET['sort_age']) && strtolower($_GET['sort_age']) == 'desc') {
            $sortAge = 'desc';
        }
        $users = User::getUsersSortByAge($sortAge);

        $this->view->twigRender('main', ['users' => $users]);
    }
}
