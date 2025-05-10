<?php
$servername = "database-2.cdku2ia0sqoy.us-east-2.rds.amazonaws.com";
$username = "admin"; // substitua aqui
$password = "xrl8melhoralien";   // substitua aqui
$dbname = "questionsmath";          // nome do seu banco

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";


$login = $_POST['logins'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuarios WHERE login = ? AND senha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $login, $senha);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['usuario'] = $login;
    echo "<script>
        function toggleForms() {
          const login = document.getElementById('loginForm');
          const cadastro = document.getElementById('cadastroForm');
          login.classList.toggle('hidden');
          cadastro.classList.toggle('hidden');
        }
      </script>";
} else {
    echo "Login inválido.";
}

$conn->close();

?>