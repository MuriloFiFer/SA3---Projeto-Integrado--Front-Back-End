document.addEventListener("DOMContentLoaded", function () {
    // Simulação de armazenamento de usuários
    let users = [];

    function sendUserData(url, data, formType) {
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(result => {
            displayMessage(result.message, formType);

            if (result.success) {
                // Limpar formulário ou realizar outras ações após sucesso
                clearForm(`.flip-card__form-${formType}`);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            displayMessage('Erro ao processar a requisição.', formType);
        });
    }

    function processLoginForm(event) {
        event.preventDefault();

        const email = document.querySelector(".flip-card__form-login input[name='email']").value;
        const password = document.querySelector(".flip-card__form-login input[name='password']").value;

        if (validateInputs(email, password)) {
            const data = { email, password };
            sendUserData('login.php', data, 'login');
        }
    }

    function processRegisterForm(event) {
        event.preventDefault();

        const name = document.querySelector(".flip-card__form-register input[name='name']").value;
        const email = document.querySelector(".flip-card__form-register input[name='email']").value;
        const password = document.querySelector(".flip-card__form-register input[name='password']").value;

        if (validateInputs(name, email, password)) {
            const data = { name, email, password };
            sendUserData('register.php', data, 'register');
        }
    }

    function validateInputs(...inputs) {
        for (const input of inputs) {
            if (!input || input.trim() === "") {
                displayMessage("Por favor, preencha todos os campos.", "register");
                return false;
            }
        }
        return true;
    }

    function displayMessage(message, formType) {
        const messageElement = document.createElement("div");
        messageElement.textContent = message;
        messageElement.classList.add("message");

        const messages = document.querySelectorAll(`.${formType} .message`);
        messages.forEach(msg => msg.remove());

        const targetElement = document.querySelector(`.flip-card__form-${formType}`);
        targetElement.appendChild(messageElement);

        setTimeout(() => {
            messageElement.remove();
        }, 3000);
    }

    function clearForm(formSelector) {
        const formInputs = document.querySelectorAll(`${formSelector} input`);
        formInputs.forEach(input => (input.value = ""));
    }

    document.querySelector(".flip-card__form-login").addEventListener("submit", processLoginForm);
    document.querySelector(".flip-card__form-register").addEventListener("submit", processRegisterForm);
});
