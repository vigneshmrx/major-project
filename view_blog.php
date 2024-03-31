<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Blog</title>
    <style>
        <?php include './css/common-styles.css'; ?>
        <?php include './css/page-nav.css'; ?>
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        #blog-area {
            width: 1000px;
            margin: auto;
            padding: 15px 30px 30px 30px;
            background-color: var(--main-white);
            border: 1px solid rgb(225, 199, 199);
            font-size: 16px; 
            border-radius: var(--common-value);
            box-shadow: 10px 10px var(--main-black);
        }

        #blog-heading {
            text-align: center;
            font-size: 36px;
        }

        #blog-info-area {
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* border: 1px solid; */
            margin-top: 15px;
            margin-bottom: 15px;
        }

        #blog-info-area div {
            background: var(--main-black);
            color: var(--main-white);
            padding: 5px 15px;
            border-radius: 10px;
        }

        #blog-content {
            margin-top: 30px;
        }

        /* hr {
            width: 100%;
        } */

        #likes-and-views-area {
            margin-top: 30px;
            display: flex;
            /* border: 1px solid; */
        }

        #likes-and-views-area div {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #likes-div {
            margin-right: 15px;
        }

        #likes-and-views-area div img {
            width: 25px;
            margin-right: 5px;
        }

        #page-right-area {
            padding-bottom: 15px;
        }
    </style>

    <script>
        if (localStorage.getItem("logged-in") == null || localStorage.getItem("logged-in") == false) {
            location.replace("login.php");
        }
    </script>

</head>
<body>
    <div id="secondary-menu">
        <div class="menu-close-icon" onclick="secondaryMenuFun();">
            <img src="./icons/icons8-close-50_white.png" alt="">
        </div>
        <nav>
            <a href="finance.php">
                <div class="nav-items">Finance</div>
            </a>
            <a href="./bookshelf.php">
                <div class="nav-items">Bookshelf</div>
            </a>
            <!-- <div class="nav-items"><a href="#">Finance</a></div> -->
            <!-- <div class="nav-items current-page"><a href="#">BookShelf</a></div> -->
            <a href="./blog.php">
                <div class="nav-items">Blog</div>
            </a>
            <!-- <a href="./dashboard.php">
                <div class="nav-items">Dashboard</div>
            </a> -->
            <a href="#">
                <div class="nav-items">Settings</div>
            </a>
            <div class="nav-items" onclick="logOutBoxFun();">Log Out</div>
            <!-- <a href="#"><div class="nav-items">Log Out</div></a> -->
        </nav>
    </div>

    <div id="page-left-area">
        <div id="logo">
            ProDo
        </div>

        <hr>

        <nav>
            <a href="finance.php">
                <div class="nav-items">Finance</div>
            </a>
            <a href="./bookshelf.php">
                <div class="nav-items">Bookshelf</div>
            </a>
            <!-- <div class="nav-items"><a href="#">Finance</a></div> -->
            <!-- <div class="nav-items current-page"><a href="#">BookShelf</a></div> -->
            <a href="./blog.php">
                <div class="nav-items">Blog</div>
            </a>
            <!-- <a href="./dashboard.php">
                <div class="nav-items">Dashboard</div>
            </a> -->
            <a href="#">
                <div class="nav-items">Settings</div>
            </a>
            <div class="nav-items" onclick="logOutBoxFun();">Log Out</div>
            <!-- <a href="#"><div class="nav-items">Log Out</div></a> -->
        </nav>

        <hr>
    </div>

    <div id="page-right-area">

        <div class="secondary-nav-bar">
            <div class="sec-bar-ham-menu" onclick="secondaryMenuFun(true);">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
            <div class="sec-bar-logo">
                ProDo
            </div>
            <div class="log-out-btn-area" onclick="logOutBoxFun();">
                <img src="./icons/icons8-logout-50.png" alt="">
            </div>
        </div>

        <div id="blog-area">
            <div id="blog-heading">TESTING</div>

            <div id="blog-info-area">
                <div class="user-name">Eren Yeager</div>
                <div class="blog-upload-date">35th March, '24</div>
            </div>

            <div id="blog-content">
            </div>

            <div id="likes-and-views-area">
                <div id="likes-div">
                    <img src="./icons/icons8-like-icon-outlined.png" alt="">
                    <span class="money">5</span>
                </div>
                <div id="views-div">
                    <img src="./icons/icons8-eye-48.png" alt="">
                    <span class="money">5</span>
                </div>
            </div>
        </div>

    </div>
    <script src="./js/common-script.js">
    </script>

    <script>
        const searchParams = new URLSearchParams(window.location.search);
        // let ff3 = searchParams.get("ff3");
        let ff1 = searchParams.get("ff1");
        let ff2 = searchParams.get("ff2");

        let ff3 = "";

        if (temp = searchParams.has("ff3")) {
            ff3 = temp;
        }

        const setTheTitle = () => {
            // setTimeout(() => {
                let title = document.getElementById("blog-heading").innerHTML;
                document.title = title;
            // }, 600)
            
        }

        const loadTheSelectedBlog = () => {
            let blogArea = document.getElementById("blog-area");
            

            console.log(ff1, ff2);
            console.log(ff3);

            $.ajax({
                type: "POST",
                url: "./php-ajax/load_selected_users_blog.php",
                data: {
                    ff1: ff1,
                    ff2: ff2
                },
                success: function(response) {
                    // alert(response);
                    blogArea.innerHTML = response;
                    setTheTitle();
                },
                error: function(response) {
                    alert(response);
                }
            })
        }

        // loadTheSelectedBlog();

        const increaseTheView = () => {
            if (ff3 == "v" || ff3 == "") {
                console.log("called");
                $.ajax({
                    type: "POST",
                    url: "./php-ajax/increase_cur_blog_view_count.php",
                    data: {
                        ff1: ff1,
                        ff2: ff2
                    },
                    success: function(response) {
                        // alert(response);
                        loadTheSelectedBlog();
                    },
                    error: function(response) {
                        alert()
                    }
                });
            } else {
                loadTheSelectedBlog();
            }
        }

        increaseTheView();
    </script>
</body>
</html>