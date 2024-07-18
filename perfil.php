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

// Query para obtener datos del perfil
$sql = "SELECT foto, NombrePerfil, Edad FROM perfil"; // Ajusta según tu estructura de base de datos
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Obtener los datos del perfil
    $row = $result->fetch_assoc();
    $nombre = $row["NombrePerfil"];
    $edad = $row["Edad"];
    $fotoContenido = base64_encode($row["foto"]); // Si la imagen está guardada como BLOB en la base de datos
} else {
    echo "No se encontraron resultados.";
}

// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil</title>
    <style>
        .perfil-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 50px;
        }

        .perfil-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .perfil-foto {
            width: 100px;
            height: 100px;
            object-fit: cover; /* Asegura que la imagen se recorte y se ajuste al tamaño especificado */
            border-radius: 50%; /* Hace la imagen redonda, opcional */
        }

        .editable-info {
            text-align: center;
        }

        .info-item {
            margin: 10px 0;
        }
        .btnaside {
    margin-top: 40px;
    align-items: center;
    background: linear-gradient(to left, #bbf8f4, #9bfffa);
    color: #212529;
    border: none;
    width: 150px;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.5s ease;
}
.btnaside:hover, .btnheader:hover {

    transform: scale(1.03);
    background: linear-gradient(to top, #88f5ee, #aafffb);
}
    </style>
</head>
<body>
    <div class="perfil-container">
        <div class="perfil-content">
            <!-- Mostrar la foto de perfil -->
            <img id="perfil-foto" src="data:image/jpeg;base64,<?php echo $fotoContenido; ?>" alt="Foto de perfil" class="perfil-foto">
            <div class="editable-info">
                <h3>
                    <div class="info-item">
                        <span id="nombre">Nombre Completo: <?php echo $nombre; ?></span>
                    </div><br>
                    <div class="info-item">
                        <span id="edad">Edad: <?php echo $edad; ?></span>
                    </div>
                </h3>
            </div>
            <button class="btnaside" onclick="modificar()">Modificar</button>
            <button class="btnaside" onclick="cambiarContra()">Cambiar contraseña</button>            
        </div>
    </div>
    <script>
    function modificar() {
            window.location.href = 'perfil.html'; // Redirige a la página perfil.html
        }
        function cambiarContra() {
            window.location.href = 'CambiarContra.html'; // Redirige a la página perfil.html
        }
    </script> 
</body>
</html>
