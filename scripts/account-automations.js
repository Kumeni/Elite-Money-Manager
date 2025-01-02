let datesOfTheMonth = [];
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
            frequency.slideTo(0);
            break;
        
        case "monthly":
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