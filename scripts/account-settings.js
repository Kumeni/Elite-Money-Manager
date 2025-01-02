const manageAccount = (state) => {
    let settingsPopup = document.getElementById("account-settings-popup");
    if(state == false) {
        settingsPopup.style.display = "none";//close the automations-popup
        return;
    }

    console.log("Managing account");
    settingsPopup.style.display = "block";
}