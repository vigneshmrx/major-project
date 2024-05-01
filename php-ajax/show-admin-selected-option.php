<?php

include '../connect.php';

$requested_data_type = $_POST["data_request_type"];
$admin_email = $_POST["admin_email"];

$content = "";

try {
    
    if ($requested_data_type == "writer-requests") {

        $get_requests_q = mysqli_query($con, "select * from prodo_db.writer_requests where Status = 'Pending';");

        $get_nonpending_requests_q = mysqli_query($con, "select * from prodo_db.writer_requests where Status != 'Pending';");

        $total_pending_requests = $get_requests_q -> num_rows;

        $total_nonpending_requests = $get_nonpending_requests_q -> num_rows;

        $content = $content . '<div class="sub-headings" >' . 'Unattended Requests:' . '</div>';

        if ($total_pending_requests > 0) {

            $content = $content . '<div id="dynamic-table"><table cellspacing="0"><tr><th>SNo</th><th>User</th><th>Email</th><th class="request-links-col">Work Links</th><th>Requested On</th><th>Status</th><th>Action</th></tr>';

            $count = 1;

            while ($row = mysqli_fetch_assoc($get_requests_q)) {

                $content = $content . '<tr class="info-row ' . $row["SNo"] . '"><td>' . $count . '</td><td class="request-username">' . $row["UserName"] . '</td><td class="request-email">' . $row["EmailId"] . '</td><td class="request-links" style="width: 50px; overflow: auto;">' . $row["WorksLinks"] . '</td><td class="request-requested-date">' . $row["RequestedDate"] . '</td><td class="request-status">' . $row["Status"] . '</td><td class="action-cell">' . '<abbr title="Accept Request" onclick="modifyWriterRequest(this, 1);"><img src="./icons/new-tick-48.png" alt=""></abbr>
                <abbr title="Reject Request" onclick="modifyWriterRequest(this, 2);">
                <img src="./icons/reject-request.png" alt=""></abbr></td></tr>';

                $count++;
 
            }

            $content = $content . '</table></div>';

        } else {

            $content = $content . '<div class="nothing-to-show"><img src="./images/nothing-to-see-here.png"><br>Nothing to see here!</div>';

        }

        $content = $content . '<div class="sub-headings">Previous Requests:</div>';

        if ($total_nonpending_requests > 0) {

            $content = $content . '<div id="dynamic-table"><table cellspacing="0"><tr><th>SNo</th><th>User</th><th>Email</th><th class="request-links-col">Work Links</th><th>Requested On</th><th>Status</th><th>Action</th></tr>';

            $count = 1;

            while ($row = mysqli_fetch_assoc($get_nonpending_requests_q)) {

                $content = $content . '<tr class="info-row ' . $row["SNo"] . '"><td>' . $count . '</td><td class="request-username">' . $row["UserName"] . '</td><td class="request-email">' . $row["EmailId"] . '</td><td class="request-links">' . $row["WorksLinks"] . '</td><td class="request-requested-date">' . $row["RequestedDate"] . '</td><td class="request-status">' . $row["Status"] . '</td><td class="action-cell">' . '<abbr title="Delete request" onclick="modifyWriterRequest(this, 3);"><img src="./icons/icons8-trash-48.png" alt=""></abbr></td></tr>';

                $count++;

            }

            $content = $content . '</table></div>';

        }
        else {
            $content = $content . '<div class="nothing-to-show"><img src="./images/nothing-to-see-here.png"><br>Nothing to see here!</div>';
        }

        die($content);

    }
    else if ($requested_data_type == "reports") {

        $get_reported_blogs_q = mysqli_query($con, "select * from prodo_db.users_blog_posts_list where Reports > 0 order by Reports desc;");

        $get_nonreported_blogs_q = mysqli_query($con, "select * from prodo_db.users_blog_posts_list where Reports = 0");

        $total_reported_blogs = $get_reported_blogs_q -> num_rows;
        $total_nonreported_blogs = $get_nonreported_blogs_q -> num_rows;

        $content = $content . '<div class="sub-headings" >' . 'Reported Blogs:' . '</div>';

        if ($total_reported_blogs > 0) {

            $content = $content . '<div id="dynamic-table"><table cellspacing="0"><tr><th>SNo</th><th>User</th><th>Email</th><th>Blog Title</th><th>Category</th><th>No. Of Reports</th><th>Action</th></tr>';

            $count = 1;

            while ($row = mysqli_fetch_assoc($get_reported_blogs_q)) {

                $content = $content . '<tr class="info-row ' . $row["SNo"] . '"><td>' . $count . '</td><td class="reported-user">' . $row["Username"] . '</td><td class="reported-email">' . $row["Email"] . '</td><td class="reported-blog-name">' . $row["BlogName"] . '</td><td class="reported-category">' . $row["Category"] . '</td><td class="reported-no">' . $row["Reports"] . '</td><td class="action-cell">' . '<abbr title="View Blog" onclick="reportedBlogsAjaxFun(this, 1);">
                <img src="./icons/view-blog.png" alt=""></abbr>' . '<abbr title="Delete Blog" onclick="reportedBlogsAjaxFun(this, 2);"><img src="./icons/icons8-trash-48.png" alt="">
                </abbr>' . '</td></tr>';

                $count++;

            }

            $content = $content . '</table></div>';

        }
        else {
            $content = $content . '<div class="nothing-to-show"><img src="./images/nothing-to-see-here.png"><br>Nothing to see here!</div>';
        }

        $content = $content . '<div class="sub-headings">Other Blogs:</div>';

        if ($total_nonreported_blogs > 0) {

            $content = $content . '<div id="dynamic-table"><table cellspacing="0"><tr><th>SNo</th><th>User</th><th>Email</th><th>Blog Title</th><th>Category</th><th>No. Of Reports</th><th>Action</th></tr>';

            $count = 1;

            while ($row = mysqli_fetch_assoc($get_nonreported_blogs_q)) {

                $content = $content . '<tr class="info-row ' . $row["SNo"] . '"><td>' . $count . '</td><td class="reported-user">' . $row["Username"] . '</td><td class="reported-email">' . $row["Email"] . '</td><td class="reported-blog-name">' . $row["BlogName"] . '</td><td class="reported-category">' . $row["Category"] . '</td><td class="reported-no">' . $row["Reports"] . '</td><td class="action-cell">' . '<abbr title="View Blog" onclick="reportedBlogsAjaxFun(this, 1);">
                <img src="./icons/view-blog.png" alt=""></abbr>' . '</td></tr>';

                $count++;

            }

            $content = $content . '</table></div>';

        }
        else {
            $content = $content . '<div class="nothing-to-show"><img src="./icons/icons8-grinning-face-with-smiling-eyes-96.png"><br>Nothing to see here!</div>';
        }

        die($content);

    }
    else if ($requested_data_type == "users-list")
    {

        $get_users_list = mysqli_query($con, "select * from prodo_db.users_list;");

        $total_existing_users = $get_users_list -> num_rows;

        $content = $content . '<div class="sub-headings" >' . 'All Users:' . '</div>';

        if ($total_existing_users > 0) {

            $content = $content . '<div id="dynamic-table"><table cellspacing="0"><tr><th>SNo</th><th>User</th><th>Email</th><th>Role</th><th>Join Date</th><th>No. Of Blogs</th></tr>';

            $count = 1;

            while ($row = mysqli_fetch_assoc($get_users_list)) {

                $join_date = substr($row["join_date"], 0, 10);

                $content = $content . '<tr class="info-row"><td>' . $count . '</td><td class="users-list-user">' . $row["name"] . '</td><td class="users-list-email">' . $row["email"] . '</td><td class="users-list-role">' . ucfirst($row["role"]) . '</td><td class="users-list-join-date">' . $join_date. '</td><td class="users-list-blog-count">';
                
                if ($row["role"] == "writer") {
                    $content = $content . $row["no_of_blogs"];
                } else {
                    $content = $content . "NA";
                }

                $content = $content . '</td></tr>';

                $count++;

            }

            $content = $content . '</table></div>';

        }
        else 
        {
            $content = $content . '<div class="nothing-to-show"><img src="./images/nothing-to-see-here.png"><br>Nothing to see here!</div>';
        }

        die($content);

    }
    else if ($requested_data_type == "manage-admins") {
        
        $get_admins_q = mysqli_query($con, "select * from prodo_db.admin_table;");

        $total_admins = $get_admins_q -> num_rows;

        $content = $content . '<div id="add-admin" onclick="addAdminPopUpToggle(true);"><abbr title="Add new admin"><img src="./icons/icons8-add-new-50.png" alt=""></abbr></div>' . '<div class="sub-headings" >' . 'Manage Admins:' . '</div>';

        if ($total_admins > 1) {

            $content = $content . '<div id="dynamic-table"><table cellspacing="0"><tr><th>SNo</th><th>Name</th><th>Email</th><th>Join Date</th><th>Action</th></tr>';

            $count = 1;

            while ($row = mysqli_fetch_assoc($get_admins_q)) {

                if ($row["Email"] == $admin_email) {
                    continue;
                }

                $row["Name"] == "" ? $name = "-" : $name = $row["Name"];
                $row["JoinDate"] == "0000-00-00" ? $join_date = "-" : $join_date = $row["JoinDate"];

                $content = $content . '<tr class="info-row ' . $row["SNo"] . '"><td>' . $count . '</td><td class="admin-name">' . $name . '</td><td class="admin-email">' . $row["Email"] . '</td><td class="admin-join-date">' . $join_date . '</td><td class="action-cell">' . '<abbr title="Delete admin" onclick="toggleAdminDeleteAlert(true, this);"><img src="./icons/icons8-trash-48.png" alt=""></abbr></td></tr>';

                $count++;

            }

            $content = $content . '</table></div>';

        }
        else 
        {

            $content = $content . '<div class="nothing-to-show"><img src="./images/nothing-to-see-here.png"><br>Nothing to see here!</div>';

        }

        die($content);

    }
   
}
catch (Exception $some_exc) {
    echo "Some Error Occured. Please try again later";
}


?>