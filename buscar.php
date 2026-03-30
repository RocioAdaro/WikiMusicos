
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WIMU</title>
    <link rel="stylesheet" href="BUSCAR.css">
    <link rel="stylesheet" href="inicio.html">
</head>
<body>
    <form method="post" action="buscar.php">
        <input type="text" name="buscar" placeholder="Buscar artista">
        <button type="submit">Buscar</button>
    </form>
    <br>

    <?php
    try {
        $conexion = new PDO('mysql:host=localhost;dbname=musicos','root', '');
    } catch (PDOException $e) {
        echo 'Falló la conexión: ' . $e->getMessage();
    }

    if (isset($_POST["buscar"])) {
        $busqueda = $_POST["buscar"];

        // Buscar en usuarios
        $sql1 = "SELECT nombreArti, generomusi, descripcion FROM usuarios WHERE nombreArti LIKE ?";
        $stmt1 = $conexion->prepare($sql1);
        $stmt1->execute(['%' . $busqueda . '%']);

        // Buscar en usuariosemergentes
        $sql2 = "SELECT usuario, GeneroMusi, descripcion, temas FROM usuariosemergentes WHERE usuario LIKE ?";
        $stmt2 = $conexion->prepare($sql2);
        $stmt2->execute(['%' . $busqueda . '%']);

        $encontrado = false;

        while ($fila = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            echo "<b>Nombre:</b> " . htmlspecialchars($fila["nombreArti"]) . "<br>";
            echo "<b>Género:</b> " . htmlspecialchars($fila["generomusi"]) . "<br>";
            echo "<b>Descripción:</b> " . htmlspecialchars($fila["descripcion"]) . "<br>";
            echo "<hr>";
            $encontrado = true;
        }

        while ($fila = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            echo "<b>Nombre:</b> " . htmlspecialchars($fila["usuario"]) . "<br>";
            echo "<b>Género:</b> " . htmlspecialchars($fila["GeneroMusi"]) . "<br>";
            echo "<b>Descripción:</b> " . htmlspecialchars($fila["descripcion"]) . "<br>";
            echo "<b>Temas:</b> " . htmlspecialchars($fila["temas"]) . "<br>";
            echo "<hr>";
            $encontrado = true;
        }

        if (!$encontrado) {
            echo "No se encontraron resultados.";
        }
    } else {
        echo "Ingrese un nombre para buscar.";
    }
    ?>
  
</body>
</html>  