<?php
  $cadena = mysqli_query($conexion,"SELECT
              id_promotor,
              (
                SELECT
                  CONCAT(nombre, ' ', ap_paterno)
                FROM
                  promotores
                WHERE
                  promotores.id = agenda_promotores.id_promotor
              ) AS Nombre,
              (
                SELECT
                  compañia
                FROM
                  promotores
                WHERE
                  promotores.id = agenda_promotores.id_promotor
              )AS Compañia,
              dia
            FROM
              agenda_promotores 
            WHERE
              dia = '$fecha'");
  while ($row = mysqli_fetch_array($cadena)) {
    $cadena2 = "SELECT cantidad_horas FROM promotores WHERE id = '$row[0]'";
?>
  <div class="col-sm-6 col-md-3">
    <a onclick="abrir_promotor(<?php echo $row[0]?>)" class="thumbnail">
      <img src="imagenes/1.jpg" alt="imagen_promotor">
    </a>
    <div class="text-center">
      <input type="text" name="id_promotor" id="id_promotor" value="<?php echo $row[0]?>" class="hidden">
      <h3><?php echo $row[1]?></h3>
      <h4><?php echo $row[2]?></h4>
      <a class="btn btn-danger" onclick="abrir(<?php echo $row[0]?>)">Iniciar</a>
    </div>
  </div>
<?php
  }
?>