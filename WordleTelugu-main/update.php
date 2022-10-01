<?php
	require 'db_configuration.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Animals Table</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/animals.css">
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
        <script src="js/animals.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>     
        <style>
            td {
                font-family: Arial, Helvetica, sans-serif;
                border: 5px solid;
                text-align: center;
                font-weight: bold;
            }
            #title {
                text-align: center;
                color: darkgoldenrod;
            }
            #toggle {
                color: 	#4397fb;
            }
            #toggle:hover {
                color: #467bc7
            }
            thead input {
                width: 100%;
            }
            .thumbnailSize{
                height: 100px;
                width: 100px;
                transition:transform 0.25s ease;
            }
            .thumbnailSize:hover {
                -webkit-transform:scale(3.5);
                transform:scale(3.5);
            }
        </style>
    </head>

    <header style="background-color:white">
        <div id="secondary_screen_buttons">
            <div id="back_button">
                <a href="index.php"><img src="images/back_icon.png" alt="Back Icon" style="Display:Block;width:70px;height:70px;"></a>
            </div>
            <div id="add_button">
                <a href="create_word.php"><img src="images/add_icon.png" alt="Add Icon" style="Display:Block;width:70px;height:70px;"></a>
            </div>
        </div>
        <div id="game_title">
            <p>Puzzle Word List</p>
        </div>
        <div id="secondary_screen_logo">
            <a href="https://telugupuzzles.com"><img src="images/logo.png" alt="10000 Icon" style="height:80px;width:auto;"></a>
        </div>
    </header>
    <body style="background-color:#f2edf2">

<?php $page_title = 'Animals > puzzle word list';
        $word=$_GET['rn'];

        $new_time = $_POST['new_time'];
        $new_date = $_POST['new_date'];

        $conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

        if ($new_time != "") {
            $UPDATE = "UPDATE puzzle_words SET time=? WHERE word=?";            
            $stmt = $conn->prepare($UPDATE);
            $stmt->bind_param("ss", $new_time, $word);
            if (! $stmt->execute()) {
                echo $stmt->error;
            }
            $stmt->close();
        } 
        if ($new_date != "") {
            $UPDATE = "UPDATE puzzle_words SET date=? WHERE word=?";            
            $stmt = $conn->prepare($UPDATE);
            $stmt->bind_param("ss", $new_date, $word);
            if (! $stmt->execute()) {
                echo $stmt->error;
            }
            $stmt->close();
        } 

        $conn->close();
?>

<!-- Page Content -->
<br><br>

    <?php
        include('table_puzzle_words.php');
    ?>
    
</body>
</html>