<?php
    session_start();
 
    require_once("dbconnect.php");
 
    $_SESSION["error_messages"] = '';
    $_SESSION["success_messages"] = '';
?>
<?php
if(isset($_POST["btn_submit_order"]) && !empty($_POST["btn_submit_order"])){
 
if(isset($_POST["name"])){

    $name = trim($_POST["name"]);
    if(!empty($name)){
        $name = htmlspecialchars($name, ENT_QUOTES);
    }else{

        $_SESSION["error_messages"] .= "<p class='mesage_error'>Укажите Ваше имя</p>";

        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$address_site."");
        exit();
    }
 
     
}else{
    $_SESSION["error_messages"] .= "<p class='mesage_error'>Отсутствует поле с именем</p>";

    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$address_site."");

    exit();
}

if(isset($_POST["email"])){

    $email = trim($_POST["email"]);
 
    if(!empty($email)){
 
        $email = htmlspecialchars($email, ENT_QUOTES);
$reg_email = "/^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i";
 
if( !preg_match($reg_email, $email)){

    $_SESSION["error_messages"] .= "<p class='mesage_error' >Вы ввели неправильный email</p>";
     
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$address_site."");
    exit();
}
 
    }else{
        $_SESSION["error_messages"] .= "<p class='mesage_error'>Укажите Ваш email</p>";

        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$address_site."");
        exit();
    }
 
}else{
    $_SESSION["error_messages"] .= "<p class='mesage_error'>Отсутствует поле для ввода Email</p>";
     

    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$address_site."");
    exit();
}

if(isset($_POST["phonenumber"])){
 
    $phonenumber = trim($_POST["phonenumber"]);
 
    if(!empty($phonenumber)){
 
        $phonenumber = htmlspecialchars($phonenumber, ENT_QUOTES);

$reg_phonenumber = "/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/";

if( !preg_match($reg_phonenumber, $phonenumber)){

    $_SESSION["error_messages"] .= "<p class='mesage_error' >Вы ввели неправильный номер</p>";
     
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$address_site."");

    exit();
}
 
   }else{
        $_SESSION["error_messages"] .= "<p class='mesage_error'>Укажите Ваш номер</p>";
         
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$address_site."");

        exit();
    }
 
}else{
    $_SESSION["error_messages"] .= "<p class='mesage_error'>Отсутствует поле для ввода номера</p>";

    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$address_site."");

    exit();
}
if(isset($_POST["adress"])){
     
    $adress = trim($_POST["adress"]);

    if(!empty($adress)){

        $adress = htmlspecialchars($adress, ENT_QUOTES);
    }else{
 
        $_SESSION["error_messages"] .= "<p class='mesage_error'>Укажите Ваш адресс</p>";
 
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$address_site."");
        exit();
    }
 
     
}else{

    $_SESSION["error_messages"] .= "<p class='mesage_error'>Отсутствует поле с адресом</p>";

    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$address_site."");
    exit();
}
if(isset($_POST["dateorder"])){
     
    $dateorder = trim($_POST["dateorder"]);
 

    if(!empty($dateorder)){
        $dateorder = htmlspecialchars($dateorder, ENT_QUOTES);
     
    }else{
        $_SESSION["error_messages"] .= "<p class='mesage_error'>Укажите дату перевозки</p>";
 
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$address_site."");
        exit();
    }
 $result_query_insert = $mysqli->query("INSERT INTO `orders` (name, email, phonenumber, adress, dateorder) VALUES ('".$name."', '".$email."', '".$phonenumber."', '".$adress."', '".$dateorder."')");
 
if(!$result_query_insert){
    $_SESSION["error_messages"] .= "<p class='mesage_error' >Ошибка запроса на добавления пользователя в БД</p>";
     

    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$address_site."");
    exit();
}else{
	$adminemail="alexnik20000316@gmail.com";
	$msg= "<p>Имя: $name</p> 
	<p>E-mail: $email</p> 
	<p>Сделан заказ на адресс $adress , телефонный номер: $phonenumber .</p> 
	<p>Дата заказа: $dateorder</p>"; 
	mail("$adminemail", "$date $time Сообщение от $name", "$msg");
    $_SESSION["success_messages"] = "<p class='success_message'>Заказ успешно принят!<br /> Ожидайте ответа.</p>";
    
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$address_site."");
}
 
$result_query_insert->close();

$mysqli->close();
     
}else{
    $_SESSION["error_messages"] .= "<p class='mesage_error'>Отсутствует поле с датой</p>";
 
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$address_site."");
 
    exit();
}

}else{
 
        exit("<p><strong>Ошибка!</strong> Вы зашли на эту страницу напрямую, поэтому нет данных для обработки. Вы можете перейти на <a href=".$address_site."> главную страницу </a>.</p>");
    }
?>