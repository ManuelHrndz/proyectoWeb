<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurante";
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['email'])) {
    $email = urldecode($_GET['email']);
    $nueva_password = $_POST['nueva_password'];
    $confirmar_password = $_POST['confirmar_password'];

    if ($nueva_password === $confirmar_password) {
        $nueva_password_hashed = password_hash($nueva_password, PASSWORD_DEFAULT);

        $sql = "UPDATE clientes SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nueva_password_hashed, $email);

        if ($stmt->execute()) {
            echo "Tu contraseña ha sido actualizada exitosamente.";
        } else {
            echo "Error al actualizar la contraseña.";
        }

        $stmt->close();
    } else {
        echo "Las contraseñas no coinciden.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Establecer Nueva Contraseña</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h2>Elige tu nueva contraseña</h2>
            <form action="nueva_contraseña.php?email=<?php echo urlencode($_GET['email']); ?>" method="post">
                <div class="form-group">
                    <label for="nueva_password">Nueva Contraseña *</label>
                    <input type="password" id="nueva_password" name="nueva_password" placeholder="Ingresa tu nueva contraseña" required>
                </div>
                <div class="form-group">
                    <label for="confirmar_password">Confirmar Contraseña *</label>
                    <input type="password" id="confirmar_password" name="confirmar_password" placeholder="Confirma tu nueva contraseña" required>
                </div>
                <button type="submit" class="btn">Actualizar Contraseña</button>
            </form>
        </div>
    </div>
</body>
</html>
