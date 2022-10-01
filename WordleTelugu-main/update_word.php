<?php
require 'db_configuration.php';
if (isset($_GET['id'])){
    $conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);
    $word = $_GET['id'];
    $sql = "SELECT * FROM puzzle_words
            WHERE word = '$word'";
    $result = $conn->query($sql);

    if ($result -> num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $date=$row["date"];
        $time = $row["time"];
    }//end if
    $conn -> close(); 
}//end if
}

date_default_timezone_set('America/Chicago');
$today_date = date("Y-m-d");

if($date > $today_date) {

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Animals</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/animals.css">
        <script src="js/animals.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>     
        <style>
            td {
                font-family: Arial, Helvetica, sans-serif;
                border: 5px solid;
                text-align: center;
                font-weight: bold;
            }
        </style>
    </head>

    <header style="background-color:white">
        <div id="secondary_screen_buttons">
            <div id="back_button">
                <a href="list_words.php"><img src="images/back_icon.png" alt="Back Icon" style="Display:Block;width:70px;height:70px;"></a>
            </div>
        </div>
        <div id="game_title">
            <p>Update Puzzle Word</p>
        </div>
        <div id="secondary_screen_logo">
            <a href="https://telugupuzzles.com"><img src="images/logo.png" alt="10000 Icon" style="height:80px;width:auto;"></a>
        </div>
    </header>

  <?php

$word;
$date;
$time;
$winning_plays;
$total_plays;

if (isset($_GET['id'])){
    $conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);
    $word = $_GET['id'];
    $sql = "SELECT * FROM puzzle_words
            WHERE word = '$word'";
    $result = $conn->query($sql);

    if ($result -> num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $date=$row["date"];
        $time = $row["time"];
        $winning_plays = $row["winning_plays"];
        $total_plays = $row["total_plays"];
    }//end if
    $conn -> close(); 
}//end if
}

?>

    <body style="background-color: #f2edf2">
        <form action="update.php?rn=<?php echo $_GET['id'] ?>" method="POST">
            <table style="color:black; margin-left:auto; margin-right: auto;">
                <tr>
                    <td>
                        New Date:                     
                    </td>
                    <td>
                        <input placeholder="<?php echo $date ?>" type="date" name="new_date">
                    </td>
                </tr>
                <tr>
                    <td>
                        New Time:                     
                    </td>
                    <td>
                        <input placeholder="<?php echo $time ?>"type="time" name="new_time">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="Submit" value="Submit" name = "submit">
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>

<?php 
} else {
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

<!-- Page Content -->
<br><br>
   
    <h2 id="title">Word List</h2><br>
    <h3 id="title">Unable to update words that have dates/times in the past.</h3>

    <?php
        include('table_puzzle_words.php');
    ?>
    


</body>
</html>
<?php
}
?>