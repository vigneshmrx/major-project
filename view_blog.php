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
        <?php include './css/view-blog.css'; ?>
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

        let user = localStorage.getItem("dbName");

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
                    ff2: ff2,
                    user: user
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
                        alert(response);
                    }
                });
            } else {
                loadTheSelectedBlog();
            }
        }

        increaseTheView();

        const toggleLike = (objRef) => {
            let likesDiv = document.getElementById("likes-div");
            let userHasLiked = "no";
            let alreadyExistingLikes = parseInt(objRef.lastChild.innerHTML);

            if (objRef.firstChild.src.includes("outlined")) {
                userHasLiked = "yes";
            }

            $.ajax({
                type: "POST",
                url: "../major-project/php-ajax/toggle_like.php",
                data: {
                    user_has_liked: userHasLiked,
                    already_existing_likes: alreadyExistingLikes,
                    ff1: ff1,
                    ff2: ff2,
                    liked_user: user
                },
                success: function (response) {
                    // alert(response);
                    likesDiv.innerHTML = response;
                    // console.log(likesDiv);
                },
                error: function(response) {
                    alert(response);
                }
            });
        }

        // let l = "0";
        // l = parseInt(l);
    </script>
</body>
</html>