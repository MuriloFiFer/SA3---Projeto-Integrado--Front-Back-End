<?php

$servername = "localhost";
$username = "postgres";
$password = "postgres";
$dbname = "murilo"; // nome do banco
try {
    // sgbd:host;port;dbname
    // usuario
    // senha
    // errmode
    $pdo = new PDO(
        "pgsql:host=$servername;port=5432;dbname=$username",
        $password,
        $dbname,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
 //   echo "Conectado no banco de dados!!!";
} catch (PDOException $e) {
    echo "Falha ao conectar ao banco de dados. <br/>";
    die($e->getMessage());
}