<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter dados do corpo da solicitação
    $data = json_decode(file_get_contents('php://input'), true);

    // Simulação de armazenamento de usuários
    $users = [];

    // Adicionar validações e lógica de login real aqui
    $user = array_filter($users, function ($u) use ($data) {
        return $u['email'] === $data['email'] && $u['password'] === $data['password'];
    });

    if (count($user) > 0) {
        echo json_encode(['success' => true, 'message' => 'Login bem-sucedido.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Credenciais inválidas.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}
?>
