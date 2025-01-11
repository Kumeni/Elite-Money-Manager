let datesOfTheMonth = [], automationName, transactionType="deposit", daysOfTheWeek = [], paymentMethod = "mpesa", mpesaPhoneNumber, targetAmount, regularDepositAmount, timeOfTheDay, repetitionFrequency = "weekly";

const configureAutomations = (state) => {
    let automationsPopup = document.getElementById("automations-popup");
    if(state == false) {
        automationsPopup.style.display = "none";//close the automations-popup
        accountAutomations.slideTo(0);
        return;
    }

    automationsPopup.style.display = "block";
}

const manageAutomation = (state) => {
    reinitializeAutomationSwipers();
    if(state === false) {
        accountAutomations.slideTo(0);
        return;
    }

    accountAutomations.slideTo(1);
    if(state === undefined){
        //Open an empty automation
        accountAutomations.slideTo(1);
    } else {
        //fill the form with the provided info
        accountAutomations.slideTo(1);
    }
}

const chooseFrequency = (event, automationFrequency) => {
    event.preventDefault();

    let frequencyButtons = document.getElementsByClassName("frequency-button"), i;
    for(i=0; i<frequencyButtons.length; i++){
        frequencyButtons[i].style.boxShadow = "unset";
    }
    event.target.style.boxShadow = "1px 1px 4px rgb(180, 180, 180)";

    switch (automationFrequency) {
        case "weekly":
            repetitionFrequency = "weekly";
            console.log(repetitionFrequency);
            frequency.slideTo(0);
            break;
        
        case "monthly":
            repetitionFrequency = "monthly";
            console.log(repetitionFrequency);
            frequency.slideTo(1);
            break;

        default:
            break;
    }
}

const choosePaymentMethod = (event, paymentMethod) => {
    event.preventDefault();

    let paymentMethodButtons = document.getElementsByClassName("payment-method-button"), i;
    for(i=0; i<paymentMethodButtons.length; i++){
        paymentMethodButtons[i].style.boxShadow = "unset";
    }
    event.target.style.boxShadow = "1px 1px 4px rgb(180, 180, 180)";

    switch (paymentMethod) {
        case "mpesa":
            paymentMethod = "mpesa";
            console.log(paymentMethod);
            paymentMethods.slideTo(0);
            break;
        
        case "visa":
            paymentMethods.slideTo(1);
            break;

        default:
            break;
    }
}

const handleDateClick = event => {
    let selectedDate = Number(event.target.innerHTML)
    if(datesOfTheMonth.indexOf(selectedDate) == -1){
        datesOfTheMonth = datesOfTheMonth.concat(selectedDate);
        document.getElementById("frequency-error").innerHTML = "";
    } else {
        datesOfTheMonth.splice(datesOfTheMonth.indexOf(selectedDate), 1);
    }
    updateDatesOfTheMonth(datesOfTheMonth);
}

const updateDatesOfTheMonth = selectedDates => {
    /**
     * If innerHTML is in the selectedDates, update the element
     */
    let datesOfTheMonth = document.getElementsByClassName("date-of-the-month"), i;
    for(i=0; i<datesOfTheMonth.length; i++){
        if(selectedDates.indexOf(Number(datesOfTheMonth[i].innerHTML)) == -1){
            datesOfTheMonth[i].style.color = "black";
            datesOfTheMonth[i].style.backgroundColor = "white";
        } else {
            datesOfTheMonth[i].style.color = "white";
            datesOfTheMonth[i].style.backgroundColor = "black";
        }
    }

}

const handleAccountEdit = event => {
    event.preventDefault();

    console.log("Submitting event form");
}

const handleAutomationNameChange = event => {
    automationName = event.target.value;
    document.getElementById("automation-name-error").innerHTML = "";
}

const handleTransactionTypeChange = event => {
    transactionType = event.target.value;
    document.getElementById("transaction-type-error").innerHTML = "";
}

const handlePhoneNumberChange = event => {
    mpesaPhoneNumber = event.target.value;
    document.getElementById("phone-number-error").innerHTML = "";
}

const handleTargetAmount = event => {
    targetAmount = event.target.value;
    document.getElementById("target-amount-error").innerHTML = "";
}

const handleRegularDepositAmount = event => {
    regularDepositAmount = event.target.value;
    document.getElementById("regular-deposit-amount-error").innerHTML = "";
}

const handleTimeOfTheDay = event => {
    timeOfTheDay = event.target.value;
    document.getElementById("time-of-the-day-error").innerHTML = "";
}

const handleDayOfTheWeekChange = (event, dayOfTheWeek) => {
    if(event.target.checked){
        if(daysOfTheWeek.indexOf(dayOfTheWeek) == -1){
            daysOfTheWeek = daysOfTheWeek.concat(dayOfTheWeek);
            document.getElementById("frequency-error").innerHTML = "";
        }
    } else {
        if(daysOfTheWeek.indexOf(dayOfTheWeek) != -1){
            daysOfTheWeek.splice(daysOfTheWeek.indexOf(dayOfTheWeek), 1);
        }
    }

    console.log(daysOfTheWeek);
}

const manageAccountAutomation = (event) => {
    event.preventDefault();
    let formData = new FormData(), canSubmit = true;

    //if(activeAccount != undefined) formData.append("id", activeAccount.id);

    if(automationName == undefined || automationName == ""){
        document.getElementById("automation-name-error").innerHTML = "Automation Name is required!";
        canSubmit = false;
    }

    if(transactionType == undefined || transactionType == ""){
        document.getElementById("transaction-type-error").innerHTML = "Transaction type is required!";
        canSubmit = false;
    }

    if(paymentMethod != "mpesa" || paymentMethod != "visa"){
        //display error, payment method is required.
        canSubmit = false;
    }

    if(mpesaPhoneNumber == undefined || mpesaPhoneNumber == ""){
        document.getElementById("phone-number-error").innerHTML = "Mpesa Phone Number is required!";
        canSubmit = false;
    }
    
    if(regularDepositAmount == undefined || regularDepositAmount == ""){
        document.getElementById("regular-deposit-amount-error").innerHTML = "Regular Deposit Amount is required!";
        canSubmit = false;
    }

    if(targetAmount == undefined || targetAmount == ""){
        document.getElementById("target-amount-error").innerHTML = "Target Amount is required!";
        canSubmit = false;
    }
    
    if(timeOfTheDay == undefined || timeOfTheDay == ""){
        document.getElementById("time-of-the-day-error").innerHTML = "Time of the day is required!";
        canSubmit = false;
    }

    if(repetitionFrequency != "weekly" || paymentMethod != "monthly"){
        //display error, frequency is required.
        canSubmit = false;
    }

    if(repetitionFrequency == "weekly"){
        //Ensure days have been selected, else, throw an error
        if(daysOfTheWeek.length == 0){
            document.getElementById("frequency-error").innerHTML = "Days of the week are required!";
            canSubmit = false;
        }
    } else if(repetitionFrequency == "monthly"){
        //Ensure dates have been selected, else, throw an error;
        if(datesOfTheMonth.length == 0){
            document.getElementById("frequency-error").innerHTML = "Dates of the month are required!";
            canSubmit = false;
        }
    }

    accountAutomations.update();
    if(canSubmit === false) return;

    formData.append("automation-name", automationName);
    formData.append("transaction-type", transactionType);
    formData.append("payment-method", paymentMethod);
    formData.append("mpesa-phone-number", mpesaPhoneNumber);
    formData.append("regular-deposit-amount", regularDepositAmount);
    formData.append("target-amount", targetAmount);
    formData.append("time-of-the-day", timeOfTheDay);
    formData.append("repetition-frequency", repetitionFrequency); //weekly or monthly
    formData.append("days-of-the-week", daysOfTheWeek);
    formData.append("dates-of-the-month", datesOfTheMonth);
    
    const API_ENDPOINT = "./api/manage-account.php";
    const request = new XMLHttpRequest();

    request.open("POST", API_ENDPOINT, true);
    request.onreadystatechange = () => {
        if(request.readyState === 4 && request.status === 200){
            console.log(request.response);
            accounts = JSON.parse(request.response);
            //accounts = JSON.parse(accounts);
            //products = JSON.parse(products);
            updateAccountsList(accounts);
            manipulateAccount(false);
            document.getElementsByClassName("make-transfer-button")[0].disabled = false;
        }
    }
    request.send(formData);
}