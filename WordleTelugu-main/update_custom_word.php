
<?php
require 'db_configuration.php';
if (isset($_GET['id'])){
    $conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);
    $id = $_GET['id'];
    $sql = "SELECT * FROM custom_Words
            WHERE Id = '$id'";
    $result = $conn->query($sql);

    if ($result -> num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $word=$row["word"];
        $email = $row["Email"];
    }//end if
    $conn -> close(); 
}//end if
}

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
                <a href="list_custom_words.php"><img src="images/back_icon.png" alt="Back Icon" style="Display:Block;width:70px;height:70px;"></a>
            </div>
        </div>
        <div id="game_title">
            <p>Update Custom Word</p>
        </div>
        <div id="secondary_screen_logo">
            <a href="https://telugupuzzles.com"><img src="images/logo.png" alt="10000 Icon" style="height:80px;width:auto;"></a>
        </div>
    </header>

    <body style="background-color: #f2edf2">
        <form action="update_custom.php?rn=<?php echo $_GET['id'] ?>" method="POST">
            <table style="color:black; margin-left:auto; margin-right: auto;">
                <tr>
                    <td>
                        New Word:                     
                    </td>
                    <td>
                        <input placeholder="<?php echo $word ?>" type="text" name="word">
                    </td>
                </tr>
                <tr>
                    <td>
                        New Email:                     
                    </td>
                    <td>
                        <input placeholder="<?php echo $email ?>"type="text" name="email">
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