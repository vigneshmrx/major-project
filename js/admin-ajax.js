const changeSearchBarVisibility = () => {
    if (currentlySelectedOptionId == "4") {
    searchBarDiv.style.display = "none";
    } else {
        searchBarDiv.style.display = "inline-block";
    }
}

changeSearchBarVisibility();

const optionChangeFun = (objRef) => {
    let uniqueId = objRef.id;

    if (currentlySelectedOptionId == uniqueId) {
        return;
    } else {
        let currentlyClickedOption = document.getElementById(uniqueId);
        // console.log(currentlyClickedOption);

        currentlyClickedOption.classList.add("currently-selected");

        sessionStorage.setItem("admin-selected-option", uniqueId);

        let previousClickedOption = document.getElementById(currentlySelectedOptionId);

        previousClickedOption.classList.remove("currently-selected");

        currentlySelectedOptionId = uniqueId;

        // highlightSelectedOptionFun(uniqueId);
    }

    adminSelectedOptionFun(uniqueId);
}

const highlightSelectedOption = (uniqueId) => {
    let currentlyClickedOption = document.getElementById(uniqueId);
        // console.log(currentlyClickedOption);

        currentlyClickedOption.classList.add("currently-selected");
}

highlightSelectedOption(currentlySelectedOptionId);

const showSelectedOptionData = (type) => {
    let dynamicContentArea = document.getElementById("dynamic-content-area");

    if (type != "send-mail") {

        $.ajax({
            type: "POST",
            url: "../major-project/php-ajax/show-admin-selected-option.php",
            data: {
                data_request_type: type
            },
            success: function(response) {
                dynamicContentArea.innerHTML = response;

                if (type == "writer-requests") {
                    loadWriterRequestInfoRowsInArray();
                } else if (type == "reports") {
                    loadReportedBlogsInfoRowsInArray();
                } else if (type == "users-list") {
                    loadUsersListInfoRowsInArray();
                }

            }
        });

    }
    else {
        let content = "";
        content += '<div class="sub-headings" >' + 'Send Email:' + '</div><div id="mail-area"><div class="mail-flex-line"><div class="from-div">From: <br><input type="text" name="" id="from-input" value="vs.prodowebapp@gmail.com" disabled></div><div class="to-div">To: <br><input type="text" name="" id="to-input"></div></div><div>Subject: <br><input type="text" name="" id="subject-input"></div><div style="margin-top: 25px;">Message: <br><textarea name="" id="message-input" cols="30" rows="10"></textarea></div><div style="text-align: center; margin-top: 25px;"><input type="button" value="SEND MAIL" onclick="sendEmail();" ></div></div>';

        dynamicContentArea.innerHTML = content;
    }

    changeSearchBarVisibility();

}

const adminSelectedOptionFun = (uniqueId) => {
    switch (uniqueId) {
        case "1" : showSelectedOptionData("writer-requests");
                    break;

        case "2" : showSelectedOptionData("reports");
                    break;

        case "3" : showSelectedOptionData("users-list"); 
                    break;

        case "4" : showSelectedOptionData("send-mail");
    }
}

adminSelectedOptionFun(currentlySelectedOptionId);

let infoRowsArr = [];

        const loadWriterRequestInfoRowsInArray = () => {

            console.log("In Hre");

                let infoRows = Array.from(document.getElementsByClassName("info-row"));

                infoRowsArr = infoRows.map(indiRow => {
                    let username = indiRow.getElementsByClassName("request-username")[0].innerHTML;
                    let email = indiRow.getElementsByClassName("request-email")[0].innerHTML;
                    let links = indiRow.getElementsByClassName("request-links")[0].innerHTML;
                    let requestDate = indiRow.getElementsByClassName("request-requested-date")[0].innerHTML;
                    let status = indiRow.getElementsByClassName("request-status")[0].innerHTML;

                    return {username: username.toLowerCase(), emailId: email.toLowerCase(), workLinks: links.toLowerCase(), requestedDate: requestDate.toLowerCase(), requestStatus: status.toLowerCase(), element: indiRow};
                });
        }

        const loadReportedBlogsInfoRowsInArray = () => {
            let infoRows = Array.from(document.getElementsByClassName("info-row"));

            infoRowsArr = infoRows.map(indiRow => {
                let username = indiRow.getElementsByClassName("reported-user")[0].innerHTML;
                let email = indiRow.getElementsByClassName("reported-email")[0].innerHTML;
                let blogName = indiRow.getElementsByClassName("reported-blog-name")[0].innerHTML;
                let category = indiRow.getElementsByClassName("reported-category")[0].innerHTML;
                let noOfReports = indiRow.getElementsByClassName("reported-no")[0].innerHTML;

                return {username: username.toLowerCase(), email: email.toLowerCase(), blogName: blogName.toLowerCase(), category: category.toLowerCase(), noOfReports: noOfReports.toLowerCase(), element: indiRow};

            });
        }

        const loadUsersListInfoRowsInArray = () => {
            let infoRows = Array.from(document.getElementsByClassName("info-row"));

            infoRowsArr = infoRows.map(indiRow => {
                let username = indiRow.getElementsByClassName("users-list-user")[0].innerHTML;
                let email = indiRow.getElementsByClassName("users-list-email")[0].innerHTML;
                let role = indiRow.getElementsByClassName("users-list-role")[0].innerHTML;
                let joinDate = indiRow.getElementsByClassName("users-list-join-date")[0].innerHTML;
                let blogCount = indiRow.getElementsByClassName("users-list-blog-count")[0].innerHTML;

                return {username: username.toLowerCase(), email: email.toLowerCase(), role: role.toLowerCase(), joinDate: joinDate.toLowerCase(), blogCount: blogCount.toLowerCase(), element: indiRow};

            });
        }

        // SearchBar = document.getElementById("search-bar");

        // loadTheInfoRowsArray();

        SearchBar.addEventListener("input", (e) => {
            const value = e.target.value.toLowerCase();

            console.log('in here 2');

            

            infoRowsArr.forEach(infoRow => {

                console.log('in here 3');

                let isVisible = true;

                if (currentlySelectedOptionId == "1") {

                    isVisible = infoRow.username.includes(value) || infoRow.emailId.includes(value) || infoRow.workLinks.includes(value) || infoRow.requestedDate.includes(value) || infoRow.requestStatus.includes(value);

                } else if (currentlySelectedOptionId == "2") {

                    isVisible = infoRow.username.includes(value) || infoRow.email.includes(value) || infoRow.blogName.includes(value) || infoRow.category.includes(value) || infoRow.noOfReports.includes(value);

                }
                else if (currentlySelectedOptionId == "3") {

                    isVisible = infoRow.username.includes(value) || infoRow.email.includes(value) || infoRow.role.includes(value) || infoRow.joinDate.includes(value) || infoRow.blogCount.includes(value);

                }

                // const isVisible = infoRow.username.includes(value) || infoRow.emailId.includes(value) || infoRow.workLinks.includes(value) || infoRow.requestedDate.includes(value) || infoRow.requestStatus.includes(value);

                infoRow.element.classList.toggle("hide", !isVisible);

            });
        });

const sendEmail = () => {

    let toEmail = document.getElementById("to-input");
    let subject = document.getElementById("subject-input");
    let message = document.getElementById("message-input");

    if (toEmail.value == "" || subject.value == "" || message.value == "") {
        showAlert("Please fill all the required details before sending a mail!");
        return;
    }

    console.log(toEmail.value, subject.value, message.value);

    if (toEmail.value.includes("@")) {
        if (toEmail.value.includes(".in") || toEmail.value.includes(".com")) {
            
            showAlert("Please wait");

            $.ajax({
                type: "POST",
                url: "../major-project/php-ajax/send-email.php",
                data: {
                    to_email: toEmail.value,
                    subject: subject.value,
                    message: message.value
                },
                success: function(response) {
                    // alert(response);
                    if (response == "Email Sent Successfully!") {
                        showAlert(response);
                        toEmail.value = "";
                        subject.value = "";
                        message.value = "";
                    } else {
                        alert(response);
                    }
                },
                error: function(response) {
                    showAlert("Some error occured. Please try again later!");
                }
            });

        }
        else {
            showAlert("Please enter a proper/valid email!!");
        }
    } else {
        showAlert("Please enter a proper/valid email!!");
    }

}

const modifyWriterRequest = (objRef, theNo) => {

    let requestId = objRef.parentElement.parentElement.classList[1];
    let userEmail = objRef.parentElement.parentElement.childNodes[2].innerHTML;

    showAlert("Please wait");

    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/modify-writer-request.php",
        data: {
            request_id: requestId,
            user_email: userEmail,
            action_no: theNo
        },
        success: function(response) {
            showAlert(response);
            showSelectedOptionData("writer-requests");
        }
    });

} 

let toDeleteBlogId = 0;

const reportedBlogsAjaxFun = (objRef, theNo) => {

    let theId = objRef.parentElement.parentElement.classList[1];

    if (theNo == 1) {

        location.href = "admin_view_blog.php?id=" + theId;

    } else {
        toDeleteBlogId = objRef.parentElement.parentElement.classList[1];

        toggleBlogDeleteAlert(true, true);
    }

}

const toggleBlogDeleteAlert = (toShow, toRemoveBg = false) => {
    let customConfirmPageOne = document.getElementsByClassName("custom-confirm-page")[0];

    if (toShow == true) {
        customConfirmPageOne.style.visibility = "visible";
        customConfirmPageOne.style.zIndex = "150";
    }
    else {
        customConfirmPageOne.style.visibility = "hidden";
        customConfirmPageOne.style.zIndex = "-150";
    }

    if (toRemoveBg == true) {
        popUpBgFun();
    }   
}

const toggleEnterBlogReasonAlert = (toShow, toRemoveBg = false) => {
    let customConfirmPageTwo = document.getElementsByClassName("custom-confirm-page")[1];

    toggleBlogDeleteAlert(false);

    if (toShow == true) {
        customConfirmPageTwo.style.visibility = "visible";
        customConfirmPageTwo.style.zIndex = "150";
    }
    else {
        customConfirmPageTwo.style.visibility = "hidden";
        customConfirmPageTwo.style.zIndex = "-150";
    }

    if (toRemoveBg == true) {
        popUpBgFun();
    }
}

const getReasonDeleteBlog = () => {
    let blogDeletionReason = document.getElementById("reason-for-deletion-of-blog");

    if (blogDeletionReason.value == "") {
        showAlert("Please enter a reason before submitting!");
        return;
    }

    let theReason = blogDeletionReason.value;
    blogDeletionReason.value = "";

    toggleEnterBlogReasonAlert(false, true);

    console.log("The reason: " + theReason);

    showAlert("Please wait!");

    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/delete_selected_blog_by_admin.php",
        data: {
            blog_id: toDeleteBlogId,
            deletion_message: blogDeletionReason.value
        },
        success: function(response) {
            alert(response);
        }
    });
}