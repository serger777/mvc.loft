<?php
namespace App\Core;


class MainController
{
    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }

}
