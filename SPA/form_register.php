<?php
    //Запускаем сессию
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Регистрация</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/form1.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript">
    $(document).ready(function(){
        "use strict";
        //================ Проверка email ==================
        var pattern = /^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i;

        $('input[name=email]').blur(function(){
            if($(this).val() != ''){
                if($(this).val().search(pattern) == 0){
                    $.ajax({
    url: "check_email.php", 
    type: "POST", 
    data: {
        email: $(this).val()
    }, 
    dataType: "html", 

    beforeSend: function(){
 
        $('#valid_email_message').text('Проверяется...');
    },
    success: function(data){
        $('#valid_email_message').html(data);
    } 
});
                    $('input[type=submit]').attr('disabled', false);
                }else{
                    $('#valid_email_message').html('<span class="mesage_error">Неправильный Email</span>');
                    $('input[type=submit]').attr('disabled', true);
                }
            }else{
                $('#valid_email_message').html('<span class="mesage_error">Введите Ваш email</span>');
            }
        });
        //================ Проверка длины пароля ==================
        var password = $('input[name=password]');
         
        password.blur(function(){
            if(password.val() != ''){
                if(password.val().length < 6){
                    $('#valid_password_message').text('Минимальная длина пароля 6 символов');
                    $('input[type=submit]').attr('disabled', true);
                     
                }else{
                    $('#valid_password_message').text('');
                    $('input[type=submit]').attr('disabled', false);
                }
            }else{
                $('#valid_password_message').text('Введите пароль');
            }
        });
    });
</script>
    </head>
    <body>
<div class="block_for_messages">
    <?php

        if(isset($_SESSION["error_messages"]) && !empty($_SESSION["error_messages"])){
            echo $_SESSION["error_messages"];
            unset($_SESSION["error_messages"]);
        }
 
        if(isset($_SESSION["success_messages"]) && !empty($_SESSION["success_messages"])){
            echo $_SESSION["success_messages"];

            unset($_SESSION["success_messages"]);
        }
    ?>
</div>
 
<?php
    if(!isset($_SESSION["email"]) && !isset($_SESSION["password"])){
        echo '
        <div class = "register" id="form_register">
            <h2>Форма регистрации</h2>
 
            <form action="register.php" method="post" name="form_register">
                <table>
                    <tbody><tr>
                        <td> Имя: </td>
                        <td>
                            <input type="text" name="first_name" required="required">
                        </td>
                    </tr>
 
                    <tr>
                        <td> Фамилия: </td>
                        <td>
                            <input type="text" name="last_name" required="required">
                        </td>
                    </tr>
              
                    <tr>
                        <td> Email: </td>
                        <td>
                            <input type="email" name="email" required="required"><br>
                            <span id="valid_email_message" class="success_message" ></span>
                        </td>
                    </tr>
              
                    <tr>
                        <td> Пароль: </td>
                        <td>
                            <input type="password" name="password" placeholder="минимум 6 символов" required="required"><br>
                            <span id="valid_password_message" class="mesage_error"></span>
                        </td>
                    </tr>                
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="btn_submit_register" value="Зарегистрироватся!">
                        </td>
                    </tr>
                </tbody></table>
            </form>
        </div>';
    }
    else
        { 
        echo '
        <div id="authorized">
            <h2>Вы уже зарегистрированы</h2>
        </div>';
    }
    ?>
    </body>
</html>