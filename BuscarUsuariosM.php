<?php
$conn = new mysqli("localhost", "desarrollador", "", "gimnasio");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['numSocio'])) {
    $numSocio = $_POST['numSocio'];

    $sql = "SELECT nombre, edad, fechaNacimiento, genero, correo, telefono, direccion, NoSocio, TipoMembresia, FechaInicio, FechaFin 
            FROM usuarios 
            WHERE NoSocio = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("s", $numSocio);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        echo json_encode($usuario);
    } else {
        echo json_encode(null);
    }

    $stmt->close();
} else {
    echo json_encode(array("error" => "Solicitud no válida"));
}

$conn->close();
?>
