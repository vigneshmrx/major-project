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

const removePopUp = (closeBtnObjRef, boxName) => {
    // console.log(closeBtnObjRef.parentElement.parentElement.parentElement);

    let topParent = closeBtnObjRef.parentElement.parentElement.parentElement;
    
    topParent.style.zIndex = -150;
    topParent.style.visibility = "hidden";

    popUpBgFun(); // to get the bg page back to -100 z index

    if (boxName != null || boxName != undefined) {
        // location.reload();
        readingGoalModifierFun();
        loadToReadContentArea();
        loadAlreadyReadBooks();
    }
}


const logOutBoxFun = () => {
    popUpBgFun();

    let logOutPage = document.getElementById("log-out-page");

    console.log("INSIDE THE FUN");

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

const secondaryMenuFun = () => {
    let secondaryMenu = document.getElementById("secondary-menu");

    if (secondaryMenu.style.visibility == "hidden") {
        secondaryMenu.style.transform = "translateX(0px)";
        secondaryMenu.style.visibility = "visible";
    } else {
        secondaryMenu.style.transform = "translateX(-1000px)";
        secondaryMenu.style.visibility = "hidden";
    }
}