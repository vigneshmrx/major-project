<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog View</title>

    <style>
        <?php include './css/common-styles.css'; ?>
        <?php include './css/view-blog.css'; ?>
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        if (localStorage.getItem("logged-in") == null || localStorage.getItem("logged-in") == false) {
            location.href = "login.php";
        }
    </script>

    <style>
        body {
            background: var(--bg-color);
            padding: 20px;
        }
    </style>
</head>
<body>
    
    <div id="blog-area">

    </div>

    <script>
        const searchParams = new URLSearchParams(window.location.search);
        let ff1 = searchParams.get("id");

        const loadTheSelectedBlog = () => {
            let blogArea = document.getElementById("blog-area");

            $.ajax({
                type: "POST",
                url: "./php-ajax/load_selected_users_blog.php",
                data: {
                    ff1: ff1,
                    ff2: "",
                    user: ""
                },
                success: function(response) {
                    // alert(response);
                    blogArea.innerHTML = response;
                    setTheTitle();
                },
                error: function(response) {
                    alert(response);
                }
            });
        }

        loadTheSelectedBlog();

        const setTheTitle = () => {
            let title = document.getElementById("blog-heading").innerHTML;
            document.title = title;
        }
    </script>
</body>
</html>