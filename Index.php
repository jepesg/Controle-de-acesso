<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Assets/Global.css">
    <link rel="stylesheet" href="/Assets/Index.css">
    <title>Tela de anotação</title>
</head>

<body>
    <header id="menu" class="menu">
        <button class="exit" id="exit">
            Sair
        </button>
    </header>
    <div">
        <form class="formCad" id="formCad">
            <label for="nome">
                Nome:
            </label>
            <input type="text" name="name" id="name" placeholder="Insira o nome do colaborador/motorista" required>
            <label for="placa">
                Placa do Veiculo:
            </label>
            <input type="text" name="placaVeiculo" id="placaVeiculo" placeholder="Insira a placa do veiculo (AAA-1234)">
            <label for="dia">
                Dia:
            </label>
            <input type="date" name="data" id="data" placeholder="Data" required>
            <label for="entrada">
                Hora da entrada
            </label>
            <input type="time" name="entrada" id="entrada" placeholder="Horario de entrada" required>
            <label for="saida">
                Saida:
            </label>
            <input type="time" name="saida" id="saida" placeholder="Horario de Saida">
            <label for="infos">
                Observações
            </label>
            <input type="text" name="info" id="info" placeholder="Insira as observações" required>
            <button class="submit" id="submit">
                Salvar
            </button>
            <button class="reset" id="reset">
                Limpar
            </button>
        </form>
    </div>
<!-- Modal para exportar como Excel -->
<table id="exportTable" class="exportTable">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Placa</th>
            <th>Dia</th>
            <th>Entrada</th>
            <th>Saída</th>
            <th>Observações</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody id="exportData">
        <!-- Dados serão inseridos aqui dinamicamente -->
    </tbody>
</table>

<div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeEditModal">&times;</span>
            <h2>Editar Registro</h2>
            <form id="editForm">
                <label for="editName">Nome:</label>
                <input type="text" id="editName" required>
                <label for="editPlacaVeiculo">Placa do Veículo:</label>
                <input type="text" id="editPlacaVeiculo">
                <label for="editData">Dia:</label>
                <input type="date" id="editData" required>
                <label for="editEntrada">Hora de Entrada:</label>
                <input type="time" id="editEntrada" required>
                <label for="editSaida">Hora de Saída:</label>
                <input type="time" id="editSaida">
                <label for="editInfo">Observações:</label>
                <input type="text" id="editInfo" required>
                <button type="button" id="saveEditBtn">Salvar Alterações</button>
                <button type="button" class="open-modal" id="openModal">Exportar CSV</button>
            </form>
        </div>
    </div>
</body>


<script src="/Assets/js/exibeDados.js"></script>
<script src="/Assets/js/salvarDados.js"></script>
<script src="/Assets/js/abreModal.js"></script>
</html>