<?php
// Obtener los datos del formulario
if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Conexión a la base de datos usando MySQLi
    $conexion = new mysqli('localhost', 'desarrollador', '', 'gimnasio');

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Consulta para buscar el usuario en la base de datos
    $sql = "SELECT id, usuario, contrasena FROM administrador WHERE usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    // Verificar si se encontró un usuario
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $usuario_bd, $contrasena_bd);
        $stmt->fetch();

        // Verificar la contraseña utilizando md5
        if (md5($contrasena) === $contrasena_bd) {
            // Inicio de sesión exitoso
            session_start();
            $_SESSION['id'] = $id;
            $_SESSION['usuario'] = $usuario_bd;

            // Redirigir al usuario a la página principal
            header("Location: Principal.html");
            exit();
        } else {
            $message = "Usuario o contraseña incorrectos";
            echo "<script>
                    alert('$message');
                    window.location.href = 'login.html'; // Cambiar 'perfil.html' por la página a la que quieres redirigir
                  </script>";
        }
    } else {
        $message = "Usuario o contraseña incorrectos";
        echo "<script>
                alert('$message');
                window.location.href = 'login.html'; // Cambiar 'perfil.html' por la página a la que quieres redirigir
              </script>";    }

    // Cerrar la conexión y el statement
    $stmt->close();
    $conexion->close();
} else {
    echo 'Datos no recibidos del formulario'; // Datos no recibidos del formulario
}
?>
