<link rel="stylesheet" href="resultados.css">
<?php

try {
    $conexion = new PDO('mysql:host=localhost;dbname=musicos','root', '');
} catch (PDOException $e) {
    echo 'Falló la conexión: ' . $e->getMessage();
    exit;
}

// Mostrar información completa según tipo
if (isset($_GET['id']) && isset($_GET['tipo'])) {
    $id = $_GET['id'];
    $tipo = $_GET['tipo'];

    if ($tipo == "usuario") {
        $sql = "SELECT * FROM usuarios WHERE ID = ?";
    } else {
        $sql = "SELECT * FROM usuariosemergentes WHERE ID = ?";
    }
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$id]);
    $musico = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($musico) {
        echo "<h2>Información de " . htmlspecialchars($musico['nombreArti'] ?? $musico['usuario']) . "</h2>";
        if (!empty($musico['imagen'])) {
            echo "<img src='imagenes/" . htmlspecialchars($musico['imagen']) . "' class='img-perfil' alt='Foto de " . htmlspecialchars($musico['nombreArti'] ?? $musico['usuario']) . "'><br>";
        }
        echo "<b>Género:</b> " . htmlspecialchars($musico['generomusi'] ?? $musico['GeneroMusi'] ?? '') . "<br>";
        echo "<b>Descripción:</b> " . htmlspecialchars($musico['descripcion'] ?? '') . "<br>";
        if (isset($musico['temas'])) {
            echo "<b>Temas:</b> " . htmlspecialchars($musico['temas']) . "<br>";
        }
        echo "<hr>";
    } else {
        echo "No se encontró el músico.";
    }
}
// Mostrar resultados de búsqueda como enlaces
else if (isset($_GET['buscar'])) {
    $busqueda = $_GET['buscar'];

    // Buscar en usuarios
    $sql1 = "SELECT ID, nombreArti FROM usuarios WHERE nombreArti LIKE ?";
    $stmt1 = $conexion->prepare($sql1);
    $stmt1->execute(['%' . $busqueda . '%']);
    $resultados1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    // Buscar en usuariosemergentes
    $sql2 = "SELECT ID, usuario FROM usuariosemergentes WHERE usuario LIKE ?";
    $stmt2 = $conexion->prepare($sql2);
    $stmt2->execute(['%' . $busqueda . '%']);
    $resultados2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Resultados de la búsqueda para '" . htmlspecialchars($busqueda) . "'</h2>";
    echo "<ul>";
    foreach ($resultados1 as $fila) {
        echo "<li><a href='resultados.php?id=" . $fila['ID'] . "&tipo=usuario'>" . htmlspecialchars($fila['nombreArti']) . "</a></li>";
    }
    foreach ($resultados2 as $fila) {
        echo "<li><a href='resultados.php?id=" . $fila['ID'] . "&tipo=emergente'>" . htmlspecialchars($fila['usuario']) . "</a></li>";
    }
    echo "</ul>";

    if (empty($resultados1) && empty($resultados2)) {
        echo "No se encontraron resultados para '" . htmlspecialchars($busqueda) . "'.";
    }
}
// Mostrar todos los músicos como enlaces si no hay búsqueda
else {
    echo "<h2>Todos los músicos guardados</h2>";
    echo "<ul>";

    $sql1 = "SELECT ID, nombreArti FROM usuarios";
    $stmt1 = $conexion->query($sql1);
    foreach ($stmt1 as $fila) {
        echo "<li><a href='resultados.php?id=" . $fila['ID'] . "&tipo=usuario'>" . htmlspecialchars($fila['nombreArti']) . "</a></li>";
    }

    $sql2 = "SELECT ID, usuario FROM usuariosemergentes";
    $stmt2 = $conexion->query($sql2);
    foreach ($stmt2 as $fila) {
        echo "<li><a href='resultados.php?id=" . $fila['ID'] . "&tipo=emergente'>" . htmlspecialchars($fila['usuario']) . "</a></li>";
    }
    echo "</ul>";
}
?>
    <input type="button" value="Volver" onclick="history.back()">