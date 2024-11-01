async function carregarRegistros() {
    const response = await fetch('/Assets/php/listarDados.php');
    const registros = await response.json();

    const listaRegistro = document.getElementById('exportData'); // Altere para o ID correto
    listaRegistro.innerHTML = '';  // Limpa a tabela antes de inserir novos dados

    if (Array.isArray(registros)) {
        registros.forEach(registro => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${registro.nome}</td>
                <td>${registro.placaVeiculo || '-'}</td>
                <td>${registro.data}</td>
                <td>${registro.entrada}</td>
                <td>${registro.saida || '-'}</td>
                <td>${registro.observacoes}</td>
                <td>${registro.acoes}</td>
            `;
            listaRegistro.appendChild(row);
        });
    }
}

// Carregar os registros ao carregar a página
document.addEventListener('DOMContentLoaded', carregarRegistros);
