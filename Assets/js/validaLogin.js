async function validaLogin() {
    const user = document.getElementsByName("user")[0].value;
    const pass = document.getElementsByName("pass")[0].value;
    const errorMsg = document.getElementById("error-msg");

    errorMsg.textContent = "";

    if (!user || !pass) {
        errorMsg.textContent = "Por favor, preencha todos os campos.";
        return false;
    }

    try {
        const response = await fetch('Assets/php/validaLogin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ user, pass }),
        });
        const data = await response.json();
        if (data.success) {
            window.location.href = 'Index.php';
        } else {
            errorMsg.textContent = data.message || "Credenciais inválidas.";
        }
    } catch (error) {
        errorMsg.textContent = 'Ocorreu um erro. Tente novamente';
        console.error('Erro:', error);
    }

    return false; // Impede o envio padrão do formulário
}