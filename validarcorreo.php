<?php
$db = mysqli_connect(gethostname(), 'root', 'root') or 
    die ('Unable to connect. Check your connection parameters.');
mysqli_select_db($db, 'moviesite') or die(mysqli_error($db));

$validaremail = $_POST['correo'];

if (filter_var($validaremail, FILTER_VALIDATE_EMAIL)) {
    echo "El correo introducido '$validaremail' se considera válido.\n";
} else {
    echo "El correo introducido '$validaremail' no se considera válido.\n";
}
?>