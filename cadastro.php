<?php
$servername = "database-2.cdku2ia0sqoy.us-east-2.rds.amazonaws.com";
$username = "SEU_USUARIO";
$password = "SUA_SENHA";
$dbname = "questionsmath";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$login = $_POST['logins'];
$senha = $_POST['senha'];

// Verifica se já existe
$check = $conn->prepare("SELECT * FROM usuarios WHERE login = ?");
$check->bind_param("s", $login);
$check->execute();
$checkResult = $check->get_result();

if ($checkResult->num_rows > 0) {
    echo "Usuário já existe.";
} else {
    $stmt = $conn->prepare("INSERT INTO usuarios (login, senha) VALUES (?, ?)");
    $stmt->bind_param("ss", $login, $senha);
    $stmt->execute();
    echo "<script>alert('Cadastro realizado!'); window.location.href='index.html';</script>";
}

$conn->close();
?>
