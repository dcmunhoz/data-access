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

// $result = $user->raw("SELECT * FROM TB_USERS");

// $result = $user->find()->fetch(true);

$result = $user->find()->filter("USER_NAME = :uname AND ID_USER = :uid", [":uname" => "USER1", ":uid" => 1])->fetch();


var_dump($result);