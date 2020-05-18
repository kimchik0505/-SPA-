<?php
 session_start();

 require_once("dbconnect.php");

$_SESSION["error_messages"] = '';
$_SESSION["success_messages"] = '';
if(isset($_POST["btn_submit_auth"]) && !empty($_POST["btn_submit_auth"])){
 

$email = trim($_POST["email"]);
if(isset($_POST["email"])){
 
    if(!empty($email)){
        $email = htmlspecialchars($email, ENT_QUOTES);
        $reg_email = "/^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i";
        if( !preg_match($reg_email, $email)){
            $_SESSION["error_messages"] .= "<p class='mesage_error' >Вы ввели неправильный email</p>";
             

            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$address_site."/form_auth.php");
            exit();
        }
    }else{

        $_SESSION["error_messages"] .= "<p class='mesage_error' >Поле для ввода почтового адреса(email) не должна быть пустой.</p>";
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$address_site."/form_register.php");
 
        exit();
    }
     
 
}else{
    $_SESSION["error_messages"] .= "<p class='mesage_error' >Отсутствует поле для ввода Email</p>";
     
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$address_site."/form_auth.php");
    exit();
}
 
 if(isset($_POST["password"])){

    $password = trim($_POST["password"]);
 
    if(!empty($password)){
        $password = htmlspecialchars($password, ENT_QUOTES);

        $password = md5($password."top_secret");
    }else{
        $_SESSION["error_messages"] .= "<p class='mesage_error' >Укажите Ваш пароль</p>";
         
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$address_site."/form_auth.php");
        exit();
    }
     
}else{
    $_SESSION["error_messages"] .= "<p class='mesage_error' >Отсутствует поле для ввода пароля</p>";
     
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$address_site."/form_auth.php");
 
    exit();
}
$result_query_select = $mysqli->query("SELECT * FROM `users` WHERE email = '".$email."' AND password = '".$password."'");
 
if(!$result_query_select){
    $_SESSION["error_messages"] .= "<p class='mesage_error' >Ошибка запроса на выборке пользователя из БД</p>";
     
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$address_site."/form_auth.php");

    exit();
}else{

    if($result_query_select->num_rows == 1){

        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$address_site."/index.php");
 
    }else{

        $_SESSION["error_messages"] .= "<p class='mesage_error' >Неправильный логин и/или пароль</p>";
         
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$address_site."/form_auth.php");

        exit();
    }
}
}
else{
    exit("<p><strong>Ошибка!</strong> Вы зашли на эту страницу напрямую, поэтому нет данных для обработки. Вы можете перейти на <a href=".$address_site."> главную страницу </a>.</p>");
}