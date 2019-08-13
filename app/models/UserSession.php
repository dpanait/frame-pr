<?php

class Users extends Model{
    public function __construct(){
        $table = "users_session";
        parent::__construct($table);
    }
}