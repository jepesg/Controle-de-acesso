<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include 'conectaDB.php';
header('Content-Type: application/json');

// Verifica se é uma requisição para inserção ou consulta
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Consulta para buscar registros
    $sql = "SELECT nome, placaVeiculo, data, entrada, saida, observacoes FROM registros ORDER BY id DESC";
    $result = $conn->query($sql);

    // Verificação de erro na consulta SQL
    if (!$result) {
        echo json_encode([
            'success' => false,
            'message' => 'Erro na consulta SQL: ' . $conn->error
        ]);
        exit();
    }

    // Constrói o array de registros
    $registros = array();
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {  // Atribui o valor retornado a $row
            $registros[] = $row;  // Adiciona $row ao array $registros
        }
    }

    echo json_encode([
        'success' => true,
        'data' => $registros
    ]);
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lê os dados enviados no POST
    $nome = $_POST['nome'];
    $placa = $_POST['placaVeiculo'];
    $data = $_POST['data'];
    $entrada = $_POST['entrada'];
    $saida = $_POST['saida'];
    $observacoes = $_POST['observacoes'];

    // Valida os horários
    if (!preg_match("/^\d{2}:\d{2}$/", $entrada) || ($saida && !preg_match("/^\d{2}:\d{2}$/", $saida))) {
        echo json_encode([
            'success' => false,
            'message' => 'Horário inválido. Formato esperado: HH:MM.'
        ]);
        exit();
    }

    // Prepara a query para inserção
    $sql = "INSERT INTO registros (nome, placaVeiculo, data, entrada, saida, observacoes) VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssss", $nome, $placa, $data, $entrada, $saida, $observacoes);

        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Registro salvo com sucesso!'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao salvar registro: ' . $stmt->error
            ]);
        }
        $stmt->close();
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erro na preparação da query: ' . $conn->error
        ]);
    }
}

$conn->close();
?>
