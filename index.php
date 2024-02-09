<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="https://kit.fontawesome.com/0595897d0f.js" crossorigin="anonymous"></script>
    <style>
    <?php include './css/common-styles.css';
    ?>
    </style>
    <style>
    <?php include './css/styles.css';
    ?>
    </style>
</head>
<body>
    <header>
        <div class="nav-bar">
            <div id="logo">ProDo</div>

            <div id="same-page-links">
                <a href="#">About</a>
                <a href="#brief-introduction-area">Finance</a>
                <a href="#bookshelf-scroll">Bookshelf</a>
                <a href="#blog-area">Blogging</a>
            </div>

            <div id="nav-action-links">
                <a href="./login.php"><button style="background: var(--main-white); color: var(--main-balck); margin-right: 20px;">Log In</button></a>
                <a href="./signup.php"><button>Sign Up</button></a>
            </div> 

            <!-- <div id="hamburger-menu">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div> -->
        </div>
    </header>

    <section>
        <div id="greeting-area">
            Welcome to <span class="prodo">ProDo</span>. <br>Your Personal Productivity Assistant.
        </div>
        <div id="description-of-prodo">
            A web application where you can manage your finances, and bookshelf and even read and write blogs, all in one place.
        </div>
        <div id="get-started-btn-area">
            <a href="signup.php">
                <button style="display: flex; justify-content: space-between; align-items: center;">Get Started <img src="./icons/icons8-right-arrow-50.png" alt="" class="right-arrow-icon"></button>
            </a>
        </div>

        <div id="brief-introduction-area">
            We believe managing your finances and reading should go hand in hand. These two factors are importart for a greater future. Hence we bring you ProDo.
        </div>

        <div id="finance-area">
            Finance

            <div class="underline-box"></div>

            <div class="finance-group">
                <div class="left-area">
                    <img src="./images/finance_1_2.jpg" alt="">
                </div>
                <div class="right-area">
                    <div>
                    <h1>Manage your finance</h1>
                    <div class="underline-box" style="margin-top: 10px; margin-bottom: 20px;"></div>
                    <p>Prudent personal finance management at an early stage is essential for long-term stability.<!--This involves creating a realistic budget, tracking expenses, and setting clear financial goals.--> By cultivating smart financial habits early on, individuals can build a resilient foundation, ensuring financial well-being and adaptability in the future. Make this possible with ProDo.</p>
                    </div>
                </div>
            </div>
        </div>

        <br><br><br id="bookshelf-scroll"><br>

        <div id="bookshelf-area">
            Bookshelf

            <div class="underline-box"></div>

            <div class="bookshelf-group">
                <div class="left-area">
                    <div>
                    <h1>Manage your bookshelf</h1>
                    <div class="underline-box" style="margin-top: 10px; margin-bottom: 20px;"></div>
                    <p>Reading is a key to knowledge, imagination, and personal growth. It enhances critical thinking, broadens perspectives, and promotes empathy. Whether fiction or non-fiction, reading is a timeless skill that empowers individuals to stay informed and engaged, playing a vital role in personal development.</p>
                    </div>
                </div>

                <div class="right-area">
                    <img src="./images/books_1.jpg" alt="">
                </div>
            </div>
        </div>

        <br><br>

        <div id="blog-area">
            Blogging

            <div class="underline-box"></div>

            <div class="blog-group">
                <div class="left-area">
                    <img src="./images/blog_1_2.jpg" alt="">
                </div>

                <div class="right-area">
                    <div>
                    <h1>Read and Write Blogs</h1>
                    <div class="underline-box" style="margin-top: 10px; margin-bottom: 20px;"></div>
                    <p>Reading and writing blogs offer dynamic avenues for information exchange. Reading exposes individuals to diverse perspectives, while writing enables the sharing of thoughts and expertise. Together, these activities foster a vibrant online community, promoting continuous learning and creativity.</p>
                    </div>
                </div>

                
            </div>
        </div>
    </section>

    <a href="#" class="to-top">
        <i class="fas fa-chevron-up"></i>
    </a>

    <footer>
        Copyright @ <?php echo date("Y"); ?>, ProDo. All rights reserved.
    </footer>

    <script src="./js/common-script.js"></script>
</body>
</html>