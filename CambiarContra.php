<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Configuración de la base de datos
    $servername = "localhost"; // o la dirección de tu servidor de base de datos
    $username = "root"; // tu nombre de usuario de la base de datos
    $password = ""; // tu contraseña de la base de datos
    $dbname = "gimnasio"; // el nombre de tu base de datos

    // Recibir datos del formulario
    $usuarioNuevo = $_POST['usuarioNuevo'];
    $contraNueva = $_POST['contraNueva'];
    $confirmarContra = $_POST['confirmarContra'];

    // Verificar si la nueva contraseña coincide con la confirmación
    if ($contraNueva !== $confirmarContra) {
        die("Las nuevas contraseñas no coinciden.");
    }

    // Conectar a la base de datos
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Hashear la nueva contraseña (aquí asumimos que usamos MD5, aunque es recomendable usar métodos más seguros como bcrypt)
    $contraNueva = md5($contraNueva);

    // Actualizar el nombre de usuario y la contraseña en la base de datos
    $sql = "UPDATE administrador SET usuario = ?, contrasena = ? WHERE id = 1"; // Suponiendo que el ID del administrador es siempre 1
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $usuarioNuevo, $contraNueva);
    if ($stmt->execute()) {
        $message = "Usuario y contraseña actualizados correctamente.";
        echo "<script>
                alert('$message');
                window.location.href = 'login.html'; // Cambiar 'perfil.html' por la página a la que quieres redirigir
              </script>";
    } else {
        echo "Error al actualizar el usuario y la contraseña: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
} else {
    // Si no se envió el formulario por POST, puedes mostrar un mensaje de error o redirigir a otra página.
    echo "No se han recibido datos del formulario.";
}
?>
