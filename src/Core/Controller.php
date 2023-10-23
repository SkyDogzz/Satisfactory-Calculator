<?php

namespace App\Core;

class Controller
{
    public function view($view, $data = [])
    {
        require_once '/var/www/html/Views/partials/template.php';
    }
}