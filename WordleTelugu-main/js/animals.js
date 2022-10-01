let puzzleWord = "";
let cellColor = ""
let puzzleWordLanguage = "";
let puzzleWordLength;
let customWord = false;
let guessLimit;
let numberOfAttempts = 1;
let animal = "";
let pictureFile = "";
let gameResult = "";
let userRole = "";
const admins = ["marc.wedo@gmail.com", "jmhuddock09@gmail.com", "olsonjeremy33@yahoo.com"];
const userInfo = [];
const userStats = [];
const tableData = [];

/* Function which fills word with input. Used for custom plays
*/
function fillCustomWord(word) {
    puzzleWord = word;
    customWord = true;
}

function fillPuzzleWord(word) {
    puzzleWord = word;
    customWord = false;
}

function loadGame() {
    // Check for a tableData cookie. The function builds an empty table based on the puzzleWord in the database
    // first because if there is a valid tableData cookie, it should be for the current puzzleWord.
    buildTables();
    console.log (puzzleWord);

    if(customWord) {
        const urlParams = new URLSearchParams(location.search);
        const valueIterator = urlParams.values();
        let id = valueIterator.next().value;
        let cname = "customTableData" + id;
        let saveData = getCookie(cname);
        if(saveData != "") {
            loadSaveData(saveData);     // If cookie exists, call loadSaveData to re-create tables
        }
    } else {
        let saveData = getCookie("tableData");
        if(saveData != "") {
            loadSaveData(saveData);     // If cookie exists, call loadSaveData to re-create tables
        }
    }
}

/* Function to pull puzzleWord details and build UI tables. This function uses ajax to
call methods in helper_functions.php to get puzzleWord details from the database. Then it
uses the guessLimit and puzzleWordLength to build tables of appropriate sizes. */
function buildTables() {
    let tableRows = "";
    let cells = "";
    let tdTag = "";

    $.ajax({
        async: false,
        url: "lib/helper_functions.php",
        type: "POST",
        data: {method: "getlanguage", arg: puzzleWord}
    }).done(function(data) {
        puzzleWordLanguage = data;
    });


    $.ajax({
        async: false,
        url: "lib/helper_functions.php",
        type: "POST",
        data: {method: "getLength", arg1: puzzleWord, arg2: puzzleWordLanguage}
    }).done(function(data) {
        puzzleWordLength = data;
    });

    $.ajax({
        async: false,
        url: "lib/helper_functions.php",
        type: "POST",
        data: {method: "getGuessLimit"}
    }).done(function(data) {
        guessLimit = data;
    });


    if(puzzleWordLanguage == "English") {
        if(guessLimit == 8) {
            tdTag = "<td style='width:100px;height:70px;font-size:48px'></td>"
        } else if (guessLimit == 10) {
            tdTag = "<td style='width:90px;height:60px;font-size:42px'></td>"
        } else {
            tdTag = "<td style='width:80px;height:50px;font-size:36px'></td>"
        }
    } else {
        if(guessLimit == 8) {
            tdTag = "<td style='width:100px;height:70px;font-size:36px'></td>"
        } else if (guessLimit == 10) {
            tdTag = "<td style='width:90px;height:60px;font-size:30px'></td>"
        } else {
            tdTag = "<td style='width:80px;height:50px;font-size:24px'></td>"
        }
    }

    for(let i = 0; i < puzzleWordLength; i++) {
        cells = cells + tdTag;
    }
    for(let j = 0; j < guessLimit; j++) {
        tableRows = tableRows + "<tr>" + cells + "</tr>";
    }

    document.getElementById("clue_box").innerHTML = "<p></p><p>Click <a href='#' onclick='loadClue()'>here</a> to see a clue!</p>";
    document.getElementById("character_table").innerHTML = tableRows;
    // document.getElementById("animal_table").innerHTML = tableRows;
    document.getElementById("game_message").innerHTML = "<p></p><p>Puzzle Word Language: " + puzzleWordLanguage + 
        "</p><p>You have " + guessLimit + " guesses to solve the puzzle!</p><p>Good luck!</p>"
}

// Restores table data and vital game variables from cookie data when a cookie exists. If the game was unfinished when
// the player left, they will be able to resume play.
function loadSaveData(saveData) {
    let savedTableData = JSON.parse(saveData);
    let wordLength = savedTableData[0].length;
    let numberOfWords = savedTableData.length / 2;
    let wordLanguage;
    let noMatch = false;

    // Set numberOfAttempts in case the loaded game is unfinished and the player resumes play.
    numberOfAttempts = (savedTableData.length / 2) + 1;

    // API call to get language of words in table (uses the first character of first word as API param)
    $.ajax({
        async: false,
        url: "lib/helper_functions.php",
        type: "POST",
        data: {method: "getLanguage", arg: savedTableData[0][0]}
    }).done(function(data) {
        wordLanguage = data;
    });

    // These variables are the index of the first array of characters and animal values. The cookie data is
    // an array of arrays: [[chars] [ints] [chars] [ints]]. The first two arrays are for the first table rows,
    // the next two are for the second table rows, and so on. These vars are incremented by 2 each loop so the
    // correct data is pulled
    let characterIndex = 0;
    let animalIndex = 1;
    console.log("hello");
    // Populate tables with character and animal data
    for(var r = 0; r < numberOfWords; r++) {
        if(wordLanguage == "English") {
            for(var c = 0; c < wordLength; c++) {
                document.getElementById("character_table").rows[r].cells[c].innerHTML = savedTableData[characterIndex][c].toUpperCase();
                selectAnimal(wordLanguage, savedTableData[animalIndex][c]);
                document.getElementById("character_table").rows[r].cells[c].style.backgroundColor = cellColor
                // pictureFile = "images/" + animal + ".png";
                // document.getElementById("animal_table").rows[r].cells[c].innerHTML =
                //     "<img src=" + pictureFile + " alt=" + animal + ' style="width:40px;height:auto;">';
            }
        } else {
            for(var c = 0; c < wordLength; c++) {
                document.getElementById("character_table").rows[r].cells[c].innerHTML = savedTableData[characterIndex][c].toUpperCase();
                selectAnimal(wordLanguage, savedTableData[animalIndex][c]);
                document.getElementById("character_table").rows[r].cells[c].style.backgroundColor = cellColor
                if((savedTableData[animalIndex][c] == "5" && c == 0) || (savedTableData[animalIndex][c] != "5")) {
                    // selectAnimal(wordLanguage, savedTableData[animalIndex][c]);
                    // document.getElementById("character_table").rows[r].cells[c].style.backgroundColor = cellColor
                    // pictureFile = "images/" + animal + ".png";
                    // document.getElementById("animal_table").rows[r].cells[c].innerHTML =
                    //     "<img src=" + pictureFile + " alt=" + animal + ' style="width:40px;height:auto;">';
                }
            }
        }
        characterIndex += 2;
        animalIndex += 2;
    }

    // Change the most recent "result" back to a string (e.g. "1255") so it can be determined if
    // the saved game was a win, loss, or unfinished.
    latestResultString = savedTableData[savedTableData.length - 1][0];
    for (var i = 1; i < wordLength; i++) {
        latestResultString += savedTableData[savedTableData.length - 1][i];
    }

    // Checks first if the last play was a winning play.  If it was not, then it checks if the player ran out
    // of guesses or if there are still guesses remaining to be played.
    if(latestResultString == "11111" || latestResultString == "1111" || latestResultString == "111") {
        gameResult = "win";
        document.getElementById("game_message").innerHTML =
            "<p></p><p>Congratulations!</p><p>You can now share your complete puzzle on social media.</p>" +
            "<p>Click <a href='javascript:screenshot();'>here</a> to copy the image.</p>";
        document.getElementById("submission_panel").innerHTML =
            '<form action="" method="post" autocomplete = "off" onsubmit="processGuess();return false;">' +
            '<input id="input_box" type="text" name="input_box" disabled>' +
            '<input id="submit_button" type="submit" value="Submit" name="submit" style="background-color:grey" disabled></form>';
    } else {
        if(numberOfWords == guessLimit) {
            gameResult = "loss";
            document.getElementById("game_message").innerHTML =
                "<p></p><p>Sorry! You have run out of guesses...</p><p>The puzzle word was: " + puzzleWord +
                "</p><p>Click <a href='javascript:screenshot();'>here</a> to share your puzzle on social media.</p>";
            document.getElementById("submission_panel").innerHTML =
                '<form action="" method="post" autocomplete = "off" onsubmit="processGuess();return false;">' +
                '<input id="input_box" type="text" name="input_box" disabled>' +
                '<input id="submit_button" type="submit" value="Submit" name="submit" style="background-color:grey" disabled></form>';
        } else {
            gameResult = "";

            let userCookieData = getCookie("userInfo");
            if(userCookieData != "") {
                let userData = JSON.parse(userCookieData);
                userRole = userData[2];
            } else {
                userRole = "GUEST";
            }

            if(userRole == "ADMIN" || userRole == "SUPER_ADMIN") {
                document.getElementById("game_message").innerHTML = "<p></p><p>Puzzle Word Language: " + puzzleWordLanguage + 
                    "</p><p>You have " + guessLimit + " guesses to solve the puzzle!</p>" +
                    "<p>Click <a href='javascript:screenshot();'>here</a> to share the puzzle in progress!</p>";
            } else {
                document.getElementById("game_message").innerHTML = "<p></p><p>Puzzle Word Language: " + puzzleWordLanguage + 
                    "</p><p>You have " + guessLimit + " guesses to solve the puzzle!</p><p>Good luck!</p>";
            }
        }
    }
    // Re-creating the cookie so that prior data and any additional guesses (if possible) will be available if player leaves and returns.
    for(var j = 0; j < savedTableData.length; j++) {
        tableData.push(savedTableData[j]);
    }
    let tableDataString = JSON.stringify(tableData);
    if(customWord) {
        setCookie("customTableData", tableDataString, 1);
    } else {
        let cookieExpiration = generateCookieExpiration();
        setCookie("tableData", tableDataString, cookieExpiration);
    }
}

function loadUserStats() {
    let userStatsCookieData = getCookie("userStats");
    if(userStatsCookieData != "") {
        let userStatsData = JSON.parse(userStatsCookieData);
        document.getElementById("games_played").innerHTML = userStatsData[0];
        document.getElementById("games_won").innerHTML = userStatsData[1];
        document.getElementById("win_percent").innerHTML = userStatsData[2];
        document.getElementById("current_streak").innerHTML = userStatsData[3];
        document.getElementById("max_streak").innerHTML = userStatsData[4];
    } else {
        document.getElementById("games_played").innerHTML = 0;
        document.getElementById("games_won").innerHTML = 0;
        document.getElementById("win_percent").innerHTML = 0;
        document.getElementById("current_streak").innerHTML = 0;
        document.getElementById("max_streak").innerHTML = 0;
    }
}

function processLogin() {
    let userEmail = "";
    let userPassword = "";
    let userExists;
    let validLogin;
    let role;

    userEmail = document.getElementById("email_field").value;
    userPassword = document.getElementById("password_field").value;

    // API call to check if email belongs to registered user
    $.ajax({
        async: false,
        url: "lib/helper_functions.php",
        type: "POST",
        data: {method: "checkUser", arg: userEmail}
    }).done(function(data) {
        userExists = data;
    });

    if(userExists) {
        // API call to check if email/password combination are valid
        $.ajax({
            async: false,
            url: "lib/helper_functions.php",
            type: "POST",
            data: {method: "wsLogin", arg1: userEmail, arg2: userPassword}
        }).done(function(data) {
            validLogin = data;
        });

        if(validLogin) {
            // API call to get the role for the player who just logged in
            $.ajax({
                async: false,
                url: "lib/helper_functions.php",
                type: "POST",
                data: {method: "getRole", arg: userEmail}
            }).done(function(data) {
                role = data;
            });
    
            userInfo.push(userEmail);
            userInfo.push("yes");
            //userInfo.push(role);              // This line could be used instead of the IF/ELSE block below in production.
            if(admins.includes(userEmail)) {    // This IF/ELSE is so group members can be logged in as admin rather than users.
                userInfo.push("ADMIN");
            } else {
                userInfo.push(role);
            }
            let userInfoString = JSON.stringify(userInfo);
            setCookie("userInfo", userInfoString, 90);

            document.getElementById("login_message").innerHTML = "";
    
            window.location.href = "index.php";
            updateMenus();
        } else {
            document.getElementById("login_message").innerHTML = "This is not the correct password for this email!";
            document.getElementById("password_field").value = "";
        }

    } else {
        document.getElementById("login_message").innerHTML = 
            "If you are not registered, please go to <a href='https://www.telugupuzzles.com/login.php'>www.telugupuzzles.com</a> and register!";
            document.getElementById("email_field").value = "";
            document.getElementById("password_field").value = "";
    }
}

function logOut() {
    let userCookieData = getCookie("userInfo");
    if(userCookieData != "") {
        let userData = JSON.parse(userCookieData);
        userData[2] = "GUEST";          // If cookie exists, update role in cookie to GUEST
        let userInfoString = JSON.stringify(userData);
        setCookie("userInfo", userInfoString, 90);
    } else {
        userRole = "GUEST";             // If no cookie, update to GUEST menus
    }
    updateMenus();
}

/*
profile_menu_1 -> Access Level: <userRole> (Informational message)
profile_menu_2 -> Create Custom Word
profile_menu_3 -> Puzzle Word List
profile_menu_4 -> Custom Word List
profile_menu_5 -> Log In/Log Out
*/
function updateMenus() {
    // Check for a userInfo cookie
    let userCookieData = getCookie("userInfo");
    if(userCookieData != "") {
        let userData = JSON.parse(userCookieData);
        userRole = userData[2];        // If cookie exists, update to appropriate menus
    } else {
        userRole = "GUEST";             // If no cookie, update to "guest" menus
    }

    // update menus
    if(userRole == "GUEST") {
        document.getElementById("profile_dropdown").innerHTML =
            "<p id='profile_menu_1'>Access Level: GUEST</p>" +
            "<p id='profile_menu_2' style='color:darkGray'>Create Custom Word</p>" +
            "<p id='profile_menu_3' style='color:darkGray'>Puzzle Word List</p>" +
            "<p id='profile_menu_4' style='color:darkGray'>Custom Word List</p>" +
            "<a id='profile_menu_5' href='login_page.php'>Log In</a>";
    } else if(userRole == "USER") {
        document.getElementById("profile_dropdown").innerHTML =
            "<p id='profile_menu_1'>Access Level: USER</p>" +
            "<a id='profile_menu_2' href='create_custom_word.php' style='color:black'>Create Custom Word</a>" +
            "<p id='profile_menu_3' style='color:darkGray'>Puzzle Word List</p>" +
            "<a id='profile_menu_4' href='list_custom_words.php' style='color:#black'>Custom Word List</a>" +
            "<a id='profile_menu_5' href='#' onclick='logOut();return false;'>Log Out</a>";
    } else if(userRole == "ADMIN" || userRole == "SUPER_ADMIN") {
        document.getElementById("profile_dropdown").innerHTML =
            "<p id='profile_menu_1'>Access Level: ADMIN</p>" +
            "<a id='profile_menu_2' href='create_custom_word.php' style='color:black'>Create Custom Word</a>" +
            "<a id='profile_menu_3' href='list_words.php' style='color:black'>Puzzle Word List</a>" +
            "<a id='profile_menu_4' href='list_custom_words.php' style='color:black'>Custom Word List</a>" +
            "<a id='profile_menu_5' href='#' onclick='logOut();return false;'>Log Out</a>";
    } else {
        alert("Unable to build menus. No access level data available.");
    }
}

/* Function to process guess words submitted by the player. This function uses ajax 
to call functions in helper_functions.php to get details about the guess word and
compare it to the puzzle word.  It then updates the table with the characters of the
guess word and the appropriate animal pictures.  */
function processGuess() {
    let guessWord;
    let guessWordLanguage;
    let guessWordLength;
    let logicalChars;
    let matchString = "";
    let noMatch = false;
    guessWord = document.getElementById("input_box").value.toLowerCase();
    guessWord = guessWord.trim();


    // API call to get language of guess word
    $.ajax({
        async: false,
        url: "lib/helper_functions.php",
        type: "POST",
        data: {method: "getLanguage", arg: guessWord}
    }).done(function(data) {
        guessWordLanguage = data;
    });

    // API call to get length of guess word
    $.ajax({
        async: false,
        url: "lib/helper_functions.php",
        type: "POST",
        data: {method: "getLength", arg1: guessWord, arg2: guessWordLanguage}
    }).done(function(data) {
        guessWordLength = data;
    });

    // Guard clauses to catch guesses of incorrect length or language.
    if(guessWordLanguage == puzzleWordLanguage) {
        if(guessWordLength != puzzleWordLength) {
            alert("The puzzle word has " + puzzleWordLength + " characters.\nPlease enter a guess with " + puzzleWordLength + " characters.");
            document.getElementById("input_box").value = "";
            return;
        }
    } else {
        alert("The puzzle word is a word in " + puzzleWordLanguage + ".\nPlease enter a guess which is a word in " + puzzleWordLanguage + ".");
        document.getElementById("input_box").value = "";
        return;
    }

    // API call to get logical chars of guess word
    $.ajax({
        async: false,
        url: "lib/helper_functions.php",
        type: "POST",
        data: {method: "getLogicalChars", arg1: guessWord, arg2: guessWordLanguage}
    }).done(function(data) {
        logicalChars = JSON.parse(data);
    });

    // API call to check if guess word matches puzzle word
    $.ajax({
        async: false,
        url: "lib/helper_functions.php",
        type: "POST",
        data: {method: "checkMatch", arg1: puzzleWord, arg2: guessWordLanguage, arg3: guessWord}
    }).done(function(data) {
        matchString = data;
    });
    console.log ("Original: " + matchString);


    // Code to take the response string from the match API, convert it to an array, sort it, and then
    // rebuild it as a string again so the animals can be loaded in the table in the correct order.
    var arr = matchString.split("");
    var sorted = arr.sort();
    matchString = sorted[0];
    for (var i = 1; i < sorted.length; i++) {
        matchString += sorted[i];
    }

    if (matchString.charAt(0) == "5") {
        noMatch = true;
    }
    console.log (matchString);

    // These IF/ELSE blocks handle the logical chars and match string integers from the APIs and use them
    // to populate the tables.
    if(numberOfAttempts <= guessLimit && gameResult == "") {
        if (guessWordLanguage == "English") {
            for(var c = 0; c < puzzleWordLength; c += 1) {
                document.getElementById("character_table").rows[numberOfAttempts - 1].cells[c].innerHTML = logicalChars[c].toUpperCase();
                selectAnimal(guessWordLanguage, matchString.charAt(c));
                document.getElementById("character_table").rows[numberOfAttempts - 1].cells[c].style.backgroundColor = cellColor
                // pictureFile = "images/" + animal + ".png";
                // document.getElementById("animal_table").rows[numberOfAttempts - 1].cells[c].innerHTML =
                //     "<img src=" + pictureFile + " alt=" + animal + ' style="width:40px;height:auto;">';
            }
        } else {
            for(var c = 0; c < puzzleWordLength; c += 1) {
                document.getElementById("character_table").rows[numberOfAttempts - 1].cells[c].innerHTML = logicalChars[c].toUpperCase();
                selectAnimal(guessWordLanguage, matchString.charAt(c));
                document.getElementById("character_table").rows[numberOfAttempts - 1].cells[c].style.backgroundColor = cellColor
                if((noMatch && c == 0) || (!noMatch && matchString.charAt(c) != "5")) {
                    // selectAnimal(guessWordLanguage, matchString.charAt(c));
                    // document.getElementById("character_table").rows[numberOfAttempts - 1].cells[c].style.backgroundColor = cellColor
                    // pictureFile = "images/" + animal + ".png";
                    // document.getElementById("animal_table").rows[numberOfAttempts - 1].cells[c].innerHTML =
                    //     "<img src=" + pictureFile + " alt=" + animal + ' style="width:40px;height:auto;">';
                }
            }
        }
        document.getElementById("input_box").value = "";
        if(matchString == "11111" || matchString == "1111" || matchString == "111") {
            gameResult = "win";
            if(customWord) {
                updateCustomWin();
                incrementCustomTotal();
            } else {
                updatePuzzleWin();
                incrementPuzzleTotal();
                updateStats(gameResult);
            }
            document.getElementById("game_message").innerHTML =
                "<p></p><p>Congratulations!</p><p>You can now share your complete puzzle on social media.</p>" +
                "<p>Click <a href='javascript:screenshot();'>here</a> to copy the image.</p>";
            
            document.getElementById("submission_panel").innerHTML =
                '<form action="" method="post" autocomplete = "off" onsubmit="processGuess();return false;">' +
                '<input id="input_box" type="text" name="input_box" disabled>' +
                '<input id="submit_button" type="submit" value="Submit" name="submit" style="background-color:grey" disabled></form>';

        } else {
            if (numberOfAttempts == guessLimit) {
                gameResult = "loss";
                if(customWord) {
                    incrementCustomTotal();
                } else {
                    incrementPuzzleTotal();
                    updateStats(gameResult);
                }
                document.getElementById("game_message").innerHTML =
                    "<p></p><p>Sorry! You have run out of guesses...</p><p>The puzzle word was: " + puzzleWord + 
                    "</p><p>Click <a href='javascript:screenshot();'>here</a> to share your puzzle on social media.</p>";
                
                document.getElementById("submission_panel").innerHTML =
                    '<form action="" method="post" autocomplete = "off" onsubmit="processGuess();return false;">' +
                    '<input id="input_box" type="text" name="input_box" disabled>' +
                    '<input id="submit_button" type="submit" value="Submit" name="submit" style="background-color:grey" disabled></form>';
            } else {
                if(userRole == "ADMIN" || userRole == "SUPER_ADMIN") {
                    document.getElementById("game_message").innerHTML = "<p></p><p>Puzzle Word Language: " + puzzleWordLanguage + 
                        "</p><p>You have " + guessLimit + " guesses to solve the puzzle!</p>" +
                        "<p>Click <a href='javascript:screenshot();'>here</a> to share the puzzle in progress!</p>";
                } else {
                    document.getElementById("game_message").innerHTML = "<p></p><p>Puzzle Word Language: " + puzzleWordLanguage + 
                        "</p><p>You have " + guessLimit + " guesses to solve the puzzle!</p><p>Good luck!</p>";
                }
            }
        }
        // tableData array is used to store the characters for character_table and the integers that are used
        // to determine the animals for animal_table. tableData is stored to a cookie called "tableData" after
        // each guess. This data can be used to "resume" the game if the player navigates away from the page.
        // The cookie code is here so that a guess after the game is over doesn't get added to the cookie in error.
        tableData.push(logicalChars);
        tableData.push(sorted);
        let tableDataString = JSON.stringify(tableData);
        if(customWord) {
            setCookie("customTableData", tableDataString, 1);
        } else {
            let cookieExpiration = generateCookieExpiration();
            setCookie("tableData", tableDataString, cookieExpiration);
        }
        numberOfAttempts++;
    } else {
        gameResult = "The game is over!";
        alert(gameResult);
        document.getElementById("input_box").value = "";
    }
}

/* Function to determine the appropriate animal based on the language and the string of characters from
the match checking API.  It updates the animal variable with the name of the animal so it can be used
to build the image tag for updating the tables. */
function selectAnimal(language, id) {
    switch(id) {
        case "1":
            //green
            cellColor = "#caffbf"
            if(language == "English") {
                animal = "bull";
                
            } else {
                animal = "elephant";
            }
            break;
        case "2":
            //yellow
            cellColor = "#fdffb6"
            if(language == "English") {
                animal = "cow";
            } else {
                animal = "fish";
            }
            break;
        case "3":
            //blue
            cellColor = "#a0c4ff"
            animal = "horse";
            break;
        case "4":
            //purple
            cellColor = "#bdb2ff"
            animal = "frog";
            break;
        case "5":
            //gray
            cellColor = "#BEBEBE"
            animal = "mouse";
            break;
        default:
            break;
    }
}

// tableData cookies are created with an expiration that is a timestamp for a specific date/time (the time when
// that puzzle word "expires"). Other cookies are created with an expiration that is a number of days from
// the current day.  That is the reason of the if/else code in this function.
function setCookie(cname, cvalue, expiration) {
    let expires = "expires=";
    let path = "path=";
    if (cname != "tableData") {
        const d = new Date();
        d.setTime(d.getTime() + (expiration * 24 * 60 * 60 * 1000));
        expires = expires + d.toUTCString();
    } else {
        expires = expires + expiration.toUTCString();
    }
    if (customWord) {
        const urlParams = new URLSearchParams(location.search);
        const valueIterator = urlParams.values();
        let id = valueIterator.next().value;
        cname = cname + id;
    }
    document.cookie = cname + "=" + cvalue + ";" + expires + ";" + path + "/";
}

function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function generateCookieExpiration() {
    let todayDate = new Date();
    let tomorrowDate = new Date();
    let hour = todayDate.getHours();

    // Determine the time of day the game is being played so the correct expiration can be generated.
    // Cookie needs to expire when the next puzzle word's time arrives.
    if(hour >= 8 && hour < 20) {
        // Expiration is 8 PM of the same day
        todayDate.setHours(20, 0, 0);
        return todayDate;
    } else {
        // Expiration is 8 AM of the next day
        tomorrowDate.setDate(todayDate.getDate() + 1);
        tomorrowDate.setHours(8, 0, 0);
        return tomorrowDate;
    }
}

function updateCustomWin() {
    $.ajax({
        async: false,
        url: "lib/helper_functions.php",
        type: "POST",
        data: {method: "updateCustomWin", arg: puzzleWord}
    });
}

function updatePuzzleWin() {
    $.ajax({
        async: false,
        url: "lib/helper_functions.php",
        type: "POST",
        data: {method: "updatePuzzleWin", arg: puzzleWord}
    });
}

function pullWord() {
    $.ajax({
        async: false,
        url: "lib/helper_functions.php",
        type: "POST",
        data: {method: "getWord"}
    }).done(function(data) {
        puzzleWord = data;
    });
}

function incrementCustomTotal() {
    $.ajax({
        async: false,
        url: "lib/helper_functions.php",
        type: "POST",
        data: {method: "incrementCustomTotal", arg: puzzleWord}
    });
}

function incrementPuzzleTotal() {
    $.ajax({
        async: false,
        url: "lib/helper_functions.php",
        type: "POST",
        data: {method: "incrementPuzzleTotal", arg: puzzleWord}
    });
}

/* userStats cookie data is an array:
userStats[0] = games_played
userStats[1] = games_won
userStats[2] = win_percent
userStats[3] = current_streak
userStats[4] = max_streak */
function updateStats(gameMessage) {
    let userStatsCookieData = getCookie("userStats");
    if(userStatsCookieData != "") {
        let userStatsData = JSON.parse(userStatsCookieData);
        if(gameMessage == "win") {
            userStatsData[0] = userStatsData[0] + 1;
            userStatsData[1] = userStatsData[1] + 1;
            userStatsData[2] = Math.round((userStatsData[1] / userStatsData[0]) * 100);
            userStatsData[3] = userStatsData[3] + 1;
            if(userStatsData[3] == userStatsData[4] + 1) {
                userStatsData[4] = userStatsData[4] + 1;
            } else if (userStatsData[3] > userStatsData[4] + 1) {
                alert("Error! Current streak is more than 1 higher than max streak. Check streak incrementation!");
            }
        } else if (gameMessage == "loss") {
            userStatsData[0] = userStatsData[0] + 1;
            userStatsData[2] = Math.round((userStatsData[1] / userStatsData[0]) * 100);
            userStatsData[3] = 0;
        } else {
            alert("Error! Game message is '" + gameMessage + "' and it should be 'win' or 'loss'!");
        }
        let userStatsString = JSON.stringify(userStatsData);
        setCookie("userStats", userStatsString, 90);
    } else {
        if(gameMessage == "win") {
            userStats[0] = 1;
            userStats[1] = 1;
            userStats[2] = Math.round((userStats[1] / userStats[0]) * 100);
            userStats[3] = 1;
            userStats[4] = 1;
        } else if (gameMessage == "loss") {
            userStats[0] = 1;
            userStats[1] = 0;
            userStats[2] = Math.round((userStats[1] / userStats[0]) * 100);
            userStats[3] = 0;
            userStats[4] = 0;
        } else {
            alert("Error! Game message is '" + gameMessage + "' and it should be 'win' or 'loss'!");
        }
        let userStatsString = JSON.stringify(userStats);
        setCookie("userStats", userStatsString, 90);
    }
}

function loadClue() {
    let clue;
    if(customWord) {
        const urlParams = new URLSearchParams(location.search);
        const valueIterator = urlParams.values();
        let id = valueIterator.next().value;
        $.ajax({
            async: false,
            url: "lib/helper_functions.php",
            type: "POST",
            data: {method: "getCustomClue", arg: id}
        }).done(function(data) {
            clue = data;
        });
    } else {
        $.ajax({
            async: false,
            url: "lib/helper_functions.php",
            type: "POST",
            data: {method: "getPuzzleClue"}
        }).done(function(data) {
            clue = data;
        });
    }

    if(clue != "") {
        document.getElementById("clue_box").innerHTML = "<p></p><p>Your clue is:</p><p>" + clue + "</p>";
    } else {
        document.getElementById("clue_box").innerHTML = "<p></p><p>Sorry! There is no clue for this word!</p><p>Please guess the word.</p>";
    }
}