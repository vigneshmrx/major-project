<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
                <a href="">About</a>
                <a href="">Finance</a>
                <a href="">Bookshelf</a>
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
            Welcome to ProDo. <br>Your Personal Productivty Assistant.
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
        </div>
    </section>
</body>
</html>