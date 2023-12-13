<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bancoanimart"; // nome do banco

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Recuperar dados do formulário
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Hash da senha (recomendado para segurança)
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Usar instruções preparadas para evitar injeção de SQL
$sql = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$sql->bind_param("sss", $name, $email, $hashedPassword);

if ($sql->execute()) {
    echo "Usuário registrado com sucesso!";
} else {
    echo "Erro ao registrar usuário: " . $sql->error;
}

$sql->close();
$conn->close();
?>
