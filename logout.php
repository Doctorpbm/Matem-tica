<?php
header("Access-Control-Allow-Origin: https://matem-tica.vercel.app/"); // ou substitua * pelo domínio da Vercel, ex: https://meusite.vercel.app
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

session_start();
session_destroy();

echo json_encode([
    'success' => true,
    'message' => 'Logout realizado com sucesso.'
]);
?>
