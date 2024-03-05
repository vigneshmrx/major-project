<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
    <?php include './css/common-styles.css';
    ?>
    </style>
    <style>
    <?php include './css/page-nav.css'; ?>
    <?php include './css/dashboard.css'; ?>
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        if (localStorage.getItem("logged-in") == null || localStorage.getItem("logged-in") == false) {
            location.replace("login.php");
        }

        // let userName = localStorage.getItem("userName");
        // let userNameArr = userName.split(" ");
        // document.getElementById("dashboard-greeting").innerHTML = userNameArr[0] + "'s Dashboard";
        
        // console.log(userNameArr);
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
            <a href="#">
                <div class="nav-items current-page">Dashboard</div>
            </a>
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
            <a href="#">
                <div class="nav-items current-page">Dashboard</div>
            </a>
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

        <div class="main-content-area">
            <div id="heading-and-action-btns">
                <div id="dashboard-greeting">

                </div>

                <div id="dashboard-main-action">
                    <input type="button" value="+ Add Blog">
                </div>
            </div>

            <div id="user-profile-info-section">

                <div class="profile-info-section-top">

                    <div id="no-of-posts-bx">
                        POSTS
                        <div id="posts-bx-content">
                            <div class="profile-content-bx-img-div">
                                <img src="./icons/icons8-blog-100-2.png" alt="">
                            </div>
                            <div>
                                <span class="money">15</span>
                            </div>
                        </div>
                    </div>

                    <div id="no-of-archives-bx">
                        ARCHIVES
                        <div id="archives-bx-content">
                            <div class="profile-content-bx-img-div">
                                <img src="./icons/icons8-archive-100-2.png" alt="">
                            </div>
                            <div>
                                <span class="money">02</span>
                            </div>
                        </div>
                    </div>

                    <div id="no-of-likes-bx">
                        OVERALL LIKES
                        <div id="likes-bx-content">
                            <div class="profile-content-bx-img-div">
                                <img src="./icons/icons8-heart-100-2.png" alt="">
                            </div>
                            <div>
                                <span class="money">20</span>
                            </div>
                        </div>
                    </div>

                    <div id="no-of-views-bx">
                        OVERALL VIEWS
                        <div id="views-bx-content">
                            <div class="profile-content-bx-img-div">
                                <!-- <img src="./icons/icons8-eye-48.png" alt=""> -->
                                <img src="./icons/icons8-eye-100-2.png" alt="">
                            </div>
                            <div>
                                <span class="money">48</span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="profile-info-section-bottom">

                    <div id="show-user-content-info">
                        <div id="user-content-info-header">
                            <div>MANAGE BLOGS</div>
                            <div>
                                <select id="manage-blogs-drop-down">
                                    <option value="Uploaded" selected>Uploaded</option>
                                    <option value="Archived">Archived</option>
                                </select>
                            </div>
                        </div>

                        <div id="user-content-info-display-area">
                            
                            <!-- <div class="blog-info-box">
                                <div class="blog-info-box-body">
                                    <div class="blog-title-and-info">
                                        <div class="title-and-date">
                                            <div class="blog-title">
                                                The Ancient Ruins of Maharashtra
                                            </div>
                                            <div class="publish-date">
                                                Published: March 15, 2024
                                            </div>
                                        </div>
                                        <br>
                                        <div class="blog-content">
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis, amet pariatur unde earum blanditiis asperiores cum officia totam. Excepturi corporis sit illum tempora odit possimus ad provident....
                                        </div>
                                    </div>
                                    <div class="blog-reactions">
                                        <div class="views-count">
                                            <img src="./icons/icons8-like-icon.png" alt=""> <span class="money">100</span>
                                        </div>
                                        <div class="likes-count">
                                            <img src="./icons/icons8-views-icon.png" alt=""> <span class="money">150</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="blog-info-box-footer">
                                    <input type="button" value="VIEW">
                                    <input type="button" value="DELETE">
                                    <input type="button" value="ARCHIVE">
                                </div>
                            </div> -->

                            <div class="blog-box">
                                <div class="blog-img">
                                    <!-- <img src="./images/cosmos.jpg" alt=""> -->
                                </div>
                                <div class="blog-title">    
                                    Blackholes and The History of the Cosmos
                                </div>
                                <div class="blog-secondary-info">
                                    <b>Writer</b>   : Eren Yeager <br>
                                    <b>Published</b>: 14th May, 2024 <br>
                                    <b>Category</b> : Space

                                    <!-- <div class="blog-box-views-and-likes-count">
                                        <div>
                                            <img src="./icons/icons8-views-icon.png" alt=""> <span class="money">115</span>
                                        </div>
                                        <div>
                                            <img src="./icons/icons8-like-icon.png" alt=""> <span class="money">200</span>
                                        </div>
                                    </div> -->
                                </div>
                            </div>

                            <div class="blog-box">
                                <div class="blog-img">
                                    <!-- <img src="./images/cosmos.jpg" alt=""> -->
                                </div>
                                <div class="blog-title">    
                                    Blackholes and The History of the Cosmos
                                </div>
                                <div class="blog-secondary-info">
                                    <b>Writer</b>   : Eren Yeager <br>
                                    <b>Published</b>: 14th May, 2024 <br>
                                    <b>Category</b> : Space

                                    <!-- <div class="blog-box-views-and-likes-count">
                                        <div>
                                            <img src="./icons/icons8-views-icon.png" alt=""> <span class="money">115</span>
                                        </div>
                                        <div>
                                            <img src="./icons/icons8-like-icon.png" alt=""> <span class="money">200</span>
                                        </div>
                                    </div> -->
                                </div>
                            </div>

                            <div class="blog-box">
                                <div class="blog-img">
                                    <!-- <img src="./images/cosmos.jpg" alt=""> -->
                                </div>
                                <div class="blog-title">    
                                    Blackholes and The History of the Cosmos
                                </div>
                                <div class="blog-secondary-info">
                                    <b>Writer</b>   : Eren Yeager <br>
                                    <b>Published</b>: 14th May, 2024 <br>
                                    <b>Category</b> : Space

                                    <!-- <div class="blog-box-views-and-likes-count">
                                        <div>
                                            <img src="./icons/icons8-views-icon.png" alt=""> <span class="money">115</span>
                                        </div>
                                        <div>
                                            <img src="./icons/icons8-like-icon.png" alt=""> <span class="money">200</span>
                                        </div>
                                    </div> -->
                                </div>
                            </div>

                            <div class="blog-box">
                                <div class="blog-img">
                                    <!-- <img src="./images/cosmos.jpg" alt=""> -->
                                </div>
                                <div class="blog-title">    
                                    Blackholes and The History of the Cosmos
                                </div>
                                <div class="blog-secondary-info">
                                    <b>Writer</b>   : Eren Yeager <br>
                                    <b>Published</b>: 14th May, 2024 <br>
                                    <b>Category</b> : Space

                                    <!-- <div class="blog-box-views-and-likes-count">
                                        <div>
                                            <img src="./icons/icons8-views-icon.png" alt=""> <span class="money">115</span>
                                        </div>
                                        <div>
                                            <img src="./icons/icons8-like-icon.png" alt=""> <span class="money">200</span>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div id="show-content-progress-graph"></div> -->

                </div>
            </div>
        </div>
    </div>

    <script src="./js/common-script.js"></script>
    <script>
        let userName = localStorage.getItem("userName");
        let userNameArr = userName.split(" ");
        // document.getElementById("dashboard-greeting").innerHTML = userNameArr[0] + "'s Dashboard";
        // document.getElementById("dashboard-greeting").innerHTML = "Hello";
        document.getElementById("dashboard-greeting").innerHTML = userNameArr[0] + "'s Dashboard";
    </script>   
</body>
</html>