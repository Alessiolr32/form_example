<?php

function loadEnv($path) {
$lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$env = [];
foreach ($lines as $line) {
if (strpos(trim($line), '#') === 0) continue;
[$key, $value] = explode('=', $line, 2);
$env[trim($key)] = trim($value);
}
return $env;
}


$env = loadEnv(__DIR__ . '/.env');

$servername = $env['DB_HOST'];
$port       = $env['DB_PORT'];
$dbname     = $env['DB_NAME'];
$username   = $env['DB_USER'];
$dbpassword = $env['DB_PASSWORD'];



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
// password_verify($password, $password_hash)


$conn = new mysqli($servername, $username, $dbpassword, $dbname, $port);

if ($conn->connect_error) {
die("Connessione al database fallita: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO users (name, last_name, email, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $last_name, $email, $password_hash);

if ($stmt->execute()) {
echo "Registrazione avvenuta con successo! <br> Nome: $name <br> Cognome: $last_name <br> Email: $email <br>";
} else {
echo "Registrazione fallita: " . $stmt->error;
}

$stmt->close();
$conn->close();