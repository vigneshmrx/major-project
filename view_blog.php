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

            <div id="blog-content">This is nothing but a test
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas eius aspernatur vel delectus alias inventore possimus unde beatae, impedit pariatur natus quia et omnis aperiam, rerum quos esse! Ad, eum optio autem voluptatum at magni amet quaerat voluptatibus minima incidunt hic repellat minus ratione veritatis nulla qui est modi officia cumque porro ea blanditiis! Laboriosam labore suscipit nisi sit tenetur quam itaque dolore accusamus provident! Dolore, amet nulla placeat fuga odio quas sint doloremque doloribus similique praesentium facere, quidem fugit ea, dicta autem asperiores! Exercitationem impedit maxime libero vero iure iusto cumque nobis ducimus molestias, ad, ex sed obcaecati explicabo eligendi harum? Natus hic commodi dolorem voluptates nulla eos iusto! Ex recusandae saepe iusto quis sequi magnam quam ipsam accusantium ipsa voluptatibus repellat cumque, maxime similique atque dolores provident officiis, possimus laudantium doloremque minima libero et assumenda excepturi. Voluptates, itaque. Ducimus maiores maxime, saepe eos sed similique nihil obcaecati hic placeat provident ratione quaerat at ea natus labore porro quam quo. Sequi aliquid distinctio, laborum, enim, maxime aliquam architecto veniam non qui accusamus sapiente. Magni molestias iusto libero dolorem? Voluptatem, quo dignissimos quaerat veritatis non perferendis assumenda unde laboriosam autem, officia culpa odit magnam corporis quod saepe excepturi debitis molestiae sapiente suscipit officiis laudantium. Necessitatibus soluta magni quod ipsam accusamus officia, dolor voluptatibus atque, blanditiis hic exercitationem amet aut omnis perferendis esse aspernatur placeat fugiat iste mollitia earum rerum quidem. Eligendi maxime explicabo sed recusandae labore commodi rem quia officiis ratione aperiam quos, dolorem fuga qui? Unde debitis rerum consequuntur est adipisci eligendi alias at autem quaerat quae! Obcaecati atque doloremque dignissimos cum commodi molestiae quas! Sed nobis dicta optio quas totam labore corporis quibusdam quae blanditiis doloribus? Nobis, accusamus. Ex vitae expedita placeat recusandae eveniet fuga officiis hic totam reiciendis voluptatum, doloremque iste praesentium, ullam velit, animi odio ducimus explicabo nemo incidunt officia ipsa perspiciatis eos aliquid dolore! Aut impedit modi, ipsam quis voluptas consequuntur beatae accusamus magni commodi amet maiores quo ratione itaque quibusdam vel minus expedita nostrum autem placeat omnis. In deserunt praesentium non laborum reprehenderit nihil. Architecto neque explicabo omnis adipisci! Cumque, vero officiis voluptates, unde quia quasi expedita ea vitae qui dolorum maiores explicabo quis fugiat distinctio modi! Optio, dolores quas. Tenetur, eius voluptatibus blanditiis nulla dolores reprehenderit error recusandae perspiciatis animi ipsum. Perferendis, ipsa quasi commodi quisquam illo debitis eum eveniet ad deleniti similique quas magni reiciendis eius. Nulla, debitis est! Voluptatem quidem officia illum rem dolores architecto accusamus sint omnis culpa libero nisi magnam minus nulla reiciendis ullam dolorum ipsum quia dicta, rerum eligendi autem tempora saepe. Quasi, cumque nam! Ipsa earum tempore mollitia. Illo quas eius ad sunt sit quisquam distinctio minus vero porro, aspernatur minima inventore itaque. Repudiandae sequi minima eum. Nostrum quidem voluptatem possimus, adipisci in ab fuga tempora! Atque aperiam qui voluptates perferendis nisi, voluptate ea officiis saepe alias accusamus ad distinctio mollitia placeat accusantium autem non eos vitae ut blanditiis dicta fugit. Cupiditate tenetur incidunt quibusdam, sapiente eius suscipit nobis vitae officia porro! Quisquam aliquid officiis quas assumenda?
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
        const loadTheSelectedBlog = () => {
            let blogArea = document.getElementById("blog-area");
            const searchParams = new URLSearchParams(window.location.search);

            let ff1 = searchParams.get("ff1");
            let ff2 = searchParams.get("ff2");

            console.log(ff1, ff2);

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
                },
                error: function(response) {
                    alert(response);
                }
            })
        }

        loadTheSelectedBlog();
    </script>
</body>
</html>