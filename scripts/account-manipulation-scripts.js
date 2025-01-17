let accountName, activeAccount, accounts;

const manipulateAccount = (state) => {

    const accountFormPopup = document.getElementById("account-form-popup");
    const accountFormTitle = document.getElementById("account-form-title");
    const accountFormNameInput = document.getElementById("account-name-input");
    const accountFormSubmitButton = document.getElementById("account-form-submit-button");

    if(state === false){
        //reset form
        document.getElementById("manipulate-account-form").reset();
        accountFormSubmitButton.innerHTML = "Create Account";
        accountName = undefined;
        activeAccount = undefined;

        closePopups();
        return;
    }

    if(state == undefined){
        accountFormTitle.innerHTML = "Create Account";
        accountFormSubmitButton.innerHTML = "Create Account";
    } else {
        accountFormTitle.innerHTML = "Edit Account";
        accountFormSubmitButton.innerHTML = "Edit Account";
        activeAccount = state;
        accountName = state.name;
        accountFormNameInput.value = accountName;
    }
    
    accountFormPopup.style.display = "block";
}

const handleAccountNameChange = event => {
    accountName = event.target.value;
    document.getElementById("account-name-error").innerHTML = "";
}

const submitAccountForm = event => {
    event.preventDefault();
    handleAccountFormSubmit();
    //document.getElementById("manipulate-account-form").submit();
}

const handleAccountFormSubmit = (event) => {
    //event.preventDefault();
    let canSubmit = true;
    document.getElementsByClassName("make-transfer-button")[0].disabled = true;

    /**
     * Form validation, ensure the account name is present
     */
    if(accountName == undefined || accountName == ""){
        /**Account name is required */
        canSubmit = false;
        document.getElementById("account-name-error").innerHTML = "Account Name is Required!";
    }

    if(canSubmit == false) return;

    let formData = new FormData();

    if(activeAccount != undefined) formData.append("id", activeAccount.id);
    formData.append("account-name", accountName);
    
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

const getUserAccounts = () => {
    const API_ENDPOINT = "./api/manage-account.php";
    const request = new XMLHttpRequest();

    request.open("GET", API_ENDPOINT, true);
    request.onreadystatechange = () => {
        if(request.readyState === 4 && request.status === 200){
            console.log(request.response);
            accounts = JSON.parse(request.response);
            updateAccountsList(accounts);
        }
    }
    request.send();
}
getUserAccounts();

const updateAccountsList = (accounts) => {

    let accountsTable = document.getElementsByClassName("accounts-table")[0];

    let innerHTML = `<thead></thead>
        <tbody>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Unique ID</th>
                <th>Balance</th>
            </tr>`;

            accounts.forEach((account, index) => {
                innerHTML += `
                    <tr>
                        <td>${index+1}.</td>
                        <td><a href="./account.php?id=${account.account_uuid}">${account.name}</a></td>
                        <td>${account.account_uuid}</td>
                        <td>${account.balance}</td>
                        <td><img src="./assets/icons/Copy-icon.png" alt="copy icon" class="copy-icon" title="Copy Unique ID to clipboard"/></td>
                        <td><img src="./assets/icons/Share-icon.png" alt="share icon" class="share-icon" title="Make Transfers"/></td>
                        <td><img onclick='manipulateAccount(${JSON.stringify(account)})' src="./assets/icons/Edit-icon.png" alt="edit icon" class="edit-icon" title="Edit account"/></td>
                    </tr>
                `;
            });
            
        innerHTML += `
        </tbody>`;

    accountsTable.innerHTML = innerHTML;
}