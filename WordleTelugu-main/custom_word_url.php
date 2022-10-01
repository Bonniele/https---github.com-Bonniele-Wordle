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
                <a href="add_custom_word.php"><img src="images/back_icon.png" alt="Back Icon" style="Display:Block;width:70px;height:70px;"></a>
            </div>
        </div>
        <div id="game_title">
            <p>Custom Word URL</p>
        </div>
        <div id="secondary_screen_logo">
            <a href="https://telugupuzzles.com"><img src="images/logo.png" alt="10000 Icon" style="height:80px;width:auto;"></a>
        </div>
    </header>
    <body style="background-color:#f2edf2">

<?php $page_title = '';
?>

<!-- Page Content -->
<br><br>
    
    <?php
        //$conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);                    
        $word = $_POST['word'];
        $api_info = curl_init("https://wpapi.telugupuzzles.com/api/getLangForString.php?input1={$word}");
        curl_setopt($api_info, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($api_info);
        $encoding = mb_detect_encoding($response);
        if($encoding == "UTF-8") {
            $response = preg_replace('/[^(\x20-\x7F)]*/','', $response);
        }
        curl_close($api_info);
        $data = json_decode($response, true);
        $language = $data['data'];

        $api_info = curl_init("https://wpapi.telugupuzzles.com/api/getLength.php?string={$word}&language={$language}");
        curl_setopt($api_info, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($api_info);
        $encoding = mb_detect_encoding($response);
        if($encoding == "UTF-8") {
            $response = preg_replace('/[^(\x20-\x7F)]*/','', $response);
        }
        curl_close($api_info);
        $data = json_decode($response, true);
        $length = $data['data'];
        if ($length < 3 || $length > 5) {
            echo "<br><h1 style='text-align:center'>Words must be 3 to 5 characters.</h1><br><h2 style='text-align:center'><a href = 'add_custom_word.php'>Go back</a></h2>";
        } else {
            
            $tmp = explode('"', $_COOKIE['userInfo']);
            $email = $tmp[1];
            $found = False;

            $conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);
            $sql = "SELECT * FROM custom_words WHERE word = '$word'";
            $result = $conn->query($sql);
        
            if ($result -> num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id=$row["Id"];
                    $found = True;
                }
            }//end if

            if ($found) {
                echo "<br><h1 style='text-align:center'>Word already exists in database.</h1><br><h2 style='text-align:center'>URL:<br><a href='index.php?id=".$id."'>localhost/animals/?id=".$id."</a></h2>";
            } else {
                $INSERT = "INSERT INTO custom_words(word, email, total_plays, winning_plays) values(?, ?, 0, 0)";            

                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("ss", $word, $email);
                if ($stmt->execute()) {
                    echo "<br><p style='text-align:center'>New record inserted sucessfully.<p><br>";
                }
                else {
                    
                }

                $sql = "SELECT * FROM custom_words WHERE word = '$word'";
                $result = $conn->query($sql);
            
                if ($result -> num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                        $id=$row["Id"];
                    }
                }//end if
                echo "<br><h1 style='text-align:center'>Custom Word inserted into database.</h1><br><h2 style='text-align:center'>URL:<br><a href='index.php?id=".$id."'>localhost/animals/?id=".$id."</a></h2>";

        }
            $conn -> close(); 
        }
    
        //$email = $_POST['email'];
    ?>

</body>
</html>