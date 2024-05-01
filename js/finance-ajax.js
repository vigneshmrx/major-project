const dbName = localStorage.getItem("dbName");
const userName = localStorage.getItem("userName");
const emailID = localStorage.getItem("emailID");
const monthsArray = ["January","February","March","April","May","June","July","August","September","October","November","December"];

//setting today's date automatically
document.getElementById("expenseDate").value = new Date().toJSON().slice(0, 10);

const loadMonthlyIncomeDisplayArea = () => {
    let monthlyIncomeArea = document.getElementById("monthly-income-area");

    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/load_monthly_income_display_area.php",
        data: {
            db_name: dbName
        },
        success: function(response) {
            monthlyIncomeArea.innerHTML = response;
        }
    });
}

loadMonthlyIncomeDisplayArea();

const addNewIncomeToDb = () => {
    let income = document.getElementById("monthIncome");
    let selectedMonth = document.getElementById("selectedMonth");
    let bonus = document.getElementById("bonus");
    let selectedMonthsYear = document.getElementById("selectedMonthsYear");

    let months = ["January","February","March","April","May","June","July","August","September","October","November","December"];

    if (income.value == null || income.value == undefined || income.value == "") {
        showAlert("Please enter all the details");
    } else if (income.value > 50000000) {
        showAlert("Income should be less than 50 million");
    } else if (bonus.value > 50000000) {
        showAlert("Bonus should be less than 50 million");
    }
    else {
        if (bonus.value == null || bonus.value == undefined || bonus.value == "") {
            bonus = 0;
        } else {
            bonus = bonus.value;
        }

        //ajax call to add income to the db
        $.ajax({
            type: "POST",
            url: "../major-project/php-ajax/add_monthly_income_to_db.php",
            data: {
                year: selectedMonthsYear.value,
                income: income.value,
                month: selectedMonth.value,
                bonus: bonus,
                db_name: dbName
            },
            success: function(response) {
                showAlert("Monthly income updated successfully");
                income.value = "";
                // selectedMonth.value = months[new Date().getMonth()];
                document.getElementById("bonus").value = "";
                removePopUp(document.getElementsByClassName("close-pop-up-icon-area")[1], [5]);
                loadMonthlyIncomeDisplayArea();
            },
            error: function(response) {
                alert(response);
            }
        });

    }
}

const addExpenseToDb = () => {
    let expDate = document.getElementById("expenseDate");
    let expTitle = document.getElementById("expenseTitle");
    let expCost = document.getElementById("expenseCost");
    let expCat = document.querySelector( 'input[name="cat"]:checked');   
    let month;
    const uniqueId = parseInt(document.getElementsByClassName("expLogForm")[0].id);

    if (expTitle.value == "" || expTitle.value == null || expCost.value == null || expCost.value == "") {
        showAlert("Please enter all the necessary details correctly!");
        return;
    } else if (expCost.value > 1000000) {
        showAlert("The cost of expense cannot be more than 1 million");
        return;
    }

    if (expDate.value == "" || expDate.value == null) {

        expDate = new Date();
        month = expDate.slice(5, 7);
        expDate = expDate.toJSON().slice(0, 10);
    } else {
        expDate = expDate.value;
        month = expDate.slice(5, 7);
    }


    //setting the correct index for monthsArray
    month != 0 ? month = month - 1 : month = month;


    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/add_expense_to_db.php",
        data: {
            exp_date: expDate,
            exp_title: expTitle.value,
            cost: expCost.value,
            exp_category: expCat.value,
            unique_id: uniqueId,
            db_name: dbName,
            month: monthsArray[month]
        },
        success: function(response) {
            // alert(response);
            // return;
            expDate.value = new Date().toJSON().slice(0, 10);
            expTitle.value = "";
            // expCat.value = "B";
            Array.from(document.querySelectorAll("input[name='cat']"))[1].checked = true;
            expCost.value = "";
            showAlert("Expese logged successfully!")
        },
        error: function(response) {
            showAlert(response);
        }
    });
}

const loadLoggedExpense = () => {
    let expInfoDisplayArea = document.getElementById("exp-track-content");

    let selectedExpMonthBar = document.getElementById("exp-track-header");

    // let monthsArray = ["January","February","March","April","May","June","July","August","September","October","November","December"];

    let currentMonth = new Date().getMonth();
    let getPresentYear = new Date().getFullYear();

    let expTrackHeaderContent = `<div>LOG EXPENSES</div><div><select id='expense-months' onchange='monthChangeFun(event);'>`;

    if (sessionStorage.getItem("selected-exp-month") == null || sessionStorage.getItem("selected-exp-month") == undefined) {
        sessionStorage.setItem("selected-exp-month", monthsArray[currentMonth]);
    }
    if (sessionStorage.getItem("selected-exp-month-year") == null || sessionStorage.getItem("selected-exp-month-year") == undefined) {
        sessionStorage.setItem("selected-exp-month-year", getPresentYear);
    }

    let selectedExpMonth = sessionStorage.getItem("selected-exp-month");
    let selectedExpMonthYear = sessionStorage.getItem("selected-exp-month-year");


    for (element in monthsArray) {
        if (monthsArray[element] == selectedExpMonth) {
            expTrackHeaderContent += `<option value='${monthsArray[element]}'  selected>${monthsArray[element]}</option>'`;
        } else {
            expTrackHeaderContent += `<option value='${monthsArray[element]}'>${monthsArray[element]}</option>'`;
        }

        if (monthsArray[currentMonth] == monthsArray[element] && selectedExpMonthYear != getPresentYear - 1) {
            break;
        }
    };

    expTrackHeaderContent += `</select> - <select id="expense-months-year" onchange="monthYearChangeFun(event);">`;

    let yearsArray = [getPresentYear - 1, getPresentYear];

    yearsArray.forEach((year) => {

        if (year == selectedExpMonthYear) {
            expTrackHeaderContent += `<option value=${year} selected>${year}</option>`;
        } else {
            expTrackHeaderContent += `<option value=${year}>${year}</option>`;
        }
    });

    expTrackHeaderContent += `</select></div>`;

    //final closing select tag for months
    
    // expTrackHeaderContent += `<option value=${getPresentYear}>${getPresentYear}</option></select>` + `</div>`;

    selectedExpMonthBar.innerHTML = expTrackHeaderContent; //to fill exp-track-header

    let totalExpBar = document.getElementById("total-exp-amt-bar");

    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/load_exp_info.php",
        data: {
            db_name: dbName,
            selected_exp_month: selectedExpMonth,
            selected_exp_month_year: selectedExpMonthYear
        },
        success: function(response) {
            let respArr = response.split("//total:");
            console.log(respArr);
            expInfoDisplayArea.innerHTML = respArr[0];
            if (respArr[1] == 0 || respArr[1] == undefined) {
                totalExpBar.style.visibility = "hidden";
                totalExpBar.style.zIndex = -150;
            } else {
                totalExpBar.innerHTML = "Total: " + respArr[1];
                totalExpBar.style.visibility = "visible";
                totalExpBar.style.zIndex = 50;
            }
        }
    });
}

loadLoggedExpense();

const monthChangeFun = (event) => {
    sessionStorage.setItem("selected-exp-month", event.target.value);
    loadLoggedExpense();
}

const monthYearChangeFun = (event) => {
    sessionStorage.setItem("selected-exp-month-year", event.target.value);
    loadLoggedExpense();
}

const removeThisExpFromDb = (objRef) => {
    const recUniqueId = parseInt(objRef.parentElement.id);

    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/remove_from_db.php",
        data: {
            unique_id: recUniqueId,
            db_name: dbName,
            table_name: "monthly_expense"
        },
        success: function(response) {
            loadLoggedExpense();
            loadRemainingIncome();
            // alert(response);
            showAlert("Expense deleted successfully!");
        },
        error: function(response) {
            alert(response);
        }
    })
} 

const editThisExp = (objRef) => {
    const recUniqueId = objRef.parentElement.id;
    const expDate = objRef.parentElement.parentElement.parentElement.firstChild.firstChild.innerHTML; //getting the expense date

    const expDesc = objRef.parentElement.previousElementSibling.firstElementChild.innerHTML;
    let cost = objRef.parentElement.previousElementSibling.lastElementChild.firstChild.innerHTML;
    cost = cost.replaceAll(",", "");
    cost = parseFloat(cost);
    const expCategory = objRef.parentElement.previousElementSibling.lastElementChild.id;

    console.log(cost);

    showLogExpensePopup(recUniqueId, expDate, expDesc, cost, expCategory);
}

const loadRemainingIncome = () => {
    let incomeAfterExpesenArea = document.getElementById("income-after-expense-area");

    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/load_total_remaining_income.php",
        data: {
            db_name: dbName
        },
        success: function(response) {
            let respLen = response.length;
            let theRealString = response.slice(0, respLen - 1);
            let spentMoreThanEightyPer = response.slice(respLen - 1, respLen);
            // alert(theRealString);
            // alert(spentMoreThanEightPer);


            incomeAfterExpesenArea.innerHTML = theRealString;
            let shownEightyPercentAlert = sessionStorage.getItem("shown-eighty-percent-spent-alert");

            if (spentMoreThanEightyPer != "0" && (shownEightyPercentAlert != "true" || shownEightyPercentAlert == undefined)) {
                // showAlert("ALERT: You have spent more than 80% of your income.");
                dismissableAlertFun("ALERT: You have spent more than 80% of your income!");
                sessionStorage.setItem("shown-eighty-percent-spent-alert", true);
            }

            // alert(response.slice(response.length - 5, response.length));
            // alert(typeof(response));
        }
    })
}

loadRemainingIncome();


const loadMonthsInIncomeInputBox = (objRef) => {
    let selectedMonthDropDown = document.getElementById("selectedMonth");
    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();

    let tempContent = ``;
    const arrLen = monthsArray.length;

    if (objRef != null && objRef.value < currentYear) {
        for (let i = 0; i < arrLen; i++) {
            let monthInLoop = monthsArray[i];
            if (monthInLoop == "January") {
                tempContent += `<option value=${monthInLoop} selected>${monthInLoop}</option>`;
            } else {
                tempContent += `<option value=${monthInLoop}>${monthInLoop}</option>`;
            }
        }
    }
    else {
        for (let i = 0; i < arrLen; i++) {
            let monthInLoop = monthsArray[i];
            if (currentMonth == i) {
                tempContent += `<option value=${monthInLoop} selected>${monthInLoop}</option>`;
                break;
            } else {
                tempContent += `<option value=${monthInLoop}>${monthInLoop}</option>`;
            }
        }
    }

    selectedMonthDropDown.innerHTML = tempContent;
}

const loadYearsInIncomeInputBox = () => {
    let selectedMonthsYearDropDown = document.getElementById("selectedMonthsYear");
    let currentYear = new Date().getFullYear();

    let tempContent = ``;

    tempContent = `<option value=${currentYear - 1}>${currentYear - 1}</option><option value=${currentYear} selected>${currentYear}</option>`;

    selectedMonthsYearDropDown.innerHTML = tempContent;
}