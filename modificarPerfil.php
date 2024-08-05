<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "desarrollador";
$password = "";
$dbname = "gimnasio";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario ha sido enviado y los datos necesarios están presentes
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre']) && isset($_POST['edad'])) {
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    
    // Preparar la consulta SQL
    if ($_FILES['perfil-foto']['size'] > 0) {
        $foto = $_FILES['perfil-foto'];

        // Verificar si el archivo es una imagen
        $check = getimagesize($foto['tmp_name']);
        if ($check === false) {
            die("El archivo no es una imagen válida.");
        }

        // Leer el contenido del archivo
        $fotoContenido = file_get_contents($foto['tmp_name']);

        // Actualizar datos incluyendo la imagen de perfil
        $sql = "UPDATE perfil SET foto = ?, NombrePerfil = ?, Edad = ? "; // Cambia el id según tu lógica
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error al preparar la consulta: " . $conn->error);
        }
        $stmt->bind_param("sss", $fotoContenido, $nombre, $edad);
    } else {
        // Actualizar solo nombre y edad
        $sql = "UPDATE perfil SET NombrePerfil = ?, Edad = ? WHERE id = 1"; // Cambia el id según tu lógica
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error al preparar la consulta: " . $conn->error);
        }
        $stmt->bind_param("ss", $nombre, $edad);
    }

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $message = "Datos actualizados correctamente";
        echo "<script>
                alert('$message');
                window.location.href = 'Principal.html'; // Cambia 'Principal.html' por la página a la que deseas redirigir
              </script>";
    } else {
        echo "Error al actualizar los datos: " . $stmt->error;
    }

    // Cerrar el statement
    $stmt->close();
} else {
    echo "Datos no recibidos del formulario.";
}

// Cerrar conexión
$conn->close();
?>
