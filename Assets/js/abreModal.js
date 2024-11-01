document.addEventListener("DOMContentLoaded", function () {
    let currentEditRow;

    const submitBtn = document.getElementById('submit');
    const exportBtn = document.getElementById('exportBtn');
    const openModalBtn = document.getElementById("openModal");
    const closeModalBtn = document.getElementById("closeModal");
    const closeEditModalBtn = document.getElementById("closeEditModal");
    const logoutBtn = document.getElementById('exit'); // Botão de sair
    const formCad = document.getElementById('formCad');
    const saveEditBtn = document.getElementById('saveEditBtn'); // Botão para salvar edição
    const table = document.getElementById('exportData');

    // Função para carregar dados do localStorage
    function loadTableData() {
        const storedData = JSON.parse(localStorage.getItem('tableData')) || [];
        storedData.forEach(rowData => {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${rowData.name}</td>
                <td>${rowData.placaVeiculo}</td>
                <td>${rowData.data}</td>
                <td>${rowData.entrada}</td>
                <td>${rowData.saida}</td>
                <td>${rowData.info}</td>
                <td><button class="editBtn">Editar</button></td>
            `;
            table.appendChild(newRow);

            // Adiciona evento de edição na nova linha
            newRow.querySelector('.editBtn').addEventListener('click', function () {
                openEditModal(newRow);
            });
        });
    }

    // Função para salvar dados no localStorage
    function saveTableData() {
        const rows = document.querySelectorAll("#exportData tr");
        const tableData = Array.from(rows).map(row => {
            return {
                name: row.cells[0].innerText,
                placaVeiculo: row.cells[1].innerText,
                data: row.cells[2].innerText,
                entrada: row.cells[3].innerText,
                saida: row.cells[4].innerText,
                info: row.cells[5].innerText
            };
        });
        localStorage.setItem('tableData', JSON.stringify(tableData));
    }

    // Função para abrir o modal de edição
    function openEditModal(row) {
        currentEditRow = row;
        document.getElementById('editName').value = row.cells[0].innerText;
        document.getElementById('editPlacaVeiculo').value = row.cells[1].innerText;
        document.getElementById('editData').value = row.cells[2].innerText;
        document.getElementById('editEntrada').value = row.cells[3].innerText;
        document.getElementById('editSaida').value = row.cells[4].innerText;
        document.getElementById('editInfo').value = row.cells[5].innerText;
        document.getElementById('editModal').style.display = 'block';
    }

    // Carregar dados salvos ao carregar a página
    loadTableData();

    // Adiciona evento ao botão 'submit', se ele existir
    if (submitBtn) {
        submitBtn.addEventListener('click', function () {
            const name = document.getElementById('name').value;
            const placaVeiculo = document.getElementById('placaVeiculo').value;
            const data = document.getElementById('data').value;
            const entrada = document.getElementById('entrada').value;
            const saida = document.getElementById('saida').value;
            const info = document.getElementById('info').value;

            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${name}</td>
                <td>${placaVeiculo}</td>
                <td>${data}</td>
                <td>${entrada}</td>
                <td>${saida}</td>
                <td>${info}</td>
                <td><button class="editBtn">Editar</button></td>
            `;
            table.appendChild(newRow);

            // Limpa o formulário manualmente
            if (formCad) {
                const inputs = formCad.querySelectorAll('input, textarea');
                inputs.forEach(input => {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = false;
                    } else {
                        input.value = '';
                    }
                });
            }

            // Adiciona evento de edição na nova linha
            newRow.querySelector('.editBtn').addEventListener('click', function () {
                openEditModal(newRow);
            });

            // Salvar dados no localStorage após adicionar nova linha
            saveTableData();
        });
    }

    // Evento para salvar a edição no modal
    if (saveEditBtn) {
        saveEditBtn.addEventListener('click', function () {
            if (currentEditRow) {
                currentEditRow.cells[0].innerText = document.getElementById('editName').value;
                currentEditRow.cells[1].innerText = document.getElementById('editPlacaVeiculo').value;
                currentEditRow.cells[2].innerText = document.getElementById('editData').value;
                currentEditRow.cells[3].innerText = document.getElementById('editEntrada').value;
                currentEditRow.cells[4].innerText = document.getElementById('editSaida').value;
                currentEditRow.cells[5].innerText = document.getElementById('editInfo').value;

                // Fechar modal após salvar
                document.getElementById('editModal').style.display = 'none';

                // Salvar dados no localStorage após edição
                saveTableData();
            }
        });
    }

    // Evento para o botão de sair
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function () {
            // Redireciona para a página de login
            window.location.href = 'Login.php';
        });
    }

    // Abrir modal de exportação
    if (openModalBtn) {
        openModalBtn.onclick = () => document.getElementById("exportModal").style.display = "block";
    }

    // Fechar modal de exportação
    if (closeModalBtn) {
        closeModalBtn.onclick = () => document.getElementById("exportModal").style.display = "none";
    }

    // Fechar modais ao clicar fora deles
    window.onclick = (event) => {
        const exportModal = document.getElementById("exportModal");
        const editModal = document.getElementById("editModal");
        if (event.target === exportModal) exportModal.style.display = "none";
        if (event.target === editModal) editModal.style.display = "none";
    };

    // Fechar modal de edição
    if (closeEditModalBtn) {
        closeEditModalBtn.onclick = () => document.getElementById("editModal").style.display = "none";
    }

    // Exportar dados para CSV
    if (exportBtn) {
        exportBtn.addEventListener('click', function () {
            let csv = [];
            const rows = document.querySelectorAll("#exportTable tr");
            rows.forEach(row => {
                const cols = row.querySelectorAll("td, th");
                const rowData = [];
                cols.forEach(col => rowData.push(col.innerText));
                csv.push(rowData.join(","));
            });
            const csvFile = new Blob([csv.join("\n")], { type: 'text/csv' });
            const downloadLink = document.createElement("a");
            downloadLink.href = URL.createObjectURL(csvFile);
            downloadLink.download = "dados.csv";
            downloadLink.click();
        });
    }
});
