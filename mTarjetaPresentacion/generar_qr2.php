<?php
    include('../plugins/phpqrcode/qrlib.php');
    include '../global_seguridad/verificar_sesion.php';
    //include('config.php');

    // how to build raw content - QRCode with detailed Business Card (VCard)

    $tempDir = 'src/';

    $cadenaEmpleado="SELECT nombre, ap_paterno, e_mail, telefono, telprocede FROM personas WHERE id = '$id_persona'";
    $consultaEmpleado=mysqli_query($conexion,$cadenaEmpleado);
    $row=mysqli_fetch_array($consultaEmpleado);

    function eliminar_tildes($cadena) {
      $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
      $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
      $texto = str_replace($no_permitidas, $permitidas ,$cadena);
      return $texto;
      }

    $nombre=eliminar_tildes($row[0]);
    $ap_paterno=eliminar_tildes($row[1]);

    $completo=$nombre.' '.$ap_paterno;

    // here our data
    $name         = $completo;
    $sortName     = $completo;
    $phone        = $row[4];
    $phonePrivate = $row[3];
    $phoneCell    = $row[3];
    $orgName      = 'La Mision Supermercados';

    $email        = $row[2];

    // if not used - leave blank!
    $addressLabel     = 'La Mision Diaz Ordaz';
    $addressPobox     = '';
    $addressExt       = '901';
    $addressStreet    = 'Calle Gustavo Diaz Ordaz';
    $addressTown      = 'Linares, NL';
    $addressRegion    = 'Centro';
    $addressPostCode  = '67700';
    $addressCountry   = 'Mexico';

    // we building raw data
    $codeContents  = 'BEGIN:VCARD'."\n";
    $codeContents .= 'VERSION:2.1'."\n";
    $codeContents .= 'N:'.$sortName."\n";
    $codeContents .= 'FN:'.$name."\n";
    $codeContents .= 'ORG:'.$orgName."\n";

    $codeContents .= 'TEL;WORK;VOICE:'.$phone."\n";
    $codeContents .= 'TEL;HOME;VOICE:'.$phonePrivate."\n";
    $codeContents .= 'TEL;TYPE=cell:'.$phoneCell."\n";
    
    $codeContents .= 'EMAIL:'.$email."\n";

    $codeContents .= 'END:VCARD';

    // generating
    QRcode::png($codeContents, $tempDir.'qr_'.$id_persona.'.png', QR_ECLEVEL_L, 6, 4);

    // displaying
    //echo '<img src="src/qr_'.$id_persona.'.png" />';
  ?>