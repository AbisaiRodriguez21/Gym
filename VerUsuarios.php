<?php
$conn = new mysqli("localhost", "desarrollador", "", "gimnasio");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['numSocio'])) {
    // Si es una solicitud POST con el parámetro numSocio, buscar por número de socio
    $numSocio = $_POST['numSocio'];

    $sql = "SELECT nombre, edad, fechaNacimiento, genero, correo, telefono, direccion, NoSocio, TipoMembresia, FechaInicio, FechaFin 
            FROM usuarios 
            WHERE NoSocio = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $numSocio);
    $stmt->execute();
    $result = $stmt->get_result();

    $usuarios = array();
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }

    $stmt->close();
    echo json_encode($usuarios);
} else {
    // Si es una solicitud GET o no se proporciona el parámetro numSocio por POST, mostrar todos los usuarios
    $sql = "SELECT nombre, edad, fechaNacimiento, genero, correo, telefono, direccion, NoSocio, TipoMembresia, FechaInicio, FechaFin FROM usuarios";
    $result = $conn->query($sql);

    $usuarios = array();
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }

    echo json_encode($usuarios);
}

$conn->close();
?>
