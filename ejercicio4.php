<?php
$db = mysqli_connect(gethostname(), 'root', 'root') or die ('Unable to connect. Check your connection parameters.');
mysqli_select_db($db,'moviesite') or die(mysqli_error($db));
$noRegistros = 1; //Registros por página
$pagina = 1; //Por defecto pagina = 1
if($_GET['pagina'])
    $pagina = $_GET['pagina']; //Si hay pagina, lo asigna
$buskr=$_GET['searchs']; //Palabra a buscar
    
//Utilizo el comando LIMIT para seleccionar un rango de registros
$sSQL = "SELECT * FROM movie WHERE movie_name LIKE '%$buskr%'LIMIT ".($pagina-1)*$noRegistros.",$noRegistros";
$result = mysqli_query($db,$sSQL) or die(mysqli_error($db));
	
//Exploracion de registros
echo "<table>";
while($row = mysqli_fetch_array($result)) { 
	echo "<tr><td height=80 align=center>";
	echo $row["movie_id"]."<br>";
	echo "</td>
	<td align=center><img src='fotos/$row[movie_id]' width=70 height=70></td>
		<td>$row[movie_name].</td>
		<td align=center>$row[movie_year].</td>
	</tr>";
}

//Imprimiendo paginacion
$sSQL = "SELECT count(*) FROM movie WHERE movie_name LIKE '%$buskr%'"; //Cuento el total de registros
$result = mysqli_query($db,$sSQL);
$row = mysqli_fetch_array($result);
$totalRegistros = $row["count(*)"]; //Almaceno el total en una variable

$noPaginas = $totalRegistros/$noRegistros; //Determino la cantidad de paginas

?>
<tr>
    <td colspan="2" align="center"><? echo "<strong>Total registros: </strong>".$totalRegistros; ?></td>
    <td colspan="2" align="center"><? echo "<strong>Pagina: </strong>".$pagina; ?></td>
</tr>
<tr bgcolor="f3f4f1">
    <td colspan="4" align="right"><strong>Pagina:
<?
for($i=1; $i<$noPaginas+1; $i++) { //Imprimo las paginas
	if($i == $pagina)
		echo "<font color=red>$i </font>"; //A la pagina actual no le pongo link
	else
		echo "<a href=\"?pagina=".$i."&searchs=".$buskr."\" style=color:#000;> ".$i."</a>";
}
?>
	</strong></td>
</tr>
</table>
