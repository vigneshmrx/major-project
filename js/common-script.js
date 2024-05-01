(function () {
    if (localStorage.getItem("logged-in") == null || localStorage.getItem("logged-in") == false) {
        location.replace("login.php");
    }
}) ();

const userType = localStorage.getItem("user-type");

if (userType == "writer" && window.location.pathname != "/major-project/dashboard.php") {
    let theNavTag = Array.from(document.getElementsByTagName("nav"));

    theNavTag.forEach((nav) => {

        let a = document.createElement("a");
        a.href = "dashboard.php";

        let div = document.createElement("div");
        div.innerText = "Dashboard";
        div.className = "nav-items";

        a.appendChild(div);

        nav.children[2].after(a);
    });

}

const displayQuote = (quotesObj, pageName) => {
    let quoteBox = document.getElementById("quote-box");

    let randomQuoteObj;

    if (sessionStorage.getItem(pageName) == null || sessionStorage.getItem(pageName) == undefined) {
        randomQuoteObj = quotesObj[Math.floor(Math.random() * quotesObj.length)];
        sessionStorage.setItem(pageName, JSON.stringify(randomQuoteObj));
    } else {
        randomQuoteObj = JSON.parse(sessionStorage.getItem(pageName));
    }

    quoteBox.innerHTML = `\"<i>${randomQuoteObj["Quote"]}</i>\"<br><br>`;
    quoteBox.innerHTML += `<div class="by-line">${randomQuoteObj["By"]}</div>`;
}

const popUpBgFun = () => {
    let popUpBgPage = document.getElementById("pop-up-menu-bg");

    if (popUpBgPage.style.visibility == "visible") {
        popUpBgPage.style.zIndex = -100;
        popUpBgPage.style.visibility = "hidden";
    } else {
        popUpBgPage.style.zIndex = 100;
        popUpBgPage.style.visibility = "visible";
    }
}

const removePopUp = (closeBtnObjRef, funArray) => {

    let topParent = closeBtnObjRef.parentElement.parentElement.parentElement;
    
    topParent.style.zIndex = -150;
    topParent.style.visibility = "hidden";

    popUpBgFun(); // to get the bg page back to -100 z index

    if (funArray != null) {
        funArray.forEach(element => {
            switch (element) {
                case 1: readingGoalModifierFun();
                        break;
    
                case 2: loadToReadContentArea();
                        break;
    
                case 3: loadAlreadyReadBooks();
                        break;

                case 4: loadLoggedExpense();
                        document.getElementById("expenseDate").value = new Date().toJSON().slice(0, 10);
                        document.getElementById("expenseTitle").value = "";
                        document.getElementById("expenseCost").value = "";
                        Array.from(document.querySelectorAll("input[name='cat']"))[1].checked = true;
                        break;
                
                case 5: loadRemainingIncome();
            }
        });
    }
}


const logOutBoxFun = () => {
    popUpBgFun();

    let logOutPage = document.getElementById("log-out-page");

    if (logOutPage.style.visibility == "visible") {
        logOutPage.style.visibility = "hidden";
        logOutPage.style.zIndex = -150;
    } else {
        logOutPage.style.zIndex = 150;
        logOutPage.style.visibility = "visible";
    }
}

const logoutFromHere = () => {
    $.ajax({
        type: "POST",
        url: "./logout.php",
        success: function() {
            sessionStorage.clear();
            localStorage.clear();
            location.href = "login.php";
        }
    });
}

//adding logout box to every page:
document.body.innerHTML += '<div id="log-out-page"><div id="log-out-box"><div id="log-out-text">Are you sure you want to log out?</div><div id="logout-action-area"><input type="button" value="LOG OUT" onclick="logoutFromHere();"><input type="button" value="CANCEL" onclick="logOutBoxFun();"></div></div></div>';

//adding alert box to every page (this will be invisible by default)
document.body.innerHTML += '<div id="alert"><div id="alert-message"></div></div>';

document.body.innerHTML += '<div id="pop-up-menu-bg"></div>';




const showAlert = (message) => {
    let alert = document.getElementById("alert");

    let alertMessage = document.getElementById("alert-message");

    alertMessage.innerHTML = message;

    alert.style.zIndex = 300;
    alert.style.display = "block";

    setTimeout(() => {
        alert.style.zIndex = -300;
        alert.style.display = "none";
    }, 2500);
}

const dismissableAlertFun = (message) => {
    let dismissableAlert = document.getElementById("dismissable-alert");

    let alertMessage = document.getElementById("dismiss-alert-message");

    if (message != '') {
        alertMessage.innerHTML = message;
        dismissableAlert.style.zIndex = 400;
        dismissableAlert.style.visibility = "visible";
    } else {
        dismissableAlert.style.zIndex = -150;
        dismissableAlert.style.visibility = "hidden";
    }
}

const secondaryMenuFun = (toShow) => {
    let secondaryMenu = document.getElementById("secondary-menu");

    if (toShow == true) {
        secondaryMenu.style.transform = "translateX(0px)";
        secondaryMenu.style.visibility = "visible";
    } else {
        secondaryMenu.style.transform = "translateX(-1000px)";
        secondaryMenu.style.visibility = "hidden";
    }
}

const decideOnDownloadBtn = (toShow) => {
    const downloadPdfDiv = document.getElementById("download-pdf");

    try {
        if (downloadPdfDiv.previousElementSibling.firstChild.id != "full-details-table") {
            downloadPdfDiv.style.visibility = "hidden";
        } else {
            downloadPdfDiv.style.visibility = "visible";
        }

    } 
    catch (downloadBtnExc) {}
}

const showFullDetails = (pageName) => {
    let contentArea = document.getElementsByClassName("show-full-details-content-area")[0];
    
    
    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/detailed_table.php",
        data: {
            page_name: pageName,
            db_name: dbName,
        },
        success: function(response) {
            // alert(response);
            contentArea.innerHTML = response;
            decideOnDownloadBtn();
        },
        error: function(response) {
            alert(response);
        }
    })

}

const showFullDetailsBx = (nameOfCat) => {
    let showDetailsPg = document.getElementById("show-full-details-pg");

    popUpBgFun();

    showDetailsPg.style.visibility = "visible";
    showDetailsPg.style.zIndex = 150;

    showFullDetails(nameOfCat);
}

const downloadPdf = (contentName) => {

    location.href = `http://localhost/major-project/content_to_pdf.php?param1=${dbName}&param2=${contentName}`;
}


const showSelectedBlog = (objRef) => {

    if (objRef.parentElement.classList[2] != undefined) {
        window.location.href = "view_blog.php?ff1=" + objRef.parentElement.classList[1] + "&ff2=" + objRef.parentElement.id + "&ff3=" + objRef.parentElement.classList[2];
    } else {
        window.location.href = "view_blog.php?ff1=" + objRef.parentElement.classList[1] + "&ff2=" + objRef.parentElement.id;
    }
}

const showSettings = (toShow, removeBg) => {
    let settingsPage = document.getElementsByClassName("settings-page")[0];

    if (toShow == true) {
        settingsPage.style.visibility = "visible";
        settingsPage.style.zIndex = 150;
        settingsBoxContentToggle(true, false, false);
        changeSettingsBoxGreeting();
        loadSettingsBoxDefaultValues();
    } else {
        settingsPage.style.visibility = "hidden";
        settingsPage.style.zIndex = -150;
    }
    
    if (removeBg == undefined) {
        popUpBgFun();
    }
}

const settingsBoxContentToggle = (firstItemShow, secondItemShow, thirdItemShow) => {

    let defaultContent = document.getElementById("settings-box-default-content");
    let changeNameContent = document.getElementById("change-name-content");
    let changePwdContent = document.getElementById("change-pwd-content");

    if (firstItemShow == true) {
        defaultContent.style.display = "block";
        changeNameContent.style.display = "none";
        changePwdContent.style.display = "none";
    }
    else if (secondItemShow == true) {
        defaultContent.style.display = "none";
        changeNameContent.style.display = "block";
        changePwdContent.style.display = "none";
        document.getElementById("new-first-name").value = "";
        document.getElementById("new-last-name").value = "";
    }
    else if (thirdItemShow == true) {
        defaultContent.style.display = "none";
        changeNameContent.style.display = "none";
        changePwdContent.style.display = "block";
        document.getElementById("new-password").value = "";
        document.getElementById("repeat-new-password").value = "";
    }

}

const loadSettingsBoxDefaultValues = () => {
    let userNameAreaInSettingsBox = document.getElementsByClassName("user-name-in-settings-box")[0];
    let emailAreaInSettingsBox = document.getElementsByClassName("user-email-in-settings-box")[0];
    let joinDateAreaInSettingsBox = document.getElementsByClassName("user-join-date-in-settings")[0];
    let bloggerStatusAreaInSettingsBox = document.getElementsByClassName("user-blogger-status-in-settings")[0];

    userNameAreaInSettingsBox.innerHTML = localStorage.getItem("userName");
    emailAreaInSettingsBox.innerHTML = localStorage.getItem("emailID");

    let monthsArray = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    let date = localStorage.getItem("joinDate");
    let day = parseInt(date.substring(8, 10));
    let month = monthsArray[parseInt(date.substring(5, 7))];
    let year = parseInt(date.substring(0, 4));

    joinDateAreaInSettingsBox.innerHTML = day + " " + month + ", " + year;

    let bloggerStatus = localStorage.getItem("user-type");

    if (bloggerStatus == "writer") {
        bloggerStatusAreaInSettingsBox.innerHTML = "Yes";
    } else {
        bloggerStatusAreaInSettingsBox.innerHTML = "No";
    }
}

const changeNameOfUser = () => {
    let firstName = document.getElementById("new-first-name");
    let lastName = document.getElementById("new-last-name");

    if (firstName.value == "" || lastName.value == "") {
        showAlert("Please enter all the required details");
        return;
    }

    let email_id = localStorage.getItem("emailID");

    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/change-user-info.php",
        data: {
            change_type: 1,
            first_name: firstName.value,
            last_name: lastName.value,
            email: email_id
        },
        success: function(response) {
            showAlert(response);
            localStorage.setItem("userName", firstName.value + " " + lastName.value);
            firstName.value = "";
            lastName.value = "";
            settingsBoxContentToggle(true, false, false);
            changeSettingsBoxGreeting();
            loadSettingsBoxDefaultValues();
        }
    });
}

const changePwdOfUser = () => {
    let newPwd = document.getElementById("new-password");
    let repeatNewPwd = document.getElementById("repeat-new-password");

    if (newPwd.value == "" || repeatNewPwd.value == "") {
        showAlert("Please enter all the required details");
        return;
    } else if (newPwd.value.length < 5 || newPwd.value.length > 60 || repeatNewPwd.value.length < 5 || repeatNewPwd.value.length > 60) {
        showAlert("The password should be between 5 - 30 characters.");
        return;
    }
    else if (newPwd.value != repeatNewPwd.value) {
        showAlert("The two passwords do not match!");
        return;
    }

    let email_id = localStorage.getItem("emailID");

    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/change-user-info.php",
        data: {
            change_type: 2,
            pass: newPwd.value,
            email: email_id
        },
        success: function(response) {
            showAlert(response);
            newPwd.value = "";
            repeatNewPwd.value = "";
            settingsBoxContentToggle(true, false, false);
        }
    });
}

const changeSettingsBoxGreeting = () => {
    let settingsBoxGreeting = document.getElementsByClassName("settings-box-greeting")[0];

    let userNameArray = localStorage.getItem("userName").split(" ");
    settingsBoxGreeting.innerHTML = "Hello, " + userNameArray[0];
}

let settingsPage = '<div class="settings-page"><div class="settings-box"><div class="settings-box-heading-area"><div class="settings-box-heading">SETTINGS</div><div class="close-pop-up-icon-area" onclick="removePopUp(this, []);"><img src="./icons/icons8-close-32.png" alt=""></div></div><hr class="popup-box-hr"><div class="settings-box-greeting"></div><div class="settings-box-dynamic-content"><div id="settings-box-default-content"><div class="user-action"><div class="heading">Account Details</div></div><div class="underline-box"></div><div class="account-details"><div class="bold-details">NAME:</div><div class="det user-name-in-settings-box"></div><div class="bold-details">EMAIL:</div><div class="det user-email-in-settings-box"></div><div class="bold-details">JOINED ON:</div><div class="det user-join-date-in-settings"></div><div class="bold-details">BLOGGER:</div><div class="det user-blogger-status-in-settings"></div><div class="account-details-flex-line"><div onclick="settingsBoxContentToggle(false, true, false);">Change Name</div><div onclick="settingsBoxContentToggle(false, false, true);">Change Password</div><div onclick="toggleDeleteAccAlert(true);">Delete Account</div></div></div></div>';

settingsPage += '<div id="change-name-content"><div class="back-btn-area" onclick="settingsBoxContentToggle(true, false, false);"><abbr title="Back"><img src="./icons/back-arrow.png" alt=""></abbr></div><div class="user-action"><div class="heading">Change Name</div></div><div class="underline-box"></div><div class="change-name-area"><div class="bold-details">NEW FIRST NAME:</div><div class="det"><input type="text" name="" id="new-first-name"></div><div class="bold-details">NEW LAST NAME:</div><div class="det"><input type="text" name="" id="new-last-name"></div><div class="user-action-btn-area"><input type="button" value="SUBMIT" onclick="changeNameOfUser();"><input type="button" value="CANCEL" onclick="settingsBoxContentToggle(true, false, false);"></div></div></div><div id="change-pwd-content"><div class="back-btn-area" onclick="settingsBoxContentToggle(true, false, false);"><abbr title="Back"><img src="./icons/back-arrow.png" alt=""></abbr></div><div class="user-action"><div class="heading">Change Password</div></div><div class="underline-box"></div><div class="change-name-area"><div class="bold-details">NEW PASSWORD:</div><div class="det"><input type="password" name="" id="new-password" minlength="5" maxlength="30"></div><div class="bold-details">REPEAT NEW PASSWORD:</div><div class="det">' + '<input type="password" name="" id="repeat-new-password" minlength="5" maxlength="30"></div><div class="user-action-btn-area"><input type="button" value="SUBMIT" onclick="changePwdOfUser();"><input type="button" value="CANCEL" onclick="settingsBoxContentToggle(true, false, false);"></div></div></div></div></div></div>';

let confirmAccDeleteAlert = '<div class="confirm-delete-acc-page"><div class="confirm-delete-acc-box"><div class="confirm-delete-acc-text">Are you sure you want to delete this account? This action cannot be reversed!</div> <br><br><div class="confirm-delete-acc-action-area" style="display: flex; justify-content: center; align-items: center; gap: 20px;"><input type="button" value="YES" style="width: 100px;" onclick="deleteThisAcc();"><input type="button" value="NO" style="width: 100px;" onclick="toggleDeleteAccAlert(false);"></div></div></div>';


document.body.innerHTML += settingsPage;
document.body.innerHTML += confirmAccDeleteAlert;
document.body.innerHTML += '<div class="dot-spinner"><div class="dot-spinner__dot"></div><div class="dot-spinner__dot"></div><div class="dot-spinner__dot"></div><div class="dot-spinner__dot"></div><div class="dot-spinner__dot"></div><div class="dot-spinner__dot"></div><div class="dot-spinner__dot"></div><div class="dot-spinner__dot"></div></div>';

let loader = document.getElementsByClassName("dot-spinner")[0];

const toggleDeleteAccAlert = (toShow, showBg) => {
    let deleteAccConfirmPage = document.getElementsByClassName("confirm-delete-acc-page")[0];   

    if (toShow == true) {
        showSettings(false, false);
        deleteAccConfirmPage.style.visibility = "visible";
        deleteAccConfirmPage.style.zIndex = 150;
    } else {
        deleteAccConfirmPage.style.visibility = "hidden";
        deleteAccConfirmPage.style.zIndex = -150;
        showSettings(true, false);
    }

    if (showBg == true) {
        popUpBgFun();
    }
}

const deleteThisAcc = () => {
    let loader = document.getElementsByClassName("dot-spinner")[0];
    let deleteUserEmail = localStorage.getItem("emailID");
    // popUpBgFun();
    secondaryMenuFun(false);
    toggleDeleteAccAlert(false, false);
    showSettings(false, false);
    loader.style.visibility = "visible";
    loader.style.zIndex = 160;

    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/delete_this_user.php",
        data: {
            email: deleteUserEmail
        },
        success: function(response) {
            if (response == "Account deleted successfully") {
                popUpBgFun();
                loader.style.visibility = "hidden";
                loader.style.zIndex = -150;
                showAlert(response);
                setTimeout(() => {
                    logoutFromHere();
                }, 1200);
            }
        }
    });
}

