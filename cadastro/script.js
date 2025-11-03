// Captura o formulário e adiciona um evento ao enviar
document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Impede o envio padrão para processamento local

    // Captura valores dos campos
    const userEmail = document.getElementById('userEmail').value.trim();
    const password = document.getElementById('password').value;

    // Validação simples dos dados
    if(userEmail === '' || password === '') {
        alert('Por favor, preencha todos os campos.');
        return;
    }

    // Aqui, você adicionaria chamada para o backend para autenticar
    // Simulando com um alerta para demonstração
    if(userEmail === 'usuario@la.com' && password === '123456') {
        alert('Login realizado com sucesso!');
        // Redirecionar para área autenticada, por exemplo:
        // window.location.href = 'painel.html';
    } else {
        alert('Usuário ou senha inválidos. Tente novamente.');
    }
});
