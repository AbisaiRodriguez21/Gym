<?php
$conn = new mysqli("localhost", "desarrollador", "", "gimnasio");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
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

    // Actualizar los datos del usuario
    $sql = "UPDATE usuarios SET 
            nombre=?, 
            edad=?, 
            fechaNacimiento=?, 
            genero=?, 
            correo=?, 
            telefono=?, 
            direccion=?, 
            TipoMembresia=?, 
            FechaInicio=?, 
            FechaFin=? 
            WHERE NoSocio=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisssssssss", $nombre, $edad, $nacimiento, $genero, $email, $telefono, $direccion, $tipoMembresia, $fechaInicio, $fechaFin, $numerodesocio);

    if ($stmt->execute()) {
        echo "Usuario actualizado correctamente";
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
