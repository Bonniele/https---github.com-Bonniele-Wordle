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
?>

<!-- Page Content -->
<br><br>
   
    <h2 id="title">Word List</h2><br>
    
    <?php
        // Collect form data
        $language_choice = $_POST['language_choice'];
        $word = trim($_POST['word']);
        $clue = trim($_POST['clue']);

        // Retrieve word language using API
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
        
        // Check if language of word submitted matches language chosen on the form
        if($language == $language_choice) {
            // Retrieve word length using API
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
            
            // Check if word submitted is a valid length
            if($length < 3 || $length > 5) {
                // Error message if word length isn't between 3 and 5 characters
                echo "<br><p style='text-align:center'>Word length must be 3, 4, or 5 characters.<p><br>";
            } else {
                // Word is an acceptable length. Set time based on language (English = 08:00:00, Telugu = 20:00:00
                if($language == 'English') {
                    $time = '08:00:00';
                } else {
                    $time = '20:00:00';
                }

                // Connect to database
                $conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

                // Retrieve the date of the last word in the database
                $sql = "SELECT MAX(date) FROM puzzle_words WHERE time = '$time'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $last_db_date = $row["MAX(date)"];

                // Increment date so word can be added to next available date
                $date = date("Y-m-d", strtotime("+1 day", strtotime($last_db_date)));
                
                // Insert word into database
                if($clue == "") {
                    $INSERT = "INSERT INTO puzzle_words(word, date, time, total_plays, winning_plays) values(?, ?, ?, 0, 0)";            
                    $stmt = $conn->prepare($INSERT);
                    $stmt->bind_param("sss", $word, $date, $time);
                } else {
                    $INSERT = "INSERT INTO puzzle_words(word, date, time, total_plays, winning_plays, clue) values(?, ?, ?, 0, 0, ?)";            
                    $stmt = $conn->prepare($INSERT);
                    $stmt->bind_param("ssss", $word, $date, $time, $clue);
                }
                if ($stmt->execute()) {
                    echo "<br><p style='text-align:center'>New record inserted sucessfully.<p><br>";
                }
                else {
                    echo $stmt->error;
                }
                $conn->close();
                include('table_puzzle_words.php');
            }
        } else {
            echo "<br><p style='text-align:center'>Lanugage of word submitted does not match language chosen.<p><br>";
        }

    ?>
    </body>
</html>