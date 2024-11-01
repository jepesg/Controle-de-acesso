<?php
// Ativar exibição de erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Inclui o arquivo de conexão
include 'Assets/php/conectaDB.php';

// Recebe os dados de login via JSON
$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true);

// Verifica se o JSON foi decodificado corretamente
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'Erro ao decodificar JSON: ' . json_last_error_msg()]);
    exit;
}

// Verifica se os dados foram recebidos corretamente
$user = trim($data['user'] ?? '');
$pass = trim($data['pass'] ?? '');

if (empty($user) || empty($pass)) {
    echo json_encode(['success' => false, 'message' => 'Por favor, preencha todos os campos.']);
    exit;
}

// Verifica se a conexão com o banco foi estabelecida
if (!isset($conn) || !$conn instanceof PDO) {
    echo json_encode(['success' => false, 'message' => 'Erro ao conectar ao banco de dados.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepara a consulta SQL para verificar o usuário
    $stmt = $conn->prepare("SELECT * FROM tb_user WHERE USUARIO = :USUARIO");
    $stmt->bindParam(':USUARIO', $user);
    $stmt->execute();

    // Busca os dados do usuário
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o usuário foi encontrado e se a senha é válida
    if ($userData && isset($userData['password']) && password_verify($pass, $userData['password'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $userData['username']; // Salva o nome do usuário na sessão
        echo json_encode(['success' => true, 'message' => 'Login bem-sucedido']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Credenciais inválidas.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método de requisição inválido.']);
}
