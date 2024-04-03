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

        <nav id="primary-menu-nav">
            <a href="./finance.php"><div class="nav-items">Finance</div></a>
            <a href="./bookshelf.php"><div class="nav-items">Bookshelf</div></a>
            <!-- <div class="nav-items"><a href="#">Finance</a></div> -->
            <!-- <div class="nav-items current-page"><a href="#">BookShelf</a></div> -->
            <a href="#"><div class="nav-items current-page">Blog</div></a>
            <a href="#"><div class="nav-items">Settings</div></a>
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

        <!-- <div id="main-heading">
        </div> -->

        <!-- <div id="underline-box"></div>

        <div id="quote-box">
        </div> -->

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
    </div>

    <script src="./js/common-script.js"></script>
    <script>

        // const horizontalScroll = (objRef, toDirection) => {
        //     let blogsArea;

        //     if (toDirection == "left") {
        //         blogsArea = objRef.nextElementSibling.nextElementSibling;

        //         blogsArea.scrollBy(330, 0);
        //     } else {
        //         blogsArea = objRef.nextElementSibling;

        //         blogsArea.scrollBy(-330, 0);
        //     }
        // }

        // const scrollRight = (objRef) => {
        //     let blogsArea = objRef.nextElementSibling;

        //     blogsArea.scrollBy(-350, 0);
        // }

        // const scrollLeft = (objRef) => {
        //     let blogsArea = objRef.nextElementSibling.nextElementSibling;

        //     blogsArea.scrollBy(350, 0);
        // }

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
                // console.log(blog);

                // if (value == "") {
                //     blog.element.classList.toggle("hide", false);
                // } else {
                    // const isVisible = blog.name.includes(value) || blog.category.includes(value) || blog.writer.includes(value);

                    const matchingName = blog.name.indexOf(value);
                    const matchingCat = blog.category.indexOf(value);
                    const matchingWriter = blog.writer.indexOf(value);

                    if (matchingName >= 0 || matchingCat >= 0 || matchingWriter >= 0) {
                        isVisible = true;
                    } else {
                        isVisible = false;
                    }

                    // console.log(isVisible);
                    console.log("Value: " + value);
                    // console.log("Name: " + blog.name + " Match? " + blog.name.includes(value));
                    console.log("Name: " + blog.name + " Match? " + blog.name.indexOf(value));
                    // console.log("Title: " + blog.name + "\nMatch? " + isVisible);

                    blog.element.classList.toggle("hide", !isVisible);
                // }
            });
        });
    </script>
</body>

</html>