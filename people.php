<?php
$db = mysqli_connect(gethostname(), 'root', 'root') or 
    die ('Unable to connect. Check your connection parameters.');
mysqli_select_db($db, 'moviesite') or die(mysqli_error($db));

if ($_GET['action'] == 'edit') {
    //retrieve the record's information 

    $query = 'SELECT
            people_id,people_fullname,people_isactor,people_isdirector
        FROM
            people
        WHERE
            people_id = ' . $_GET['id'];
    $result = mysqli_query($db, $query) or die(mysqli_error($db));
    extract(mysqli_fetch_assoc($result));
} else {
    //set values to blank
    $people_id = '';
    $people_fullname = '';
    $people_isactor = 0;
    $people_isdirector = 0;
    
}
?>
<html>
 <head>
  <title><?php echo ucfirst($_GET['action']); ?> people</title>
    <style type="text/css">
                <!--
        #error { background-color: #600; border: 1px solid #FF0; color: #FFF;
        text-align: center; margin: 10px; padding: 10px; }
        -->
  </style>
 </head>
 <body>
<?php
if (isset($_GET['error']) && $_GET['error'] != '') {
    echo '<div id="error">' . $_GET['error'] . '</div>';
}
?>
  <form action="N6P105commit.php?action=<?php echo $_GET['action']; ?>&type=people"
   method="post">
   <table>
    <tr>
    <tr>
     <td>People Name</td>
     <td><input type="text" name="people_fullname"
      value="<?php echo $people_fullname; ?>"/></td>
    <tr>
    <input type="checkbox" id="isactor" name="people_isactor" value="1" checked>
    <label for="isactor">Actor</label><br>
        <input type="checkbox" id="isdirector" name="people_isdirector" value="1">
    <label for="isactor">Director</label><br>
    </tr>
    </tr>
<?php
// select the movie type information
$query = 'SELECT
        people_fullname,people_isactor
    FROM
        people
    ORDER BY
        people_fullname';
$result = mysqli_query($db, $query) or die(mysqli_error($db));

?>

<?php
// select actor records
$query = 'SELECT
        people_fullname,people_id
    FROM
        people
    WHERE
        people_isactor = 1
    ORDER BY
        people_fullname';
$result = mysqli_query($db, $query) or die(mysqli_error($db));

?>

<?php
// select director records
$query = 'SELECT
        people_fullname,people_id
    FROM
        people
    WHERE
        people_isdirector = 1
    ORDER BY
        people_fullname';
$result = mysqli_query($db, $query) or die(mysqli_error($db));

// populate the select options with the results
while ($row = mysqli_fetch_assoc($result)) {
    foreach ($row as $value) {
        if ($row['people_id'] == $movie_type) {
            echo '<option value="' . $row['people_id'] .
                '" selected="selected">';
        } else {
            echo '<option value="' . $row['people_id'] . '">';
        }
        echo $row['people'] . '</option>';
    }
}

?>
      </select></td>
    </tr><tr>
     <td colspan="2" style="text-align: center;">
<?php
if ($_GET['action'] == 'edit') {
    echo '<input type="hidden" value="' . $_GET['id'] . '" name="people_id" />';
}
?>
<input type="submit" name="submit"
 value="<?php echo ucfirst($_GET['action']); ?>" />
     </td>
    </tr>
   </table>
  </form>
 </body>
</html>
