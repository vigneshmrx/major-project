const dbName = localStorage.getItem("dbName");
// const userName = localStorage.getItem("userName");

const loadBlogs = (blogType) => {
    let blogInfoDisplayArea = document.getElementById("user-content-info-display-area");

    if (sessionStorage.getItem("selected-blog-status") == null || sessionStorage.getItem("selected-blog-status") == undefined) {
        sessionStorage.setItem("selected-blog-status", "uploaded");
    }

    let selectedBlogStatus = sessionStorage.getItem("selected-blog-status");

    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/load_blogs.php",
        data: {
            db_name: dbName,
            type: selectedBlogStatus,
            user_name: userName
        },
        success: function(response) {
            // alert(response);
            blogInfoDisplayArea.innerHTML = response;
        },
        error: function(err) {
            alert(err);
        }
    });
}

loadBlogs();

const changeBlogStatus = (status, blogId) => {
    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/change_blog_status.php",
        data: {
            db_name: dbName,
            blog_status: status,
            blog_id: blogId
        },
        success: function(response) {
            showAlert(response);
            loadBlogs("uploaded");
        }
    });
}

//for getting unique blog ID
const getBlogId = (objRef) => {
    return objRef.parentElement.parentElement.parentElement.parentElement.id;
}

const deleteBlog = (objRef) => {
    const blogId = getBlogId(objRef);
    console.log(blogId);

    changeBlogStatus("delete", blogId);
}

//chnages blog status, archive to uploaded and vice versa
const changeBlogVisibility = (objRef) => {
    const blogId = getBlogId(objRef);
    console.log(blogId);

    changeBlogStatus("", blogId);
}

const selectedBlogStatusChangedFun = (event) => {
    sessionStorage.setItem("selected-blog-status", event.target.value);
    loadBlogs();
}

const insertIntoRespectiveSubSection = (content, sectionName) => {
    let postsBoxNoDiv = document.getElementById("posts-bx-content").lastElementChild;
    let archivesBoxNoDiv = document.getElementById("archives-bx-content").lastElementChild;
    let viewsBoxNoDiv = document.getElementById("views-bx-content").lastElementChild;
    let likesBoxNoDiv = document.getElementById("likes-bx-content").lastElementChild;

    switch (sectionName) {
        case "posts": postsBoxNoDiv.innerHTML = '<span class="money">' + content + '</span>';
                            break;

        case "archives": archivesBoxNoDiv.innerHTML = '<span class="money">' + content + '</span>';
                            break;

        case "views": viewsBoxNoDiv.innerHTML = '<span class="money">' + content + '</span>';
                            break;

        case "likes": likesBoxNoDiv.innerHTML = '<span class="money">' + content + '</span>';
                            break;
    }
}

const loadDashboardSubSections = (sectionName) => {
    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/load-dashboard-sub-sections.php",
        data: {
            db_name: dbName,
            section_name: sectionName
        },
        success: function(response) {
            // showAlert(response);
            // alert(response);
            insertIntoRespectiveSubSection(response, sectionName);
        },
        error: function(response) {
            alert(response);
        }
    });
}

loadDashboardSubSections("posts");
loadDashboardSubSections("archives");
loadDashboardSubSections("likes");
loadDashboardSubSections("views");