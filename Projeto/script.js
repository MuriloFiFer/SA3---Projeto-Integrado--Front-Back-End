
document.addEventListener("DOMContentLoaded", function () {
    const users = []; // Simulação de armazenamento de usuários

    const userIndicator = document.getElementById("user-indicator");
    const loggedUserElement = document.getElementById("logged-user");
   const logoutButton = document.getElementById("logout-btn");


if (logoutButton) {
    logoutButton.addEventListener("click", function () {
        localStorage.removeItem("loggedInUser");
        userIndicator.style.display = "none";
        console.log("Usuário desconectado");
        setTimeout(() => {
            window.location.href = "index.html"; // Redireciona para a página de login após o logout
        }, 100);
    });
}


    const loggedInUser = JSON.parse(localStorage.getItem("loggedInUser"));
    if (loggedInUser) {
        userIndicator.style.display = "block";
        loggedUserElement.textContent = loggedInUser.name;

        
    }

    function processLoginForm(event) {
        event.preventDefault();
        const email = document.querySelector(".flip-card__form-login input[name='email']").value;
        const password = document.querySelector(".flip-card__form-login input[name='password']").value;

        if (validateInputs(email, password)) {
            const user = users.find(u => u.email === email && u.password === password);
            if (user) {
                localStorage.setItem("loggedInUser", JSON.stringify(user));
                userIndicator.style.display = "block";
                loggedUserElement.textContent = user.name;

                displayMessage("Logado!", "login");
                clearForm(".flip-card__form-login");
            } else {
                displayMessage("Erro ao fazer login. Verifique suas credenciais.", "login");
            }
        }
    }

    function processRegisterForm(event) {
        event.preventDefault();
        const name = document.querySelector(".flip-card__form-register input[name='name']").value;
        const email = document.querySelector(".flip-card__form-register input[name='email']").value;
        const password = document.querySelector(".flip-card__form-register input[name='password']").value;

        if (validateInputs(name, email, password)) {
            const existingUser = users.find(u => u.email === email);
            if (existingUser) {
                displayMessage("Usuário já cadastrado!", "register");
            } else {
                const newUser = { name, email, password };
                users.push(newUser);

                displayMessage("Usuário cadastrado!", "register");
                console.log("Cadastro bem-sucedido!", name, email);
                clearForm(".flip-card__form-register");
            }
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
