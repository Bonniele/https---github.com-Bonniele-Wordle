<?php
    require 'db_configuration.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Wordle</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/animals.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
        <script type="text/javascript" src="js/animals.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <style>
            td {
                font-family: Arial, Helvetica, sans-serif;
                border: 2px solid;
                text-align: center;
                font-weight: bold;
            }
            .dropbtn, .modalbtn {
                background-color: white;
                border-style: none;
                cursor: pointer;
            }
            .dropdown {
                position: relative;
                display: inline-block;
            }
            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #f1f1f1;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                z-index: 1;
            }
            .dropdown-content a, p {
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
            }
            .dropdown-content a:hover {background-color: #ddd;}
            .dropdown:hover .dropdown-content {display: block;}
            .dropdown:hover .dropbtn {background-color: #ddd;}
        </style>
    </head>

    <header style="background-color:#404040">
        <div id="main_screen_logo">
            <a href="https://telugupuzzles.com"><img src="images/logo.png" alt="10000 Icon" style="height:80px;width:auto;"></a>
        </div>
        <div id="game_title">
            <p>Wordle</p>
        </div>
        <div id="menu_buttons">
            <div id="help_button">
                <button onclick="" class="modalbtn">
                    <img src="images/setting.png" alt="Setting Icon" style="Display:Block;width:70px;height:70px;">
                </button>
            </div>
            <div id="help_button">
                <button onclick="showHelpModal()" class="modalbtn">
                    <img src="images/help_icon.png" alt="Help Icon" style="Display:Block;width:70px;height:70px;">
                </button>
            </div>
            <div id="stat_button">
                <button onclick="showStatModal()" class="modalbtn">
                    <img src="images/stat_icon.png" alt="Stat Icon" style="Display:Block;width:70px;height:70px;">
                </button>
            </div>
            <div id="profile_button" class="dropdown">
                <button class="dropbtn">
                    <img src="images/profile_icon.png" alt="Profile Icon" style="Display:Block;width:70px;height:70px;">
                </button>
                <div id="profile_dropdown" class="dropdown-content">
                    <p id="profile_menu_1">Access Level: GUEST</p>
                    <p id="profile_menu_2" style="color:darkGray">Create Custom Word</p>
                    <p id="profile_menu_3" style="color:darkGray">Puzzle Word List</p>
                    <p id="profile_menu_4" style="color:darkGray">Custom Word List</p>
                    <a id="profile_menu_5" href="login_page.php">Log In</a>
                </div>
            </div>
        </div>
    </header>

    <body onload=updateMenus() style="background-color:#404040">
        <div id="clue_box">

        </div>
        <div id="game_panel">
            <div id="character_tile_panel">
                <table id="character_table"></table>
            </div>
            <!-- <div id="animal_tile_panel">
                <table id="animal_table"></table>
            </div> -->
        </div>
        <div id="game_message">
            
        </div>
        <div id="submission_panel">
            <!-- Form calls Javascript function processGuess when the submit button is clicked. -->
            <form action="" method="post" autocomplete = "off" onsubmit="processGuess();return false;">
                <input id="input_box" type="text" name="input_box">
                <input id="submit_button" type="submit" value="Submit" name="submit">
            </form>
        </div>

        <div id="help_modal" class="modal" style="height:90%;overflow:auto">
            <div class="modal-content">
                <span class="close">&times;</span>
                <pre>
                <h2>Help</h2>
               <h2> How To Play </h2>
You can choose to play in English or Telugu.
Guess the TORDLE in what length your setting.
Each guess must input a valid word and correct legnth.
Hit the enter or Click button to submit.
After each guess, the color of the tiles will change to show how close your guess was to the word.
                </pre>
                <div>
                <img src="images/TeluguRule.png" alt="rules" style="width:80%;height:70%;vertical-align:middle;">
                <pre>A new TORDLE will be available each day! </pre>
                </div>
                <p></p>
            </div>
        </div>

        <div id="stat_modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div id="stat_modal_title"><p>STATISTICS</p></div>
                <div id="stat_values">
                    <div id="games_played" class="stat_value">0</div>
                    <div id="games_won" class="stat_value">0</div>
                    <div id="win_percent" class="stat_value">0</div>
                    <div id="current_streak" class="stat_value">0</div>
                    <div id="max_streak" class="stat_value">0</div>
                </div>
                <div id="stat_labels">
                    <div id="games_played_label" class="stat_label">Played</div>
                    <div id="games_won_label" class="stat_label">Won</div>
                    <div id="win_percent_label" class="stat_label">Win %</div>
                    <div id="current_streak_label" class="stat_label">Current Streak</div>
                    <div id="max_streak_label" class="stat_label">Max Streak</div>
                </div>  
            </div>
        </div>

        <script>
            // Javascript function to take a screenshot of the completed game
            function screenshot(){ 
                if(userRole == "ADMIN" || userRole == "SUPER_ADMIN") {  
                    html2canvas(document.querySelector("#game_panel")).then(canvas => {
                        var myImage = canvas.toDataURL("image/png");
                        var tWindow = window.open("");
                    $(tWindow.document.body)
                        .html("<img id='Image' src=" + myImage + "></img>")
                        .ready(function() {
                        tWindow.focus();
                        //tWindow.print();
                        //document.body.appendChild(canvas)
                        });
                    });
                } else {
                    html2canvas(document.querySelector("#animal_tile_panel")).then(canvas => {
                        var myImage = canvas.toDataURL("image/png");
                        var tWindow = window.open("");
                    $(tWindow.document.body)
                        .html("<img id='Image' src=" + myImage + "></img>")
                        .ready(function() {
                        tWindow.focus();
                        //tWindow.print();
                        //document.body.appendChild(canvas)
                        });
                    });
                }
            }
        </script>

        <script>
            // Javascript function to pull puzzle_word details and build UI tables
            <?php
                if(isset($_GET['id'])) {
                    $conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM custom_words
                            WHERE id = '$id'";
                    $result = $conn->query($sql);
                
                    if ($result -> num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $customWord=$row["word"];
                        }
                    $conn -> close(); 
                    }
            ?>
                var word = "<?php echo $customWord; ?>";
                fillCustomWord(word);
            <?php 
                } else {
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
                    $puzzleWord = $row["word"];

                    $conn->close();

                    $puzzleWord = $row["word"]; ?>
                    var word = "<?php echo $puzzleWord; ?>";
                    fillPuzzleWord(word);
            <?php 
                } ?>


            loadGame();

            /* These functions make modals appear. They weren't working from the external
            file, so I put them here. */

            function showHelpModal() {
                document.getElementById("help_modal").style.display = "block";
            }

            function showStatModal() {
                loadUserStats();
                document.getElementById("stat_modal").style.display = "block";
            }

            var helpModalSpan = document.getElementsByClassName("close")[0];
            var statModalSpan = document.getElementsByClassName("close")[1];
            var helpModal = document.getElementById("help_modal");
            var statModal = document.getElementById("stat_modal");

            // When the user clicks on <span> (x), close the modal
            helpModalSpan.onclick = function() {
                helpModal.style.display = "none";
            }

            // When the user clicks on <span> (x), close the modal
            statModalSpan.onclick = function() {
                statModal.style.display = "none";
            }
            
            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == helpModal) {
                    helpModal.style.display = "none";
                } else if (event.target == statModal) {
                    statModal.style.display = "none";  
                }
            }
        </script>
    </body>
</html>