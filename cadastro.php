<?php
header("Access-Control-Allow-Origin: https://matem-tica.vercel.app/"); // ou substitua * pelo domínio da Vercel, ex: https://meusite.vercel.app
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

header('Content-Type: application/json');

$servername = "database-2.cdku2ia0sqoy.us-east-2.rds.amazonaws.com";
$username = "admin";
$password = "xrl8melhoralien";
$dbname = "questionsmath";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Erro de conexão: " . $conn->connect_error]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['logins']) && isset($_POST['senha'])) {
        $login = trim($_POST['logins']);
        $senha = trim($_POST['senha']);

        if ($login === "" || $senha === "") {
            echo json_encode(["success" => false, "message" => "Não é permitido inserir campos vazios."]);
            exit;
        }

        // Verifica se o usuário já existe
        $check = $conn->prepare("SELECT * FROM contas WHERE logins = ?");
        $check->bind_param("s", $login);
        $check->execute();
        $checkResult = $check->get_result();

        if ($checkResult->num_rows > 0) {
            echo json_encode(["success" => false, "message" => "Usuário já existe."]);
        } else {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO contas (logins, senha) VALUES (?, ?)");
            $stmt->bind_param("ss", $login, $senha_hash);

            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Cadastro realizado com sucesso."]);
            } else {
                echo json_encode(["success" => false, "message" => "Erro ao inserir dados."]);
            }

            $stmt->close();
        }

        $check->close();
    } else {
        echo json_encode(["success" => false, "message" => "Campos obrigatórios ausentes."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método inválido."]);
}

$conn->close();
?>
