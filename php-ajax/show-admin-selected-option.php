<?php

include '../connect.php';

$requested_data_type = $_POST["data_request_type"];

$content = "";

try {
    
    if ($requested_data_type == "writer-requests") {

        $get_requests_q = mysqli_query($con, "select * from prodo_db.writer_requests where Status = 'Pending';");

        $get_nonpending_requests_q = mysqli_query($con, "select * from prodo_db.writer_requests where Status != 'Pending';");

        $total_pending_requests = $get_requests_q -> num_rows;

        $total_nonpending_requests = $get_nonpending_requests_q -> num_rows;

        $content = $content . '<div class="sub-headings" >' . 'Unattended Requests:' . '</div>';

        if ($total_pending_requests > 0) {

            $content = $content . '<div id="dynamic-table"><table cellspacing="0"><tr><th>SNo</th><th>User</th><th>Email</th><th>Work Links</th><th>Requested On</th><th>Status</th><th>Action</th></tr>';

            $count = 1;

            while ($row = mysqli_fetch_assoc($get_requests_q)) {

                $content = $content . '<tr class="info-row"><td>' . $count . '</td><td class="request-username">' . $row["UserName"] . '</td><td class="request-email">' . $row["EmailId"] . '</td><td class="request-links">' . $row["WorksLinks"] . '</td><td class="request-requested-date">' . $row["RequestedDate"] . '</td><td class="request-status">' . $row["Status"] . '</td><td class="action-cell">' . '<abbr title="Accept Request" onclick="acceptWriterRequest();"><img src="./icons/accept-request.png" alt=""></abbr>
                <abbr title="Reject Request" onclick="rejectWriterRequest();">
                <img src="./icons/reject-request.png" alt=""></abbr></td></tr>';

                $count++;
 
            }

            $content = $content . '</table></div>';

        } else {

            $content = $content . '<div class="nothing-to-show"><img src="./icons/icons8-grinning-face-with-smiling-eyes-96.png"><br>Nothing to see here!</div>';

        }

        $content = $content . '<div class="sub-headings">Previous Requests:</div>';

        if ($total_nonpending_requests > 0) {

            $content = $content . '<div id="dynamic-table"><table cellspacing="0"><tr><th>SNo</th><th>User</th><th>Email</th><th>Work Links</th><th>Requested On</th><th>Status</th><th>Action</th></tr>';

            $count = 1;

            while ($row = mysqli_fetch_assoc($get_nonpending_requests_q)) {

                $content = $content . '<tr class="info-row"><td>' . $count . '</td><td class="request-username">' . $row["UserName"] . '</td><td class="request-email">' . $row["EmailId"] . '</td><td class="request-links">' . $row["WorksLinks"] . '</td><td class="request-requested-date">' . $row["RequestedDate"] . '</td><td class="request-status">' . $row["Status"] . '</td><td class="action-cell">' . '<abbr title="Revoke Writer Permission" onclick="acceptWriterRequest();"><img src="./icons/reject-request.png" alt=""></abbr></td></tr>';

                $count++;

            }

            $content = $content . '</table></div>';

        }
        else {
            $content = $content . '<div class="nothing-to-show"><img src="./icons/icons8-grinning-face-with-smiling-eyes-96.png"><br>Nothing to see here!</div>';
        }

        die($content);


        // echo $total_rows;
        // echo $total_pending_requests;
    }
    else if ($requested_data_type == "reports") {

        $get_reported_blogs_q = mysqli_query($con, "select * from prodo_db.users_blog_posts_list where Reports > 0");

        $get_nonreported_blogs_q = mysqli_query($con, "select * from prodo_db.users_blog_posts_list where Reports = 0");

        $total_reported_blogs = $get_reported_blogs_q -> num_rows;
        $total_nonreported_blogs = $get_nonreported_blogs_q -> num_rows;

        $content = $content . '<div class="sub-headings" >' . 'Reported Blogs:' . '</div>';

        if ($total_reported_blogs > 0) {

            $content = $content . '<div id="dynamic-table"><table cellspacing="0"><tr><th>SNo</th><th>User</th><th>Email</th><th>Blog Title</th><th>Category</th><th>No. Of Reports</th><th>Action</th></tr>';

            $count = 1;

            while ($row = mysqli_fetch_assoc($get_reported_blogs_q)) {

                $content = $content . '<tr class="info-row"><td>' . $count . '</td><td class="reported-user">' . $row["Username"] . '</td><td class="reported-email">' . $row["Email"] . '</td><td class="reported-blog-name">' . $row["BlogName"] . '</td><td class="reported-category">' . $row["Category"] . '</td><td class="reported-no">' . $row["Reports"] . '</td><td class="action-cell">' . '<abbr title="View Blog">
                <img src="./icons/view-blog.png" alt=""></abbr>' . '<abbr title="Delete Blog"><img src="./icons/icons8-trash-48.png" alt="">
                </abbr>' . '</td></tr>';

                $count++;

            }

            $content = $content . '</table></div>';

        }
        else {
            $content = $content . '<div class="nothing-to-show"><img src="./icons/icons8-grinning-face-with-smiling-eyes-96.png"><br>Nothing to see here!</div>';
        }

        $content = $content . '<div class="sub-headings">Other Blogs:</div>';

        if ($total_nonreported_blogs > 0) {

            $content = $content . '<div id="dynamic-table"><table cellspacing="0"><tr><th>SNo</th><th>User</th><th>Email</th><th>Blog Title</th><th>Category</th><th>No. Of Reports</th><th>Action</th></tr>';

            $count = 1;

            while ($row = mysqli_fetch_assoc($get_nonreported_blogs_q)) {

                $content = $content . '<tr class="info-row"><td>' . $count . '</td><td class="reported-user">' . $row["Username"] . '</td><td class="reported-email">' . $row["Email"] . '</td><td class="reported-blog-name">' . $row["BlogName"] . '</td><td class="reported-category">' . $row["Category"] . '</td><td class="reported-no">' . $row["Reports"] . '</td><td class="action-cell">' . '<abbr title="View Blog">
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
}
catch (Exception $some_exc) {
    echo "Some Error Occured. Please try again later";
}


?>