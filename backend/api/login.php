<?php
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../config/db.php';

requirePost();
$input = getJsonInput();

$email    = strtolower(trim($input['email'] ?? ''));
$password = $input['password'] ?? '';

if ($email === '' || $password === '') {
    jsonResponse(['success' => false, 'message' => 'Correo y contraseña son obligatorios'], 400);
}

try {
    $pdo  = getConnection();
    $stmt = $pdo->prepare('SELECT id, name, email, password FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password'])) {
        jsonResponse(['success' => false, 'message' => 'Credenciales incorrectas'], 401);
    }

    jsonResponse([
        'success' => true,
        'message' => 'Inicio de sesión exitoso',
        'user'    => [
            'id'    => (int) $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
        ],
    ]);
} catch (PDOException $e) {
    jsonResponse(['success' => false, 'message' => 'Error del servidor'], 500);
}
