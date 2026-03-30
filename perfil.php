<link rel="stylesheet" href="resultados.css">
<?php

try {
    $conexion = new PDO('mysql:host=localhost;dbname=musicos','root', '');
   
} catch (PDOException $e) {
    echo 'Falló la conexión: ' . $e->getMessage();
}

if (isset($_GET['buscar'])) {
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
        echo "<li><a href='perfil.php?id=" . $fila['ID'] . "'>" . htmlspecialchars($fila['nombreArti']) . "</a></li>";
    }
    foreach ($resultados2 as $fila) {
        echo "<li><a href='perfil.php?id=" . $fila['ID'] . "'>" . htmlspecialchars($fila['usuario']) . "</a></li>";
    }
    echo "</ul>";

    if (empty($resultados1) && empty($resultados2)) {
        echo "No se encontraron resultados para '" . htmlspecialchars($busqueda) . "'.";
    }
} else {
    echo "Por favor, ingresa un término de búsqueda.";
}
?>