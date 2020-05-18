<?php

$recepient = "alexnik20000316@gmail.com";
$sitename = "transport.s";

$name = trim($_POST["name"]);
$email = trim($_POST["email"]);
$phone = trim($_POST["phonenumber"]);
$adress = trim($_POST["adress"]);
$dateorder = trim($_POST["dateorder"]);
$message = "Имя: $name \nEmail: $email \nТелефон: $phonenumber \nАдресс заказа: $adress \nДата заказа: $dateorder";

$pagetitle = "Новая заявка на перевозку с сайта \"$sitename\"";
mail($recepient, $pagetitle, $message, "Content-type: text/plain; charset=\"utf-8\"\n From: $recepient");
?>