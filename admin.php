<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
    <?php 
    include './css/common-styles.css';
    include './css/page-nav.css';
    ?>
    </style>

    <style>
        body {
            background-color: var(--bg-color);
        }

        .secondary-nav-bar {
            display: flex;
        }

        #option-bar {
            display: flex;
            align-items: center;
            width: 80%;
            border: 2px solid;
            margin: auto;
            border-radius: var(--common-value);
            overflow: hidden;
        }
        
        .main-content {
            margin-top: 70px;
            width: 100%;
        }

        .main-heading {
            text-align: center;
            margin: 10px 0px 0px 0px;
            font-size: 25px;
            text-transform: uppercase;
        }

        .option-bar-options {
            width: 25%;
            text-align: center;
            padding: 10px 15px;
            cursor: pointer;
        }

        .option-bar-options:hover {
            text-decoration: underline wavy;
        }

        .currently-selected {
            background: var(--main-black);
            color: var(--main-white);
        }

        .currently-selected:hover {
            text-decoration: none;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="secondary-nav-bar">
        <div class="sec-bar-logo">
            ProDo
        </div>
        <div class="log-out-btn-area" onclick="logOutBoxFun();">
            <abbr title="Log Out">
            <img src="./icons/icons8-logout-50.png" alt="">
            </abbr>
        </div>
    </div>

    <div class="main-content">

        <div class="main-heading">
            Prodo Admin Panel
        </div>

        <div id="underline-box"></div>

        <div id="option-bar">
            <div class="option-bar-options currently-selected" id="1" onclick="optionChangeFun(this);" >Writer Requests</div>
            <div class="option-bar-options" id="2" onclick="optionChangeFun(this);" >Reported Blogs</div>
            <div class="option-bar-options" id="3" onclick="optionChangeFun(this);" >Users List</div>
            <div class="option-bar-options" id="4" onclick="optionChangeFun(this);" >Send Mail</div>
        </div>
    </div>

    <!-- <script src="./js/common-script.js"></script> -->
    <script>
        let currentlySelectedOptionId = "1";

        const optionChangeFun = (objRef) => {
            let uniqueId = objRef.id;

            if (currentlySelectedOptionId == uniqueId) {
                return;
            } else {
                let currentlyClickedOption = document.getElementById(uniqueId);
                // console.log(currentlyClickedOption);

                currentlyClickedOption.classList.add("currently-selected");

                let previousClickedOption = document.getElementById(currentlySelectedOptionId);

                previousClickedOption.classList.remove("currently-selected");

                currentlySelectedOptionId = uniqueId;
            }

            switch (uniqueId) {
                case "1" : showWriterRequests();
                            break;

                case "2" : showReports();
                            break;

                case "3" : showUsersList(); 
                            break;

                case "4" : showSendMailArea();
            }
        }
    </script>
</body>
</html>