<?php
if ($_GET["check"]) {
    $login = $_GET["login"];
    $userLogins = explode(":",file_get_contents("logins.txt"));
    foreach ($userLogins as $key => $value) {
        if ($value == $login) {
            echo 1;
            die();
        }
    }
    echo 0;
    // echo "string";//если нужно сгенерировать ошибку передачи данных сервером 
}
if ($_GET["reg"]) {
    $login = $_GET["login"];

    file_put_contents("logins.txt", $login.":", FILE_APPEND);
    $arr = [];
    foreach ($_GET as $key => $value) {
        if ($_GET[$key] == "reg") {
            continue;
        }
        $arr[$key] = $value;
    }
    file_put_contents("users.txt", serialize($arr)."/:", FILE_APPEND);
    echo "Success";
}



?>

