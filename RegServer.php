<?php
    include 'DB_Users.php';
    $DB_xml = new SimpleXMLElement($xmlstr);
    $isFind = false;

    if (isset($_POST['login'], $_POST['password'], $_POST['isCheck'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $isCheck = (boolean)$_POST['isCheck'];

        if($isCheck){
            echo "start";
            foreach ($DB_xml->users->user as $user){
                if ((string)$user->login == $login &&
                    (string)$user->password == $password){
                    $isFind = true;
                    break;
                }
            }
            if ($isFind){
                echo "Вход выполнен успешно";
            }
            else{
                echo "Данные не совпадают";
            }
        }
        else{
            foreach ($DB_xml->users->user as $user){
                if ((string)$user->login == $login &&
                    (string)$user->password == $password){
                    $isFind = true;
                    break;
                }
            }
            if ($isFind){
                echo "Такой пользователь уже зарегистрирован";
            }
            else{
                $users = $DB_xml->users->addChild('user');
                $users->addChild('login', $login);
                $users->addChild('password', $password);
                echo "Регистрация выполнена успешно";
            }
        }
    }
?>
