<?php
$sql="select * from `restaurant`";
$rows=$pdo->query($sql)->fetchAll();
foreach($rows as $row){
    foreach($row as $value){
        echo $value." ";
    }
    echo "<br>";
?>

<?php
}
?>