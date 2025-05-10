<?php
header("Access-Control-Allow-Origin: https://matem-tica.vercel.app/"); // ou substitua * pelo domínio da Vercel, ex: https://meusite.vercel.app
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$servername = "database-2.cdku2ia0sqoy.us-east-2.rds.amazonaws.com";
$username = "admin";
$password = "xrl8melhoralien";
$dbname = "questionsmath";

header('Content-Type: application/json');

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Falha na conexão.']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['logins']) && isset($_POST['senha'])) {
        $login = htmlspecialchars($_POST['logins']);
        $senha = htmlspecialchars($_POST['senha']);

        // Busca o hash da senha do banco de dados
        $sql = "SELECT senha FROM contas WHERE logins = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Erro ao preparar a consulta.']);
            exit();
        }

        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Recupera o hash da senha
            $row = $result->fetch_assoc();
            $hash_senha = $row['senha'];

            // Verifica se a senha fornecida corresponde ao hash
            if (password_verify($senha, $hash_senha)) {
                // Senha correta
                $_SESSION['usuario'] = $login;
                echo json_encode(['success' => true]);
            } else {
                // Senha incorreta
                echo json_encode(['success' => false, 'message' => 'Senha inválida.']);
            }
        } else {
            // Usuário não encontrado
            echo json_encode(['success' => false, 'message' => 'Login inválido.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Campos obrigatórios ausentes.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requisição inválida.']);
}


$conn->close();
?>
