const loadMonthlyIncomeDisplayArea = () => {
    let monthlyIncomeArea = document.getElementById("monthly-income-area");

    $.ajax({
        type: "POST",
        url: "./load_monthly_income_display_area.php",
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

    console.log("THis called");

    if (income.value == null || income.value == undefined || income.value == "") {
        console.log("In here");
        showAlert("Please enter all the details".toUpperCase());
    } else {
        if (bonus.value == null || bonus.value == undefined || bonus.value == "") {
            bonus = 0;
        } else {
            bonus = bonus.value;
        }

        //ajax call to add income to the db
        $.ajax({
            type: "POST",
            url: "./add_monthly_income_to_db.php",
            data: {
                income: income.value,
                month: selectedMonth.value,
                bonus: bonus
            },
            success: function(response) {
                alert(response);
                showAlert("Monthly income updated successfully");
                income.value = "";
                selectedMonth.value = months[new Date().getMonth()];
                bonus.value = "";
                loadMonthlyIncomeDisplayArea();
            },
            error: function(response) {
                alert(response);
            }
        });

    }
}

const addExpenseToDb = (uniqueID) => {
    let expDate = document.getElementById("expenseDate");
    let expTitle = document.getElementById("expenseTitle");
    let expCost = document.getElementById("expenseCost");
    let expCat = document.querySelector( 'input[name="cat"]:checked');   

    // alert("CHecked value = " + expCat.value);
    // console.log("DATE: " + expDate.value)

    if ( expTitle.value == "" || expTitle.value == null || expCost.value == null || expCost.value == "") {
        showAlert("Please enter all the necessary details!");
        return;
    }

    if (expDate.value == "" || expDate.value == null) {
        expDate = new Date().toJSON().slice(0, 10);
        // showAlert(expCat.value);
    } else {
        expDate = expDate.value;
    }

    // showAlert(expDate);

    uniqueID = uniqueID == null || uniqueID == undefined ? 0 : uniqueID;


    $.ajax({
        type: "POST",
        url: "./add_expense_to_db.php",
        data: {
            exp_date: expDate,
            exp_title: expTitle.value,
            cost: expCost.value,
            exp_category: expCat.value,
            unique_id: uniqueID
        },
        success: function(response) {
            // showAlert(response);
            // return;
            expDate.value = "";
            expTitle.value = "";
            expCat.value = "B";
            expCost.value = "";
        },
        error: function(response) {
            showAlert(response);
        }
    });
}

