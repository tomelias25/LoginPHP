<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<h1>Bienvenido, <?= htmlspecialchars($_SESSION['nombre']) ?></h1>
<a href="logout.php">Cerrar sesión</a>