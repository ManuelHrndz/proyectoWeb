<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurante";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $sql = "SELECT * FROM clientes WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: nueva_contraseña.php?email=" . urlencode($email));
        exit();
    } else {
        echo "Correo electrónico no encontrado.";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h2>Restablecer Contraseña</h2>
            <form action="restablecer_contraseña.php" method="post">
                <div class="form-group">
                    <label for="email">Ingresa tu email para restablecer la contraseña</label>
                    <input type="email" id="email" name="email" placeholder="Ingresa tu email" required>
                </div>
                <button type="submit" class="btn">Restablecer</button>
            </form>
        </div>
    </div>
</body>
</html>
