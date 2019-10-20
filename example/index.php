<?php

require __DIR__ . "./../vendor/autoload.php";

require __DIR__ . "./../example/config.php";

require __DIR__ . "/Model/UserController.php";

use Example\Model\UserController;

$user = new UserController();

// $user->raw("INSERT INTO TB_USERS(USER_NAME, PASSW, ID_PROFILE) VALUES(:uname, :upass, :pid)", [
//     ":uname" => "USER6",
//     ":upass" => "12345",
//     ":pid" => '2'
// ]);

$result = $user->raw("SELECT * FROM TB_USERS");

var_dump($result);