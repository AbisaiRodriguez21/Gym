<?php
$conn = new mysqli("localhost", "desarrollador", "", "gimnasio");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && 
    isset($_POST['nombre']) && 
    isset($_POST['edad']) && 
    isset($_POST['nacimiento']) && 
    isset($_POST['genero']) && 
    isset($_POST['email']) && 
    isset($_POST['telefono']) && 
    isset($_POST['direccion']) && 
    isset($_POST['tipoMembresia']) && 
    isset($_POST['numerodesocio']) && 
    isset($_POST['fechaInicio']) && 
    isset($_POST['fechaFin'])) {

    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $nacimiento = $_POST['nacimiento'];
    $genero = $_POST['genero'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $tipoMembresia = $_POST['tipoMembresia'];
    $numerodesocio = $_POST['numerodesocio'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];

    $sql = "INSERT INTO usuarios (nombre, edad, fechaNacimiento, genero, correo, telefono, direccion, NoSocio, TipoMembresia, FechaInicio, FechaFin) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }


    $stmt->bind_param("sisssssssss", $nombre, $edad, $nacimiento, $genero, $email, $telefono, $direccion, $numerodesocio, $tipoMembresia, $fechaInicio, $fechaFin);

   
    if ($stmt->execute()) {
        $message = "Usuario almacenado correctamente";
        echo "<script>
                alert('$message');
                window.location.href = 'Principal.html'; // Cambiar 'perfil.html' por la página a la que quieres redirigir
              </script>";
    } else {
        echo "Error al registrar: " . $stmt->error;
    }

    // Cerrar la consulta y la conexión
    $stmt->close();
    $conn->close();
} else {
    echo "Datos incompletos.";
}
?>
