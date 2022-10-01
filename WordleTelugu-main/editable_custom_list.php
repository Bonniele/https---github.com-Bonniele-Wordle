<?php
    require 'db_configuration.php';
    $conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);


    $value = $_POST['value'];
    $column = $_POST['column'];
    $id = $_POST['id'];
    echo "$value - $column - $id";

    $sql="UPDATE custom_words SET $column = '$value' WHERE id = '$id'";
    $result = $conn->query($sql);

    $conn -> close();
    
    
?>
