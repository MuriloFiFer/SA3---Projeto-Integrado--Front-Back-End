<?php

// Conecta ao banco
$servername = "localhost";
$username = "postgres";
$password = "postgres";
$dbname = "murilo"; // nome do banco
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash da senha para segurança

    // Query SQL para inserir os dados no banco de dados
    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";

    // Cria uma declaração preparada
    $stmt = $conn->prepare($sql);

    // Verifica se a declaração preparada foi bem-sucedida
    if ($stmt === false) {
        die("Erro na declaração preparada: " . $conn->error);
    }

    // Binda os parâmetros
    $stmt->bind_param("sss", $name, $email, $password);

    // Executa a declaração preparada
    if ($stmt->execute()) {
        echo "Usuário registrado com sucesso!";
    } else {
        echo "Erro ao registrar o usuário: " . $stmt->error;
    }

    // Fecha a declaração preparada
    $stmt->close();
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
