<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <style>
    <?php include './css/common-styles.css';
    ?>
    </style>
    <style>
    <?php include './css/page-nav.css';
    ?>
    <?php include './css/blog.css';
    ?>
    </style>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        if (localStorage.getItem("logged-in") == null || localStorage.getItem("logged-in") == false) {
            // location.replace("login.php");
            location.href = "login.php";
        }
    </script>
    
</head>

<body>
    <div id="secondary-menu">
        <div class="menu-close-icon" onclick="secondaryMenuFun();">
            <img src="./icons/icons8-close-50_white.png" alt="">
        </div>
        <nav id="secondary-menu-nav">
            <a href="./finance.php">
                <div class="nav-items">Finance</div>
            </a>
            <a href="./bookshelf.php">
                <div class="nav-items">Bookshelf</div>
            </a>
            <a href="#">
                <div class="nav-items current-page">Blog</div>
            </a>
            <a href="#">
            <div class="nav-items" onclick="showSettings(true);">Settings</div></a>
            <div class="nav-items" onclick="logOutBoxFun();">Log Out</div>
        </nav>
    </div>

    <div id="request-writer-permission-popup-pg">
        <div id="request-writer-permission-popup-bx">
            <div id="request-writer-permission-heading-area">
                <div class="request-writer-permission-heading">
                    Request Writer Permission
                </div>
                <div class="close-pop-up-icon-area" onclick="removePopUp(this, []);">
                    <img src="./icons/icons8-close-32.png" alt="">
                </div>
            </div>

            <hr class="popup-box-hr">

            <div style="font-weight: bold;">
            &nbsp;&nbsp;&nbsp;To upload blogs, you must be a verified writer.

            <br><br>

            &nbsp;&nbsp;&nbsp;To verify and promote you as a writer, provide us with links to at least three previous works.

            <br><br>

            &nbsp;&nbsp;&nbsp;If already requested, please wait for the response from our team.
            </div>

            <br><br>

            <textarea name="" id="upload-links-textarea" cols="30" rows="5" placeholder="Website links, drive links etc." ></textarea>

            <br><br>

            <input type="button" value="REQUEST" id="requestBtn"
            style="width: 100px; margin-left: auto; margin-right: auto; display: block;" onclick="submitPrevContentLinks();">
        </div>
    </div>


    <div id="page-left-area">
        <div id="logo">
            ProDo
        </div>

        <hr>

        <nav id="primary-menu-nav">
            <a href="./finance.php"><div class="nav-items">Finance</div></a>
            <a href="./bookshelf.php"><div class="nav-items">Bookshelf</div></a>
            <!-- <div class="nav-items"><a href="#">Finance</a></div> -->
            <!-- <div class="nav-items current-page"><a href="#">BookShelf</a></div> -->
            <a href="#"><div class="nav-items current-page">Blog</div></a>
            <a href="#"><div class="nav-items" onclick="showSettings(true);">Settings</div></a>
            <a href="#"><div class="nav-items" onclick="logOutBoxFun();">Log Out</div></a>
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

        <div id="find-interesting-blogs-description">
            <h2>Discover Interesting Blogs Here</h2>
            <br><br>
            <div id="search-and-cat-area">
                <div>
                    <input type="search" name="" id="search-bar" placeholder="Search..">
                </div>
                <div class="categories">
                    <div class="individual-categories current-category">All</div>
                    <div class="individual-categories">Finance</div>
                    <div class="individual-categories">Productivity</div>
                    <div class="individual-categories">Mindfulness</div>
                    <div class="individual-categories">Meditation</div>
                </div>
            </div>
        </div>

        <div id="blog-page-heading">
            <hr>
            <div>Blogs</div>
            <hr>
        </div>

        <div class="main-content-area">
            <div class="category-heading">
                Recent blog posts
            </div>

            <div class="blogs-area">    
            </div>
        </div>

        <div id="add-post-btn" onclick="addNewPost();">
            <abbr title="Add New Blog">
                <img src="./icons/icons8-add-new-50.png" alt="">
            </abbr>
        </div>
    </div>

    <script src="./js/common-script.js"></script>
    <script>

        const loadBlogs = (cat = "") => {
            let blogsArea = document.getElementsByClassName("blogs-area")[0];
            const userName = localStorage.getItem("userName");

            $.ajax({
                type: "POST",
                url: "../major-project/php-ajax/load-blogs.php",
                data: {
                    category: cat
                },
                success: function(response) {
                    // alert(response);
                    blogsArea.innerHTML = response;
                    loadTheBlogsArray();
                },
                error: function(response) {
                    alert("Error: " + response);
                }
            })
        }

        loadBlogs();

        let blogs = [];

        const loadTheBlogsArray = () => {
            let blogDivs = Array.from(document.getElementsByClassName("blog-box"));

            blogs = blogDivs.map(blogD => {
                let blogName = blogD.getElementsByClassName("blog-title")[0].innerHTML;
                let blogCategory = blogD.getElementsByClassName("category")[0].innerHTML;
                let writer = blogD.getElementsByClassName("blog-by-line")[0].innerHTML;

                return {name: blogName.toLowerCase(), category: blogCategory.toLowerCase(), writer: writer.toLowerCase(), element: blogD};
            });
        }

        let searchInput = document.getElementById("search-bar");

        searchInput.addEventListener("input", (e) => {
            const value = e.target.value.toLowerCase();
            console.log(value);

            blogs.forEach(blog => {

                    const matchingName = blog.name.indexOf(value);
                    const matchingCat = blog.category.indexOf(value);
                    const matchingWriter = blog.writer.indexOf(value);

                    if (matchingName >= 0 || matchingCat >= 0 || matchingWriter >= 0) {
                        isVisible = true;
                    } else {
                        isVisible = false;
                    }

                    blog.element.classList.toggle("hide", !isVisible);
                // }
            });
        });

        let requestPermissionPopupPage = document.getElementById("request-writer-permission-popup-pg");

        const addNewPost = () => {
            let userType = localStorage.getItem("user-type");

            if (userType == "reader") {
                popUpBgFun();

                requestPermissionPopupPage.style.visibility = "visible";
                requestPermissionPopupPage.style.zIndex = 150;
            } else {
                location.href = "create_blog.php";
            }
        }

        const submitPrevContentLinks = () => {
            let links = document.getElementById("upload-links-textarea");
            let un = localStorage.getItem("userName");
            let e = localStorage.getItem("emailID");

            if (links.value == "") {
                showAlert("Please fill the necessary details before requesting!");
                return;
            }

            $.ajax({
                type: "POST",
                url: "../major-project/php-ajax/make-writer-request.php",
                data: {
                    email: e,
                    links: links.value,
                    user_name: un
                },
                success: function(response) {
                    // alert(response);
                    showAlert(response);
                    links.value = "";
                    popUpBgFun();
                    requestPermissionPopupPage.style.visibility = "hidden";
                    requestPermissionPopupPage.style.zIndex = -150;
                }
            })
        }
        // changeSettingsBoxGreeting();
    </script>
</body>

</html>