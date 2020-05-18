<?php
    require_once("dbconnect.php");
     
    if(isset($_POST["email"])) {
 
        $email =  trim($_POST["email"]);
         $email = htmlspecialchars($email, ENT_QUOTES);
        $result_query = $mysqli->query("SELECT `email` FROM `users` WHERE `email`='".$email."'");
        if($result_query->num_rows == 1){
 
            echo "<span class='mesage_error'>Пользователь с таким почтовым адресом уже зарегистрирован</span>";
 
        }else{
            echo "<span class='success_message'>Почтовый адрес свободен</span>";
        }

        $result_query->close();
    }
?>