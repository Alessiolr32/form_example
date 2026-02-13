<?php

if (!isset($_POST['name'], $_POST['last_name'], $_POST['email'], $_POST['password'], $_POST['confirm_password'])) {
die("Attenzione, alcuni dati sono mancanti nel form o non sono stati inviati correttamente.");}

$name = trim($_POST['name']);
$last_name = trim($_POST['last_name']);
$email = strtolower(trim($_POST['email']));
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if ($name === "" || $last_name === "" || $email === "" || $password === "" || $confirm_password === "") {
die("Attenzione, tutti i campi sono obbligatori");
}

if ($password !== $confirm_password) {
die("Attenzione, le password non coincidono");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
die("Attenzione, l'email non è valida");
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);






echo "Nome: $name <br> Cognome: $last_name <br> Email: $email <br>";
