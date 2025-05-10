<?php
$servername = "database-2.cdku2ia0sqoy.us-east-2.rds.amazonaws.com";
$username = "admin";
$password = "xrl8melhoralien";
$dbname = "questionsmath";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
echo "Conexão bem-sucedida!";
?>
