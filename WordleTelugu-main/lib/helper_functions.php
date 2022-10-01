<?php

    require '../db_configuration.php';    

    // These conditionals are taking the method name and args sent by the ajax code in animals.js
    // and turning them into function call statements.
    if(count($_POST) == 1) {
        echo $_POST["method"]();
    } elseif(count($_POST) == 2) {
        $arg = $_POST["arg"];
        echo $_POST["method"]($arg);
    } elseif(count($_POST) == 3) {
        $arg1 = $_POST["arg1"];
        $arg2 = $_POST["arg2"];
        echo $_POST["method"]($arg1, $arg2);
    } else {
        $arg1 = $_POST["arg1"];
        $arg2 = $_POST["arg2"];
        $arg3 = $_POST["arg3"];
        echo $_POST["method"]($arg1, $arg2, $arg3);
    }

    function incrementCustomTotal($puzzle_word) {
        $conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

        $sql2 = "UPDATE custom_words SET total_plays = total_plays + 1 WHERE word = ?";
        $stmt = $conn->prepare($sql2);
        $stmt->bind_param("s", $puzzle_word);
        $stmt->execute();

        $conn -> close(); 
    }

    function incrementPuzzleTotal($puzzle_word) {
        $conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

        $sql2 = "UPDATE puzzle_words SET total_plays = total_plays + 1 WHERE word = ?";
        $stmt = $conn->prepare($sql2);
        $stmt->bind_param("s", $puzzle_word);
        $stmt->execute();

        $conn -> close(); 
    }

    function updateCustomWin($puzzle_word) {
        $conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

        $sql2 = "UPDATE custom_words SET winning_plays = winning_plays + 1 WHERE word = ?";
        $stmt = $conn->prepare($sql2);
        $stmt->bind_param("s", $puzzle_word);
        $stmt->execute();

        $conn -> close(); 
    }

    function updatePuzzleWin($puzzle_word) {
        $conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

        $sql2 = "UPDATE puzzle_words SET winning_plays = winning_plays + 1 WHERE word = ?";
        $stmt = $conn->prepare($sql2);
        $stmt->bind_param("s", $puzzle_word);
        $stmt->execute();

        $conn -> close(); 
    }

    // Function for checking user before login.  API currently isn't functional, so don't call this method yet.
    function checkUser($email) {
        $api_info = curl_init("https://wpapi.telugupuzzles.com/api/userExists.php?email={$email}");
        curl_setopt($api_info, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($api_info);
        $encoding = mb_detect_encoding($response);
        if($encoding == "UTF-8") {
            $response = preg_replace('/[^(\x20-\x7F)]*/','', $response);
        }
        curl_close($api_info);
        $data = json_decode($response, true);

        return $data["data"];
    }

    // Function for checking email and password on login.  API currently isn't functional, so don't call this method yet.
    function wsLogin($email, $password) {
        $api_info = curl_init("https://wpapi.telugupuzzles.com/api/ws_login.php?email={$email}&password={$password}");
        curl_setopt($api_info, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($api_info);
        $encoding = mb_detect_encoding($response);
        if($encoding == "UTF-8") {
            $response = preg_replace('/[^(\x20-\x7F)]*/','', $response);
        }
        curl_close($api_info);
        $data = json_decode($response, true);

        return $data["data"];
    }

    // Function for getting user role from email.  API currently isn't functional, so don't call this method yet.
    function getRole($email) {
        $api_info = curl_init("https://wpapi.telugupuzzles.com/api/getRole.php?email={$email}");
        curl_setopt($api_info, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($api_info);
        $encoding = mb_detect_encoding($response);
        if($encoding == "UTF-8") {
            $response = preg_replace('/[^(\x20-\x7F)]*/','', $response);
        }
        curl_close($api_info);
        $data = json_decode($response, true);

        return $data["data"];
    }

    function getGuessLimit() {
        // TODO - Retrieve number of guesses from admin settings. (Per professor, the number
        // of guesses is set by the admin and not chosen by the player). This value is used
        // to create the tables in proper sizes.
        return 8;
    }

    function getWord() {
        date_default_timezone_set('America/Chicago');
        $date = date("Y-m-d");
        $conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);
        if(date("H") >= 8 && date("H") < 20) {
            $sql = "SELECT word FROM puzzle_words WHERE date = '$date' AND time = '08:00:00'";
        } else {
            $sql = "SELECT word FROM puzzle_words WHERE date = '$date' AND time = '20:00:00'";
        }
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $conn->close();
        return $row["word"];
    }

    function getPuzzleClue() {
        date_default_timezone_set('America/Chicago');
        $date = date("Y-m-d");
        $conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);
        if(date("H") >= 8 && date("H") < 20) {
            $sql = "SELECT clue FROM puzzle_words WHERE date = '$date' AND time = '08:00:00'";
        } else {
            $sql = "SELECT clue FROM puzzle_words WHERE date = '$date' AND time = '20:00:00'";
        }
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $conn->close();
        return $row["clue"];
    }

    function getCustomClue($id) {
        $conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);
        $sql = "SELECT clue FROM custom_words WHERE id = '$id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $conn->close();
        return $row["clue"];
    }

    function getLanguage($word) {
        $api_info = curl_init("https://wpapi.telugupuzzles.com/api/getLangForString.php?input1={$word}");
        curl_setopt($api_info, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($api_info);
        $encoding = mb_detect_encoding($response);
        if($encoding == "UTF-8") {
            $response = preg_replace('/[^(\x20-\x7F)]*/','', $response);
        }
        curl_close($api_info);
        $data = json_decode($response, true);

        return $data["data"];
    }

    function getLength($word, $language) {
        $api_info = curl_init("https://wpapi.telugupuzzles.com/api/getLength.php?string={$word}&language={$language}");
        curl_setopt($api_info, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($api_info);
        $encoding = mb_detect_encoding($response);
        if($encoding == "UTF-8") {
            $response = preg_replace('/[^(\x20-\x7F)]*/','', $response);
        }
        curl_close($api_info);
        $data = json_decode($response, true);

        return $data["data"];
    }

    function getLogicalChars($word, $language) {
        $api_info = curl_init("https://wpapi.telugupuzzles.com/api/getLogicalChars.php?string={$word}&language={$language}");
        curl_setopt($api_info, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($api_info);
        $encoding = mb_detect_encoding($response);
        if($encoding == "UTF-8") {
            if($language == "English") {
                $response = preg_replace('/[^(\x20-\x7F)]*/','', $response);
            } else {
                $response = preg_replace('/[^(\x20-\x7F)]*/','', $response, 1);
            }
        }
        curl_close($api_info);
        $data = json_decode($response, true);

        echo json_encode($data["data"]);
    }

    /*  1 = Exact match and correct position (English: Bull, Telugu: Elephant)
        2 = Exact match and wrong position (English: Cow, Telugu: Fish)
        3 = Base character match and correct position (Telugu: Horse)
        4 = Base character match and wrong position (Telugu: Frog)
        5 = No match (English and Telugu: Mouse) */
    function checkMatch($puzzle_word, $language, $guess_word) {
         $api_info = curl_init("https://wpapi.telugupuzzles.com/api/get_match_id_string.php?input1={$puzzle_word}&input2={$language}&input3={$guess_word}");
         curl_setopt($api_info, CURLOPT_RETURNTRANSFER, true);
         $response = curl_exec($api_info);
         $encoding = mb_detect_encoding($response);
         if($encoding == "UTF-8") {
             $response = preg_replace('/[^(\x20-\x7F)]*/','', $response);
         }
         curl_close($api_info);
         $data = json_decode($response, true);

         return $data["data"];
    }

    //echo "<script>console.log($response);</script>";    // console example

?>
