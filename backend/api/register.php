<?php
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../config/db.php';

requirePost();
$input = getJsonInput();

$name     = trim($input['name'] ?? '');
$email    = strtolower(trim($input['email'] ?? ''));
$password = $input['password'] ?? '';

if ($name === '' || $email === '' || $password === '') {
    jsonResponse(['success' => false, 'message' => 'Todos los campos son obligatorios'], 400);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(['success' => false, 'message' => 'Correo electrónico inválido'], 400);
}
if (strlen($password) < 6) {
    jsonResponse(['success' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres'], 400);
}

try {
    $pdo = getConnection();

    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        jsonResponse(['success' => false, 'message' => 'El correo ya está registrado'], 409);
    }

    $hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
    $stmt->execute([$name, $email, $hash]);

    jsonResponse(['success' => true, 'message' => 'Usuario registrado correctamente'], 201);
} catch (PDOException $e) {
    jsonResponse(['success' => false, 'message' => 'Error del servidor'], 500);
}
