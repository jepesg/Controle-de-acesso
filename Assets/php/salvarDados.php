<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include 'conectaDB.php';
//DEFINE CABEÇALHO PARA O JSON
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validação dos campos obrigatórios
    if (!isset($_POST['name']) || !isset($_POST['data']) || !isset($_POST['entrada']) || !isset($_POST['info'])) {
        echo json_encode(["status" => "error", "message" => "Por favor, preencha todos os campos obrigatórios."]);
        exit;
    }

    // OBTEM OS DADOS
    $nome = htmlspecialchars(trim($_POST['name']));
    $placa = isset($_POST['placaVeiculo']) ? htmlspecialchars(trim($_POST['placaVeiculo'])) : null;
    $data = $_POST['data'];
    $entrada = $_POST['entrada'];
    $saida = !empty($_POST['saida']) ? $_POST['saida'] : null;
    $observacoes = htmlspecialchars(trim($_POST['info']));

    // VALIDA DATA E HORAS VALIDAS 
        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $data)) {
        echo json_encode(["status" => "error", "message" => "Data inválida. Formato esperado: AAAA-MM-DD."]);
        exit;
    }
    if (!preg_match("/^\d{2}:\d{2}$/", $entrada) || ($saida && !preg_match("/^\d{2}:\d{2}$/", $saida))) {
        echo json_encode(["status" => "error", "message" => "Horário inválido. Formato esperado: HH:MM."]);
        exit;
    }

    // PREAPRA A QUERY
    $sql = "INSERT INTO registros (NOME, PLACA_VEICULO, DATA, ENTRADA, SAIDA, OBSERVACOES)
            VALUES (?, ?, ?, ?, ?, ?)";

    // EVITA SQL INJECTION
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssss", $nome, $placa, $data, $entrada, $saida, $observacoes);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Registro salvo com sucesso!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao salvar registro: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Erro na preparação da query: " . $conn->error]);
    }

    $conn->close();
}
