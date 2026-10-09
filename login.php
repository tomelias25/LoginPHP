<?php
session_start();
require 'config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT id_user, nombre, email, password FROM usuarios WHERE email = ?');
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($password, $usuario['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $usuario['id_user'];
        $_SESSION['nombre']  = $usuario['nombre'];
        header('Location: dashboard.php');
        exit;
    }
    $error = 'Correo o contraseña incorrectos.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
</head>
<body>
  <h2>Iniciar sesión</h2>
  <?php if ($error): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>
  <form method="post">
    <input type="email" name="email" placeholder="Correo" required><br><br>
    <input type="password" name="password" placeholder="Contraseña" required><br><br>
    <button type="submit">Entrar</button>
  </form>
</body>
</html>