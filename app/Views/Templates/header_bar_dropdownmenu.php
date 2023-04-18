<?php
foreach ($categoria as $categoria){
  echo  "<a href=/productos/categoria/".$categoria['id_categoria'].">".$categoria['nombre_categoria']."</a>";
}

?>

