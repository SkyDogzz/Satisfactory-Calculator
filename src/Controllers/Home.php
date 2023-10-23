<?php

namespace App\Controllers;

use App\Core\Sql;

class Home
{
    public function index()
    {
        var_dump(Sql::testConnection());
    }
}
