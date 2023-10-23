<?php

namespace App\Models;

use App\Core\Sql;

class Users extends Sql{

    //declare all the variables like in a models in laravel with type
    protected Int $id;
    protected String $name;
    protected String $email;
    protected String $password;
    protected String $created_at;
    protected String $updated_at;

    protected String $table = "users";

    protected String $primaryKey = "id";

    protected array $fillable = ["name", "email", "password"];

    public function __construct()
    {
        parent::__construct();
    }
}