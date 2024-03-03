// const dbName = localStorage.getItem("dbName");

(function () {
    if (localStorage.getItem("logged-in") == null || localStorage.getItem("logged-in") == false) {
        location.replace("login.php");
        // console.log("NOt logged in");
    }
}) ();

const userType = localStorage.getItem("user-type");
// let thePrimaryNavTag = document.getElementById("primary-menu-nav");
// let theSecondaryNavTag = document.getElementById("secondary-menu-nav");

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

// redirect();

const displayQuote = (quotesObj, pageName) => {
    let quoteBox = document.getElementById("quote-box");

    let randomQuoteObj;

    if (sessionStorage.getItem(pageName) == null || sessionStorage.getItem(pageName) == undefined) {
        randomQuoteObj = quotesObj[Math.floor(Math.random() * quotesObj.length)];
        sessionStorage.setItem(pageName, JSON.stringify(randomQuoteObj));
        console.log("inside if");
    } else {
        randomQuoteObj = JSON.parse(sessionStorage.getItem(pageName));
        // console.log(JSON.parse(randomQuoteObj));
        console.log("inside else");
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
    // console.log(closeBtnObjRef.parentElement.parentElement.parentElement);

    let topParent = closeBtnObjRef.parentElement.parentElement.parentElement;
    
    topParent.style.zIndex = -150;
    topParent.style.visibility = "hidden";

    popUpBgFun(); // to get the bg page back to -100 z index

    // if (boxName != null || boxName != undefined) {
    //     // location.reload();
    //     readingGoalModifierFun();
    //     loadToReadContentArea();
    //     loadAlreadyReadBooks();
    // }

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

    // console.log("INSIDE THE FUN");

    if (logOutPage.style.visibility == "visible") {
        logOutPage.style.visibility = "hidden";
        logOutPage.style.zIndex = -150;
        // console.log("INSIDE IF");
    } else {
        logOutPage.style.zIndex = 150;
        logOutPage.style.visibility = "visible";
        // console.log("INSIDE ELSE");
    }
}

const logoutFromHere = () => {
    // console.log("INSIDE HERE");
    $.ajax({
        type: "POST",
        url: "./logout.php",
        success: function() {
            // console.log("IT was a success");
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
    }, 2100);
}

const toTop = document.querySelector(".to-top");

window.addEventListener("scroll", () => {
    if (window.pageYOffset > 100) {
        toTop.classList.add("active");
    } else {
        toTop.classList.remove("active");
    }
});

const secondaryMenuFun = (toShow) => {
    let secondaryMenu = document.getElementById("secondary-menu");

    if (toShow == true) {
        secondaryMenu.style.transform = "translateX(0px)";
        secondaryMenu.style.visibility = "visible";
    } else {
        secondaryMenu.style.transform = "translateX(-1000px)";
        secondaryMenu.style.visibility = "hidden";
    }

    

    // if (secondaryMenu.style.visibility == "hidden") {
        
    // } else {
        
    // }
}

const decideOnDownloadBtn = (toShow) => {
    const downloadPdfDiv = document.getElementById("download-pdf");

    // if (toShow == true) {
    //     downloadPdfDiv.style.visibility = "visible";
    // } else {
    //     downloadPdfDiv.style.visibility = "hidden";
    // }

    try {
        if (downloadPdfDiv.previousElementSibling.firstChild.id != "full-details-table") {
            downloadPdfDiv.style.visibility = "hidden";
        } else {
            downloadPdfDiv.style.visibility = "visible";
        }

    } 
    catch (downloadBtnExc) {
        console.log(downloadBtnExc);
        // downloadPdfDiv.style.visibility = "visible";
    }
}

const showFullDetails = (pageName) => {
    let contentArea = document.getElementsByClassName("show-full-details-content-area")[0];

    // let pdfOutputPgHeading = "Expense Log";
    // let pdfOutputPgContentArea = document.getElementById("show-full-details-content-area-pdf-page");

    // let newPgOutput = `<div id="full-details-pg-heading">${pdfOutputPgHeading}</div>` + content;

    // sessionStorage.setItem("pdf-page-data", pageName);

    
    // pdfOutputPgContentArea.innerHTML = newPgOutput;
    
    
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
    
    // location.replace("http://localhost:8080/major-project/content_to_pdf.php");

}

const showFullDetailsBx = (nameOfCat) => {
    let showDetailsPg = document.getElementById("show-full-details-pg");

    popUpBgFun();

    showDetailsPg.style.visibility = "visible";
    showDetailsPg.style.zIndex = 150;

    showFullDetails(nameOfCat);
}

const downloadPdf = (contentName) => {
    // sessionStorage.setItem("pdf-page-data", contentName);

    // if (contentName == "books") {
    //     location.replace("http://localhost:8080/major-project/books_to_pdf.php?id=" + dbName);
    // } else {
    //     location.replace("http://localhost:8080/major-project/expenses_to_pdf.php");
    // }

    // location.replace("http://localhost:8080/major-project/books_to_pdf.php?param1=" + dbName + "&param2=" + contentName);

    location.replace(`http://localhost:8080/major-project/content_to_pdf.php?param1=${dbName}&param2=${contentName}`);
}


