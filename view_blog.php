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
        setInterval(() => {
            if (localStorage.getItem("logged-in") == null || localStorage.getItem("logged-in") == false) {
                location.replace("login.php");
            }
        }, 100);
        
    </script>

</head>
<body>
        <div class="custom-confirm-page">
            <div class="custom-confirm-box">
                <div class="custom-confirm-text">
                    Are you sure you want to report this blog?
                </div> <br><br>

                <div class="confirm-btns-area">
                    <input type="button" value="YES" onclick="reportThisBlog();">
                    <input type="button" value="NO" onclick="toggleConfirmReportBlogBox(false);">
                </div>
            </div>
        </div>

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
            <a href="./blog.php">
                <div class="nav-items">Blog</div>
            </a>
            <a href="#">
                <div class="nav-items">Settings</div>
            </a>
            <div class="nav-items" onclick="logOutBoxFun();">Log Out</div>
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
            <a href="./blog.php">
                <div class="nav-items">Blog</div>
            </a>
            <a href="#">
                <div class="nav-items">Settings</div>
            </a>
            <div class="nav-items" onclick="logOutBoxFun();">Log Out</div>
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
            
        </div>

    </div>
    <script src="./js/common-script.js">
    </script>

    <script>
        const searchParams = new URLSearchParams(window.location.search);
        let ff1 = searchParams.get("ff1");
        let ff2 = searchParams.get("ff2");

        let user = localStorage.getItem("dbName");

        let ff3 = "";

        if (searchParams.has("ff3")) {
            ff3 = searchParams.get("ff3");
        }

        const setTheTitle = () => {
            // setTimeout(() => {
                let title = document.getElementById("blog-heading").innerHTML;
                document.title = title;
            // }, 600)
            
        }

        const loadTheSelectedBlog = () => {
            let blogArea = document.getElementById("blog-area");

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

        const increaseTheView = () => {
            if (ff3 == "v" || ff3 == "") {
                $.ajax({
                    type: "POST",
                    url: "./php-ajax/increase_cur_blog_view_count.php",
                    data: {
                        ff1: ff1,
                        ff2: ff2
                    },
                    success: function(response) {
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
                    likesDiv.innerHTML = response;
                },
                error: function(response) {
                    alert(response);
                }
            });
        }

        const toggleConfirmReportBlogBox = (toShow) => {
            let reportBlogConfirmPage = document.getElementsByClassName("custom-confirm-page")[0];

            popUpBgFun();

            if (toShow == true) {
                reportBlogConfirmPage.style.visibility = "visible";
                reportBlogConfirmPage.style.zIndex = "150";
            } else {
                reportBlogConfirmPage.style.visibility = "hidden";
                reportBlogConfirmPage.style.zIndex = "150";
            }
        }

        const reportThisBlog = () => {
            $.ajax({
                type: "POST",
                url: "../major-project/php-ajax/report-this-blog.php",
                data: {
                    ff1: ff1
                },
                success: function(response) {
                    showAlert(response);
                    toggleConfirmReportBlogBox(false);
                }
            });
        }
    </script>
</body>
</html>