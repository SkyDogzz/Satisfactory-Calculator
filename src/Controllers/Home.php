<?php

namespace App\Controllers;

use App\Core\Sql;
use App\Models\Users;

class Home
{
    public function index()
    {
        var_dump(Sql::testConnection());
    }
}
