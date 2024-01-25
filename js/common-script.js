const displayQuote = (quotesObj) => {
    let quoteBox = document.getElementById("quote-box");

    let randomQuoteObj = quotesObj[Math.floor(Math.random() * quotesObj.length)];

    quoteBox.innerHTML = `\"<i>${randomQuoteObj["Quote"]}</i>\"<br><br>`;
    quoteBox.innerHTML += `<div class="by-line">- ${randomQuoteObj["By"]}</div>`;
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

const removePopUp = (closeBtnObjRef) => {
    // console.log(closeBtnObjRef.parentElement.parentElement.parentElement);

    let topParent = closeBtnObjRef.parentElement.parentElement.parentElement;
    
    topParent.style.zIndex = -150;
    topParent.style.visibility = "hidden";

    popUpBgFun(); // to get the bg page back to -100 z index

    location.reload();
}