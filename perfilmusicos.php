<?php
try{
    $conexion = new PDO('mysql:host=localhost;dbname=musicos','root', '');
    echo ".";
} catch (PDOException $e) {
    echo 'Falló la conexión: ' . $e->getMessage();
}

 if ($_POST){
    $nombre = $_POST['nombre'];
    $genero = $_POST['genero'];
    $descripcion = $_POST['descripcion'];
    $temas = $_POST['canciones'];
    }
    try{
        
         $sql = "INSERT INTO usuariosemergentes (usuario,GeneroMusi ,descripcion, temas ) VALUES ('$nombre', '$genero', '$descripcion','$temas');"; 
        $conexion->query($sql);
        echo "Producto insertado correctamente."; 
   
        $Datos = $conexion->query("SELECT * FROM usuariosemergentes");
      

foreach ($Datos as $dato) {
    echo "<div class='dato-ingresado'>";
    echo "Datos correctamente ingresados<br>";
    echo "</div>";
}


 } catch (PDOException $e) {
        echo "Error al insertar el producto: " . $e->getMessage();


    }

?>
   <input type="button" value="Volver" onclick="history.back()">