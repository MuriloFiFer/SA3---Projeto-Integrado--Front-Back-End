<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bancoanimart"; // Substitua pelo nome do seu banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Recuperar dados do formulário
$email = $_POST['email'];
$password = $_POST['password'];

// Usar instruções preparadas para evitar injeção de SQL
$sql = $conn->prepare("SELECT * FROM users WHERE email=?");
$sql->bind_param("s", $email);

$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $storedPassword = $row['password'];

    // Verificar se a senha fornecida corresponde à senha armazenada
    if (password_verify($password, $storedPassword)) {
        echo "Login bem-sucedido!";
    } else {
        echo "Erro ao fazer login. Verifique suas credenciais.";
    }
} else {
    echo "Erro ao fazer login. Verifique suas credenciais.";
}

$sql->close();
$conn->close();
?>