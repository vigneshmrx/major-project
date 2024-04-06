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

        #dynamic-content-area {
            border: 2px solid;
            margin-top: 100px;
        }

        #search-bar-area {
            /* border: 1px solid; */
            padding: 5px;
            display: inline-block;
            float: right;
            margin-top: 50px;
        }

        #search-bar-area input[type=search] {
            font-size: 15px;
            padding: 5px 10px;
            font-weight: normal;
            border-radius: var(--common-value);
            width: 300px;
        }

        #dynamic-table {
            width: 80%;
            margin: 25px auto 50px auto;
            border: 1px solid;
        }

        #dynamic-table table {
            width: 100%;
            border: 1px solid;
        }

        #dynamic-table td {
            border-right: 1px solid;
            border-left: 1px solid;
            text-align: center;
            padding: 5px 10px;
        }

        #dynamic-table th {
            padding: 15px;
            background: var(--main-black);
            color: var(--main-white);
            font-weight: normal;
        }

        .action-cell img {
            width: 27px;
            cursor: pointer;
        }

        .action-cell {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            min-width: 50px;
        }

        .action-cell img:hover {
            scale: 1.05;
        }

        .sub-headings {
            /* margin: auto; */
            margin-left: 10%;
            font-size: 20px;
            font-weight: bold;
            text-decoration: underline;
        }

        .nothing-to-show {
            text-align: center;
            margin: 25px 0px;
        }

        .nothing-to-show img {
            height: 70px;
        }

        .hide {
            display: none;
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
            <div class="option-bar-options" id="1" onclick="optionChangeFun(this);" >Writer Requests</div>
            <div class="option-bar-options" id="2" onclick="optionChangeFun(this);" >Reported Blogs</div>
            <div class="option-bar-options" id="3" onclick="optionChangeFun(this);" >Users List</div>
            <div class="option-bar-options" id="4" onclick="optionChangeFun(this);" >Send Mail</div>
        </div>

        <div id="search-bar-area">
                <input type="search" name="" id="search-bar" placeholder="Search..." class="writer-requests-search-bar">
        </div>

        <div id="dynamic-content-area">
            

            <div class="sub-headings" style="">
                Unattended Requests:
            </div>

            <div id="dynamic-table">
                <table cellspacing="0">
                    <tr>
                        <th>SNo</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Work Links</th>
                        <th>Requested On</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                    <tr class="info-row">
                        <td>1</td>
                        <td>Eren Yeager</td>
                        <td>erenyeager@gmail.com</td>
                        <td>https:,.fdjldsjflsdjlksdjfdl</td>
                        <td>2024-04-02</td>
                        <td>Pending</td>
                        <td class="action-cell">
                            <abbr title="Accept Request">
                            <img src="./icons/accept-request.png" alt="">
                            </abbr>
                            <abbr title="Reject Request">
                            <img src="./icons/reject-request.png" alt="">
                            </abbr>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="sub-headings">
                Previous Requests:
            </div>

            <div id="dynamic-table">
                <table cellspacing="0">
                    <tr>
                        <th>SNo</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Work Links</th>
                        <th>Requested On</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                    <tr class="info-row">
                        <td>1</td>
                        <td>Eren Yeager</td>
                        <td>erenyeager@gmail.com</td>
                        <td>https:,.fdjldsjflsdjlksdjfdl</td>
                        <td>2024-04-02</td>
                        <td>Pending</td>
                        <td class="action-cell">
                            <abbr title="Revoke Writer Permission">
                            <img src="./icons/reject-request.png" alt="">
                            </abbr>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script src="./js/common-script.js"></script>
    <script>
        let currentlySelectedOptionId;

        let adminSelectedOption = sessionStorage.getItem("admin-selected-option");

        if (adminSelectedOption == null || adminSelectedOption == undefined) {
            currentlySelectedOptionId = "1";
        } else {
            currentlySelectedOptionId = adminSelectedOption;
        }

        const optionChangeFun = (objRef) => {
            let uniqueId = objRef.id;

            if (currentlySelectedOptionId == uniqueId) {
                return;
            } else {
                let currentlyClickedOption = document.getElementById(uniqueId);
                // console.log(currentlyClickedOption);

                currentlyClickedOption.classList.add("currently-selected");

                sessionStorage.setItem("admin-selected-option", uniqueId);

                let previousClickedOption = document.getElementById(currentlySelectedOptionId);

                previousClickedOption.classList.remove("currently-selected");

                currentlySelectedOptionId = uniqueId;

                // highlightSelectedOptionFun(uniqueId);
            }

            adminSelectedOptionFun(uniqueId);
        }

        const highlightSelectedOption = (uniqueId) => {
            let currentlyClickedOption = document.getElementById(uniqueId);
                // console.log(currentlyClickedOption);

                currentlyClickedOption.classList.add("currently-selected");
        }

        highlightSelectedOption(currentlySelectedOptionId);

        const showSelectedOptionData = (type) => {
            let dynamicContentArea = document.getElementById("dynamic-content-area");

            $.ajax({
                type: "POST",
                url: "../major-project/php-ajax/show-admin-selected-option.php",
                data: {
                    data_request_type: type
                },
                success: function(response) {
                    dynamicContentArea.innerHTML = response;

                    if (type == "writer-requests") {
                        loadWriterRequestInfoRowsInArray();
                    } else if (type == "reports") {
                        loadReportedBlogsInfoRowsInArray();
                    }
                }
            });

        }

        const adminSelectedOptionFun = (uniqueId) => {
            switch (uniqueId) {
                case "1" : showSelectedOptionData("writer-requests");
                            break;

                case "2" : showSelectedOptionData("reports");
                            break;

                case "3" : showSelectedOptionData("users-list"); 
                            break;

                case "4" : showSelectedOptionData("send-mail");
            }
        }

        adminSelectedOptionFun(currentlySelectedOptionId);

        // showSelectedOptionData("writer-requests")

        let infoRowsArr = [];

        const loadWriterRequestInfoRowsInArray = () => {

            console.log("In Hre");

                let infoRows = Array.from(document.getElementsByClassName("info-row"));

                infoRowsArr = infoRows.map(indiRow => {
                    let username = indiRow.getElementsByClassName("request-username")[0].innerHTML;
                    let email = indiRow.getElementsByClassName("request-email")[0].innerHTML;
                    let links = indiRow.getElementsByClassName("request-links")[0].innerHTML;
                    let requestDate = indiRow.getElementsByClassName("request-requested-date")[0].innerHTML;
                    let status = indiRow.getElementsByClassName("request-status")[0].innerHTML;

                    return {username: username.toLowerCase(), emailId: email.toLowerCase(), workLinks: links.toLowerCase(), requestedDate: requestDate.toLowerCase(), requestStatus: status.toLowerCase(), element: indiRow}
                });
        }

        const loadReportedBlogsInfoRowsInArray = () => {
            let infoRows = Array.from(document.getElementsByClassName("info-row"));

            infoRowsArr = infoRows.map(indiRow => {
                let username = indiRow.getElementsByClassName("reported-user")[0].innerHTML;
                let email = indiRow.getElementsByClassName("reported-email")[0].innerHTML;
                let blogName = indiRow.getElementsByClassName("reported-blog-name")[0].innerHTML;
                let category = indiRow.getElementsByClassName("reported-category")[0].innerHTML;
                let noOfReports = indiRow.getElementsByClassName("reported-no")[0].innerHTML;

                return {username: username.toLowerCase(), email: email.toLowerCase(), blogName: blogName.toLowerCase(), category: category.toLowerCase(), noOfReports: noOfReports.toLowerCase(), element: indiRow}

            });
        }

        SearchBar = document.getElementById("search-bar");

        // loadTheInfoRowsArray();

        SearchBar.addEventListener("input", (e) => {
            const value = e.target.value.toLowerCase();

            console.log('in here 2');

            

            infoRowsArr.forEach(infoRow => {

                console.log('in here 3');

                let isVisible = true;

                if (currentlySelectedOptionId == "1") {

                    isVisible = infoRow.username.includes(value) || infoRow.emailId.includes(value) || infoRow.workLinks.includes(value) || infoRow.requestedDate.includes(value) || infoRow.requestStatus.includes(value);

                } else if (currentlySelectedOptionId == "2") {
                    isVisible = infoRow.username.includes(value) || infoRow.email.includes(value) || infoRow.blogName.includes(value) || infoRow.category.includes(value) || infoRow.noOfReports.includes(value);
                }

                // const isVisible = infoRow.username.includes(value) || infoRow.emailId.includes(value) || infoRow.workLinks.includes(value) || infoRow.requestedDate.includes(value) || infoRow.requestStatus.includes(value);

                infoRow.element.classList.toggle("hide", !isVisible);

            })
        })
    </script>
</body>
</html>