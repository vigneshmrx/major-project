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

    let months = ["January","February","March","April","May","June","July","August","September","October","November","December"];

    // console.log("THis called");

    if (income.value == null || income.value == undefined || income.value == "") {
        console.log("In here");
        showAlert("Please enter all the details");
    } else {
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
                income: income.value,
                month: selectedMonth.value,
                bonus: bonus,
                db_name: dbName
            },
            success: function(response) {
                alert(response);
                showAlert("Monthly income updated successfully");
                income.value = "";
                selectedMonth.value = months[new Date().getMonth()];
                // bonus.value = "";
                document.getElementById("bonus").value = "";
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

    let expTrackHeaderContent = `<div>LOG EXPENSES</div><div><select id='expense-months' onchange='monthChangeFun(event);'>`;

    if (sessionStorage.getItem("selected-exp-month") == null || sessionStorage.getItem("selected-exp-month") == undefined) {
        sessionStorage.setItem("selected-exp-month", monthsArray[currentMonth]);
    }

    let selectedExpMonth = sessionStorage.getItem("selected-exp-month");

    for (element in monthsArray) {
        if (monthsArray[element] == selectedExpMonth) {
            expTrackHeaderContent += `<option value='${monthsArray[element]}'  selected>${monthsArray[element]}</option>'`;
        } else {
            expTrackHeaderContent += `<option value='${monthsArray[element]}'>${monthsArray[element]}</option>'`;
        }

        if (monthsArray[currentMonth] == monthsArray[element]) {
            break;
        }
    };

    //final closing select tag for months
    expTrackHeaderContent += `</select> - ` + new Date().getFullYear() + `</div>`;

    selectedExpMonthBar.innerHTML = expTrackHeaderContent; //to fill exp-track-header

    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/load_exp_info.php",
        data: {
            db_name: dbName,
            selected_exp_month: selectedExpMonth
        },
        success: function(response) {
            expInfoDisplayArea.innerHTML = response;
        },
        error: function(error) {
            alert(error);
        }
    })
}

loadLoggedExpense();

const monthChangeFun = (event) => {
    sessionStorage.setItem("selected-exp-month", event.target.value);
    loadLoggedExpense();
}

const removeThisExpFromDb = (objRef) => {
    const recUniqueId = parseInt(objRef.parentElement.id);
    console.log(recUniqueId);

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
    const cost = parseFloat(objRef.parentElement.previousElementSibling.lastElementChild.firstChild.innerHTML);
    const expCategory = objRef.parentElement.previousElementSibling.lastElementChild.id;

    console.log(expDate + "\n" + expDesc + "\n" + cost + "\n" + recUniqueId + "\n" + expCategory);

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