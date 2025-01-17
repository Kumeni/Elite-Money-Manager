let datesOfTheMonth = [],
automationName,
transactionType="deposit",
daysOfTheWeek = [],
paymentMethod = "mpesa",
mpesaPhoneNumber,
targetAmount,
regularDepositAmount,
timeOfTheDay = "10:00",
repetitionFrequency = "weekly",
activeAccountAutomations = [],
activeAutomation = undefined;

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
        let popups = document.getElementsByClassName("popup"), i;
        for(i=0; i < popups.length; i++){
            popups[i].scroll({
                top:0,
                left:0,
                behavior:'smooth'
            });
        }
        resetAutomationForm();
        return;
    }

    accountAutomations.slideTo(1);
    if(state === undefined){
        //Open an empty automation
        resetAutomationForm();
        accountAutomations.slideTo(1);
    } else {
        //fill the form with the provided info
        activeAccountAutomations.forEach((element, index) => {
            if(element.id == state){
                fillAutomationForm(activeAccountAutomations[index]);
                activeAutomation = activeAccountAutomations[index];
            }
        });
        accountAutomations.slideTo(1);
    }
}

const fillAutomationForm = automation => {

    console.log(automation);
    //Automation name
    automationName = automation.name;
    document.getElementById("automation-name").value = automation.name;
    
    //Transaction type
    transactionType = automation.automation_type;
    document.getElementById("automation-type").value = transactionType;
    
    //Payment method
    console.log(automation.payment_method);
    paymentMethod = automation.payment_method;

    let paymentMethodButtons = document.getElementsByClassName("payment-method-button"), i;
    switch (paymentMethod) {
        case "mpesa":
            paymentMethod = "mpesa";
            for(i=0; i<paymentMethodButtons.length; i++){
                if(i == 0) paymentMethodButtons[i].style.boxShadow = "1px 1px 4px rgb(180, 180, 180)";
                else paymentMethodButtons[i].style.boxShadow = "unset";
            }
            paymentMethods.slideTo(0);
            break;
        
        case "visa":
            paymentMethod = "visa";
            paymentMethods.slideTo(1);
            for(i=0; i<paymentMethodButtons.length; i++){
                if(i == 1) paymentMethodButtons[i].style.boxShadow = "1px 1px 4px rgb(180, 180, 180)";
                else paymentMethodButtons[i].style.boxShadow = "unset";
            }
            break;

        default:
            break;
    }

    //M-pesa phone number
    mpesaPhoneNumber = automation.mpesa_phone_number;
    document.getElementById("international-phone-number").value = mpesaPhoneNumber;

    //Target amount
    targetAmount = automation.target_amount;
    document.getElementById("target-amount").value = targetAmount;

    //Regular deposit amount
    regularDepositAmount = automation.regular_deposit_amount;
    document.getElementById("regular-deposit-amount").value = regularDepositAmount;

    //Time of the day
    timeOfTheDay = automation.time_of_the_day;
    document.getElementById("time-of-the-day").value = timeOfTheDay;

    //Frequency
    if(automation.monthly_automations && automation.monthly_automations.length > 0){
        repetitionFrequency = "monthly";

        let frequencyButtons = document.getElementsByClassName("frequency-button"), i;
        for(i=0; i<frequencyButtons.length; i++){
            if(i==0) frequencyButtons[i].style.boxShadow = "unset";
            else frequencyButtons[i].style.boxShadow = "1px 1px 4px rgb(180, 180, 180)";
        }
        
        datesOfTheMonth = [];
        frequency.slideTo(1);
        automation.monthly_automations.forEach(element => {
            datesOfTheMonth = datesOfTheMonth.concat(Number(element.date));
        });
        updateDatesOfTheMonth(datesOfTheMonth);
    } else if (automation.daily_automations && automation.daily_automations.length > 0){
        repetitionFrequency = "weekly";

        let frequencyButtons = document.getElementsByClassName("frequency-button"), i;
        for(i=0; i<frequencyButtons.length; i++){
            if(i==1) frequencyButtons[i].style.boxShadow = "unset";
            else frequencyButtons[i].style.boxShadow = "1px 1px 4px rgb(180, 180, 180)";
        }

        daysOfTheWeek = [];
        frequency.slideTo(0);
        automation.daily_automations.forEach(element => {
            daysOfTheWeek = daysOfTheWeek.concat(Number(element.day_id));
        });

        let daysOfTheWeekCheckboxes = document.getElementsByClassName("dayOfTheWeek");
        for(i=0; i<daysOfTheWeekCheckboxes.length; i++){
            if(daysOfTheWeek.indexOf(i) == -1){
                daysOfTheWeekCheckboxes[i].checked = false;
            } else {
                daysOfTheWeekCheckboxes[i].checked = true;
            }
        }
    }
}

const resetAutomationForm = () => {
    document.getElementById("automation-form").reset();

    //Payment method
    paymentMethod = "mpesa";

    let paymentMethodButtons = document.getElementsByClassName("payment-method-button"), i;
    for(i=0; i<paymentMethodButtons.length; i++){
        if(i == 0) paymentMethodButtons[i].style.boxShadow = "1px 1px 4px rgb(180, 180, 180)";
        else paymentMethodButtons[i].style.boxShadow = "unset";
    }
    paymentMethods.slideTo(0);

    //Frequency

    let frequencyButtons = document.getElementsByClassName("frequency-button");
    for(i=0; i<frequencyButtons.length; i++){
        if(i==0) frequencyButtons[i].style.boxShadow = "1px 1px 4px rgb(180, 180, 180)";
        else frequencyButtons[i].style.boxShadow = "unset";
    }

    datesOfTheMonth = [];
    daysOfTheWeek = [];
    activeAutomation = undefined;
    updateDatesOfTheMonth(datesOfTheMonth);
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
            frequency.slideTo(0);
            break;
        
        case "monthly":
            repetitionFrequency = "monthly";
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

const deleteAccountAutomation = (accountId) => {
    let formData = new FormData();

    formData.append("deleted", accountId);

    const API_ENDPOINT = "./api/manage-automation.php";
    const request = new XMLHttpRequest();

    request.open("POST", API_ENDPOINT, true);
    request.onreadystatechange = () => {
        if(request.readyState === 4 && request.status === 200){
            console.log(request.response);
            let accountAutomations = JSON.parse(request.response);
            activeAccountAutomations = accountAutomations;
            updateActiveAccountAutomations(activeAccountAutomations);
            manageAutomation(false);
            //accounts = JSON.parse(accounts);
            //products = JSON.parse(products);
            //updateAccountsList(accounts);
            //manipulateAccount(false);
            //document.getElementsByClassName("make-transfer-button")[0].disabled = false;
        }
    }

    request.send(formData);
}

const manageAccountAutomation = (event) => {
    event.preventDefault();
    let formData = new FormData(), canSubmit = true;

    console.log("processing the form");
    //if(activeAccount != undefined) formData.append("id", activeAccount.id);

    if(automationName == undefined || automationName == ""){
        document.getElementById("automation-name-error").innerHTML = "Automation Name is required!";
        canSubmit = false;
    }
    console.log("Automation name ", canSubmit);

    if(transactionType == undefined || transactionType == ""){
        document.getElementById("transaction-type-error").innerHTML = "Transaction type is required!";
        canSubmit = false;
    }
    console.log("Transaction type ", canSubmit);

    if(paymentMethod != "mpesa" && paymentMethod != "visa"){
        //display error, payment method is required.
        canSubmit = false;
    }
    console.log("Payment method ", canSubmit);


    if(mpesaPhoneNumber == undefined || mpesaPhoneNumber == ""){
        document.getElementById("phone-number-error").innerHTML = "Mpesa Phone Number is required!";
        canSubmit = false;
    }
    console.log("Mpesa phone number ", canSubmit);
    
    if(regularDepositAmount == undefined || regularDepositAmount == ""){
        document.getElementById("regular-deposit-amount-error").innerHTML = "Regular Deposit Amount is required!";
        canSubmit = false;
    }
    console.log("Regular deposit amount ", canSubmit);

    if(targetAmount == undefined || targetAmount == ""){
        document.getElementById("target-amount-error").innerHTML = "Target Amount is required!";
        canSubmit = false;
    }
    console.log("Target amount", canSubmit);
    
    if(timeOfTheDay == undefined || timeOfTheDay == ""){
        document.getElementById("time-of-the-day-error").innerHTML = "Time of the day is required!";
        canSubmit = false;
    }
    console.log("Time of the day ", canSubmit);

    if(repetitionFrequency != "weekly" && repetitionFrequency != "monthly"){
        //display error, frequency is required.
        canSubmit = false;
    }
    console.log("Payment method ", canSubmit);

    if(repetitionFrequency == "weekly"){
        //Ensure days have been selected, else, throw an error
        if(daysOfTheWeek.length == 0){
            document.getElementById("frequency-error").innerHTML = "Days of the week are required!";
            canSubmit = false;
            console.log("Daily Frequency Check ", canSubmit);
        }
    } else if(repetitionFrequency == "monthly"){
        //Ensure dates have been selected, else, throw an error;
        if(datesOfTheMonth.length == 0){
            document.getElementById("frequency-error").innerHTML = "Dates of the month are required!";
            canSubmit = false;
            console.log("Monthly Frequency Check ", canSubmit);
        }
    }

    accountAutomations.update();
    console.log("done validating");
    if(canSubmit === false) return;

    console.log("uploading data");
    formData.append("automation-name", automationName);
    formData.append("transaction-type", transactionType);
    formData.append("payment-method", paymentMethod);
    formData.append("mpesa-phone-number", mpesaPhoneNumber);
    formData.append("regular-deposit-amount", regularDepositAmount);
    formData.append("target-amount", targetAmount);
    formData.append("account-uuid", accountUuid);
    formData.append("time-of-the-day", timeOfTheDay);
    formData.append("repetition-frequency", repetitionFrequency); //weekly or monthly

    if(activeAutomation != undefined) formData.append("id", activeAutomation.id);

    if(repetitionFrequency == "weekly"){
        formData.append("days-of-the-week", JSON.stringify(daysOfTheWeek));
        formData.append("dates-of-the-month", JSON.stringify([]));
    } else if(repetitionFrequency == "monthly") {
        formData.append("dates-of-the-month", JSON.stringify(datesOfTheMonth));
        formData.append("days-of-the-week", JSON.stringify([]));
    }
    
    
    const API_ENDPOINT = "./api/manage-automation.php";
    const request = new XMLHttpRequest();

    request.open("POST", API_ENDPOINT, true);
    request.onreadystatechange = () => {
        if(request.readyState === 4 && request.status === 200){
            console.log(request.response);
            let accountAutomations = JSON.parse(request.response);
            activeAccountAutomations = accountAutomations;
            updateActiveAccountAutomations(activeAccountAutomations);
            manageAutomation(false);
            //accounts = JSON.parse(accounts);
            //products = JSON.parse(products);
            //updateAccountsList(accounts);
            //manipulateAccount(false);
            //document.getElementsByClassName("make-transfer-button")[0].disabled = false;
        }
    }

    request.send(formData);
}

const getAccountAutomations = () => {
    const API_ENDPOINT = "./api/manage-automation.php?id="+accountUuid;
    const request = new XMLHttpRequest();

    request.open("GET", API_ENDPOINT, true);
    request.onreadystatechange = () => {
        if(request.readyState === 4 && request.status === 200){
            console.log(request.response);
            activeAccountAutomations = JSON.parse(request.response);
            //console.log(activeAccountAutomations);
            updateActiveAccountAutomations(activeAccountAutomations);
        }
    }
    request.send();
}
getAccountAutomations();

const updateActiveAccountAutomations = (activeAccountAutomations) => {
    let accountAutomationList = document.getElementById("list-of-account-automations");

    let innerHTML = ``;
    activeAccountAutomations.forEach((element, index) => {
        innerHTML += `<tr>
                        <td>${index+1}.</td>
                        <td>${element.name}</td>
                        <td title="Manage Automation"><button onclick="manageAutomation(${element.id})"><img src="./assets/icons/Edit-icon.png" /></button></td>
                        <td title="Suspend Automation"><button onclick="suspendAutomation(${element.id})"><img src="./assets/icons/Suspend-icon.png" /></button></td>
                        <td title="Delete Automation"><button onclick="deleteAccountAutomation(${element.id})"><img src="./assets/icons/Delete-icon.png" /></button></td>
                    </tr>`;
    });

    accountAutomationList.innerHTML = innerHTML;
}

const suspendAutomation = automationId => {

}