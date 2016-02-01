<? php
//por Abrahan Apaza
include("configuracion.inc.php");
$link = conectar($bd_host, $bd_usuario, $bd_pwd, $bd_nombre);
 
function getProvincias() {
  global $link;
  $query = "select * from zd_province where idcountry=".$_POST['id'];
  mysql_query('SET NAMES '
    utf8 '');
  $result = mysql_query($query, $link);
  $resp = "<option value=''>-Seleccione Provincia-</option>";
  while ($value = mysql_fetch_object($result)) {
    $resp. = "<option value='".$value - > id.
    "'>".$value - > name.
    "</option>";
  }
  echo $resp;
}
 
function getCiudades() {
  global $link;
  $query = "select * from zd_city where idprovince=".$_POST['id'];
  mysql_query('SET NAMES '
    utf8 '');
  $result = mysql_query($query, $link);
  $resp = "<option value=''>-Seleccione Ciudad-</option>";
  while ($value = mysql_fetch_object($result)) {
    $resp. = "<option value='".$value - > id.
    "'>".$value - > name.
    "</option>";
  }
  echo $resp;
}
 
if ($_POST) {
  switch ($_POST["task"]) {
    case "getprovincias":
      getProvincias();
      break;
    case "getciudades":
      getCiudades();
      break;
  }
} ?>