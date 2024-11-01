document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector('#formCad'); // Seleciona o formulário pelo seletor

    if (form instanceof HTMLFormElement) { // Verifica se é um formulário
        form.addEventListener('submit', async function(event) {
            event.preventDefault();  // Evita o envio padrão do formulário

            // Cria um objeto FormData com os dados do formulário
            const formData = new FormData(form);

            try {
                const response = await fetch('/Assets/php/salvarDados.php', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error('Erro na resposta do servidor');
                }

                const data = await response.json(); // Analisa a resposta como JSON
                console.log(data); // Acessa os dados do JSON
            } catch (error) {
                console.error('Erro:', error); 
            }
        });
    } else {
        console.error("Elemento com id 'formCad' não é um formulário HTML!");
    }
});
