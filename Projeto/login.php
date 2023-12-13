<?php
session_start();
require_once('config.php');


// Conectar ao banco de dados
$servername = "localhost";
$username = "postgres";
$password = "postgres";
$dbname = "murilo"; //

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Erro na declaração preparada: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["senha"])) {
            // Login bem-sucedido
            $_SESSION["user_id"] = $row["id"]; // Você pode armazenar outras informações na sessão conforme necessário
            echo "Login bem-sucedido!";
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "Usuário não encontrado!";
    }

    $stmt->close();
}

$conn->close();
?>
