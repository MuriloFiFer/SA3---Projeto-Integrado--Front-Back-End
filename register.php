<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter dados do corpo da solicitação
    $data = json_decode(file_get_contents('php://input'), true);

    // Simulação de armazenamento de usuários
    $users = [];

    // Adicionar validações e lógica de armazenamento real aqui
    // Exemplo: verificar se o e-mail já está em uso
    $existingUser = array_filter($users, function ($user) use ($data) {
        return $user['email'] === $data['email'];
    });

    if (count($existingUser) > 0) {
        echo json_encode(['success' => false, 'message' => 'Usuário já cadastrado.']);
    } else {
        // Simulação de armazenamento de usuário
        $users[] = $data;

        echo json_encode(['success' => true, 'message' => 'Usuário cadastrado com sucesso.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}
?>
