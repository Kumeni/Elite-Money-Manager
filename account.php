<?php
    require './api/db.php';
    require './api/db-operations.php';
    require './api/upload.php';

    $userId = 1;
    $account_uuid = $_GET["id"];

    function getUserAccounts($host, $user, $password, $database, $userId){
        $sql = "SELECT * FROM accounts WHERE user_id=$userId AND deleted='0'";
        $userAccounts = find($host, $user, $password, $database, $sql);

        $newArray = [];
        foreach ($userAccounts as $index => $userAccount){
            # code...
            $newArray[] = $userAccount;
        }

        return $newArray;
    }

    function getAccount($userAccounts, $account_uuid){
        //$userAccount = [];
        for ($i=0; $i < count($userAccounts) ; $i++) {
            # code...
            if($userAccounts[$i]["account_uuid"] == $account_uuid){
                $userAccount = $userAccounts[$i];
            }
        }

        return $userAccount;
    }

    $userAccounts = getUserAccounts($host, $user, $password, $database, $userId);
    $userAccount = getAccount($userAccounts, $account_uuid);
    
    function getUserAutomations($host, $user, $password, $database, $userId){
        /**
         * Get all the automations
         */
        $sql = "SELECT * FROM automations WHERE deleted='0' AND user_id='$userId'";
        $automations = find($host, $user, $password, $database, $sql);

        $newArray = [];

        foreach ($automations as $index => $automation) {
            # code...
            unset($automation["deleted"]);
            $automationId = $automation["id"];

            $sql = "SELECT * FROM payment_methods WHERE deleted='0'";
            $paymentMethods = find($host, $user, $password, $database, $sql);
            foreach ($paymentMethods as $index => $paymentMethod) {
                # code...
                
                if($paymentMethod["id"] == $automation["payment_method_id"]){
                    $automation["payment_method"] = $paymentMethod["name"];
                }
                //$automation["payment_method"] = "mpesa";
            }
            unset($automation["payment_method_id"]);
            
            $sql = "SELECT * FROM automation_types WHERE deleted='0'";
            $automationTypes = find($host, $user, $password, $database, $sql);
            foreach ($automationTypes as $index => $automationType) {
                # code...
                if($automationType["id"] == $automation["automation_type_id"]){
                    $automation["automation_type"] = $automationType["name"];
                }
            }
            unset($automation["automation_type_id"]);

            $newArray2 = [];
            /**
             * Get all related daily automations
             */
            $sql = "SELECT * FROM daily_automations WHERE deleted='0' AND automation_id='$automationId'";
            $dailyAutomations = find($host, $user, $password, $database, $sql);
            foreach ($dailyAutomations as $index => $dailyAutomation) {
                # code...
                unset($dailyAutomation["deleted"]);
                $newArray2[] = $dailyAutomation;
            }

            $dailyAutomations = $newArray2;
            if(count($dailyAutomations) > 0){
                $automation["daily_automations"] = $dailyAutomations;
            }

            $newArray2 = [];
            
            /**
             * Get all related monthly automations
             */
            $sql = "SELECT * FROM monthly_automations WHERE deleted='0' AND automation_id='$automationId'";
            $monthlyAutomations = find($host, $user, $password, $database, $sql);
            foreach ($monthlyAutomations as $index => $monthlyAutomation) {
                # code...
                unset($monthlyAutomation["deleted"]);
                $newArray2[] = $monthlyAutomation;
            }

            $monthlyAutomations = $newArray2;
            if(count($monthlyAutomations) > 0){
                $automation["monthly_automations"] = $monthlyAutomations;
            }

            $newArray[] = $automation;
        }
        
        $automations = $newArray;
        
        return $automations;
    }

    function getAccountAutomations($userAutomations, $account_uuid){

        $newArray = [];
        foreach ($userAutomations as $index => $userAutomation) {
            # code...
            if($userAutomation["account_uuid"] == $account_uuid){
                $newArray[] = $userAutomation;
            }
        }

        return $newArray;
    }

    $userAutomations = getUserAutomations($host, $user, $password, $database, $userId);
    $accountAutomations = getAccountAutomations($userAutomations, $account_uuid);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="./styles/global.css" />
    <link rel="stylesheet" type="text/css" href="./styles/profile.css" />
    <link rel="stylesheet" type="text/css" href="./styles/my-accounts.css" />
    <link rel="stylesheet" type="text/css" href="./styles/automation-form.css" />
    <link rel="stylesheet" type="text/css" href="./styles/account.css" />
    <link rel="stylesheet" type="text/css" href="./styles/popup.css" />
    
    <link rel="stylesheet" href="./scripts/swiper/swiper-bundle.min.css" type="text/css"/>
    <?php
        echo "<script> let accountUuid = \"$account_uuid\";</script>";
    ?>
    
    <title>Account | <?php echo $userAccount["name"] ?></title>
</head>
<body>
    <main>
        <section>
            <div class="profile">
                <img src="./assets/icons/Profile-icon.png" />
                <p>John Doe</p>
            </div>
        </section>
        <div class="border"></div>
        <section class="accounts">
            <h1>My Account | <?php echo $userAccount["name"]; ?></h1>
            <div class="underline"></div>
            <div>
                <table class="account-balance-table">
                    <thead></thead>
                    <tbody>
                        <tr>
                            <th>Balance:</th>
                            <td>Ksh. 3,400</td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="quick-actions">
                    <button title="Copy Account ID to Clipboard"><img src="./assets/icons/Copy-icon.png" alt="copy icon"/><span>Copy Account ID to clipboard</span></button>
                    <button title="Make transactions from Account"><img src="./assets/icons/Share-icon.png" alt="share icon"/><span>Make Transfers From Account</span></button>
                </div>

                <h2 class="recent-transactions-title">Recent Transactions</h2>
                <div class="underline"></div>
                <section class="recent-transactions">
                    <div class="recent-transaction">
                        <div>
                            <p>Account Name</p>
                            <p>Saturday, 12 December 2024 11:00 PM</p>
                        </div>
                        <div>
                            <p class="debit">+Ksh. 300</p>
                        </div>
                    </div>
                    <div class="recent-transaction">
                        <div>
                            <p>Account Name</p>
                            <p>Saturday, 12 December 2024 11:00 PM</p>
                        </div>
                        <div>
                            <p class="credit">-Ksh. 300</p>
                        </div>
                    </div>
                    <div class="recent-transaction">
                        <div>
                            <p>Account Name</p>
                            <p>Saturday, 12 December 2024 11:00 PM</p>
                        </div>
                        <div>
                            <p class="debit">+Ksh. 300</p>
                        </div>
                    </div>
                    <div class="recent-transaction">
                        <div>
                            <p>Account Name</p>
                            <p>Saturday, 12 December 2024 11:00 PM</p>
                        </div>
                        <div>
                            <p class="credit">-Ksh. 300</p>
                        </div>
                    </div>
                    <div class="recent-transaction">
                        <div>
                            <p>Account Name</p>
                            <p>Saturday, 12 December 2024 11:00 PM</p>
                        </div>
                        <div>
                            <p class="debit">+Ksh. 300</p>
                        </div>
                    </div>
                    <div class="recent-transaction">
                        <div>
                            <p>Account Name</p>
                            <p>Saturday, 12 December 2024 11:00 PM</p>
                        </div>
                        <div>
                            <p class="credit">-Ksh. 300</p>
                        </div>
                    </div>
                    <div class="recent-transaction">
                        <div>
                            <p>Account Name</p>
                            <p>Saturday, 12 December 2024 11:00 PM</p>
                        </div>
                        <div>
                            <p class="debit">+Ksh. 300</p>
                        </div>
                    </div>
                    <div class="recent-transaction">
                        <div>
                            <p>Account Name</p>
                            <p>Saturday, 12 December 2024 11:00 PM</p>
                        </div>
                        <div>
                            <p class="credit">-Ksh. 300</p>
                        </div>
                    </div>
                </section>
            </div>
        </section>
        <div class="customization-buttons">
            <button title="Account Settings" onclick="manageAccount()"><img src="./assets/icons/Settings-icon.png" alt="settings icon"/><span>Account Settings</span></button>
            <button title="Account Automations" onclick="configureAutomations()"><img src="./assets/icons/Automation-icon.png" alt="share icon"/><span>Account Automations</span></button>
        </div>
    </main>
    
    <section class="popup" id="account-settings-popup">
        <div >
            <div>
                <div class="popup-close">
                    <span onclick="manageAccount(false)" title="Close">&times;</span>
                </div>
            </div>
            <div>
                <form class="automation-form" onsubmit="handleAccountEdit(event)">
                    <div class="automation-title">
                        <img src="./assets/icons/Settings-icon.png" class="Settings icon" />
                        <span>Account Settings</span>
                    </div>
                    <div class="account-name">
                        <span>Visibility</span>
                        <div class="choosing-frequency">
                            <button class="active">Public</button>
                            <button>Private</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="popup" id="automations-popup">
        <div>
            <div>
                <div class="popup-close">
                    <span onclick="configureAutomations(false)" title="Close">&times;</span>
                </div>
            </div>
            <div>
                <div class="account-automations">
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        <div class="swiper-slide automations-list">
                            <p>Current Account Automations</p>
                            <div class="underline"></div>
                            <table>
                                <thead></thead>
                                <tbody id="list-of-account-automations">
                                    <tr>
                                        <td>1.</td>
                                        <td>Automation number</td>
                                        <td title="Manage Automation"><button onclick="manageAutomation(0)"><img src="./assets/icons/Edit-icon.png" /></button></td>
                                        <td title="Suspend Automation"><button><img src="./assets/icons/Suspend-icon.png" /></button></td>
                                        <td title="Delete Automation"><button><img src="./assets/icons/Delete-icon.png" /></button></td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Automation number</td>
                                        <td title="Manage Automation"><button onclick="manageAutomation(1)"><img src="./assets/icons/Edit-icon.png" /></button></td>
                                        <td title="Suspend Automation"><button><img src="./assets/icons/Suspend-icon.png" /></button></td>
                                        <td title="Delete Automation"><button><img src="./assets/icons/Delete-icon.png" /></button></td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Automation number</td>
                                        <td title="Manage Automation"><button onclick="manageAutomation(3)"><img src="./assets/icons/Edit-icon.png" /></button></td>
                                        <td title="Suspend Automation"><button><img src="./assets/icons/Suspend-icon.png" /></button></td>
                                        <td title="Delete Automation"><button><img src="./assets/icons/Delete-icon.png" /></button></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="add-automations-button" onclick="manageAutomation()"><img src="./assets/icons/add-icon.png" /> Add automation</button>
                        </div>
                        <div class="swiper-slide">
                            <form id="automation-form" class="automation-form" onsubmit="manageAccountAutomation(event)">
                                <div class="automation-title-container">
                                    <span class="back-button" onclick="manageAutomation(false)">Back</span>
                                    <div class="automation-title">
                                        <img src="./assets/icons/Automation-icon.png" class="Automation icon" />
                                        <span>Automate Transactions</span>
                                    </div>
                                </div>
                                <div class="account-name">
                                    <span>Automation Name</span>
                                    <div>
                                        <input id="automation-name" onchange="handleAutomationNameChange(event)" type="text" placeholder="Rent Savings Automation"/>
                                        <span class="error" id="automation-name-error"></span>
                                    </div>
                                </div>
                                <div class="account-name">
                                    <span>Transaction Type</span>
                                    <div>
                                        <select id="automation-type" onchange="handleTransactionTypeChange(event)">
                                            <option value="deposit">Automated Deposit</option>
                                            <!-- <option>Automated Payment</option> -->
                                        </select>
                                        <span class="error" id="transaction-type-error"></span>
                                    </div>
                                </div>
                                <div class="account-name">
                                    <span>Payment Method</span>
                                    <div class="choosing-frequency">
                                        <button onclick="choosePaymentMethod(event, 'mpesa')" class="payment-method-button active">Mpesa</button>
                                        <!-- <button onclick="choosePaymentMethod(event, 'visa')" class="payment-method-button">VISA | Coming Soon</button> -->
                                        <button class="payment-method-button" onclick="event.preventDefault()">VISA | Coming Soon</button>
                                    </div>
                                </div>
                                <div class="payment-method-container">
                                    <div class="payment-method">
                                        <div class="swiper-wrapper">
                                            <!-- Slides -->
                                            <div class="swiper-slide">
                                                <div class="account-name">
                                                    <span>Phone Number</span>
                                                    <div>
                                                        <input id="international-phone-number" onchange="handlePhoneNumberChange(event)" type="text" placeholder="eg. 254700000000"/>
                                                        <span class="error" id="phone-number-error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <p style="text-align: center;">VISA | Coming Soon</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="account-name">
                                    <span>Target Amount</span>
                                    <div>
                                        <input id="target-amount" onchange="handleTargetAmount(event)" type="text" placeholder="Target Amount"/>
                                        <span class="error" id="target-amount-error"></span>
                                    </div>
                                </div>
                                <div class="account-name">
                                    <span>Regular Deposit Amount</span>
                                    <div>
                                        <input id="regular-deposit-amount" onchange="handleRegularDepositAmount(event)" type="text" placeholder="Regular Deposit Amount"/>
                                        <span class="error" id="regular-deposit-amount-error"></span>
                                    </div>
                                </div>
                                <div class="account-name">
                                    <span>Time of the day</span>
                                    <div>
                                        <input id="time-of-the-day" onchange="handleTimeOfTheDay(event)" type="time" placeholder="Account Name" value="10:00"/>
                                        <span class="error" id="time-of-the-day-error"></span>
                                    </div>
                                </div>
                                <div class="account-name">
                                    <span>Frequency</span>
                                    <div class="choosing-frequency">
                                        <button onclick="chooseFrequency(event, 'weekly')" class="frequency-button active">Weekly</button>
                                        <button onclick="chooseFrequency(event, 'monthly')" class="frequency-button">Monthly</button>
                                    </div>
                                </div>
                                <div class="frequency-container">
                                    <div class="frequency">
                                        <div class="swiper-wrapper">
                                            <!-- Slides -->
                                            <div class="swiper-slide">
                                                <div class="day-of-the-week">
                                                    <ul>
                                                        <li><input class="dayOfTheWeek" onclick="handleDayOfTheWeekChange(event, 1)" type="checkbox" id="sunday"/><label for="sunday">Sunday</label></li>
                                                        <li><input class="dayOfTheWeek" onclick="handleDayOfTheWeekChange(event, 2)"type="checkbox" id="monday"/><label for="monday">Monday</label></li>
                                                        <li><input class="dayOfTheWeek" onclick="handleDayOfTheWeekChange(event, 3)"type="checkbox" id="tuesday"/><label for="tuesday">Tuesday</label></li>
                                                        <li><input class="dayOfTheWeek" onclick="handleDayOfTheWeekChange(event, 4)"type="checkbox" id="wednesday"/><label for="wednesday">Wednesday</label></li>
                                                        <li><input class="dayOfTheWeek" onclick="handleDayOfTheWeekChange(event, 5)"type="checkbox" id="thursday"/><label for="thursday">Thursday</label></li>
                                                        <li><input class="dayOfTheWeek" onclick="handleDayOfTheWeekChange(event, 6)"type="checkbox" id="friday"/><label for="friday">Friday</label></li>
                                                        <li><input class="dayOfTheWeek" onclick="handleDayOfTheWeekChange(event, 7)"type="checkbox" id="saturday"/><label for="saturday">Saturday</label></li>
                                                    </ul>
                                                 </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="dates-of-the-month">
                                                    <table onclick="handleDateClick(event)">
                                                        <thead></thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="date-of-the-month">1</td>
                                                                <td class="date-of-the-month">2</td>
                                                                <td class="date-of-the-month">3</td>
                                                                <td class="date-of-the-month">4</td>
                                                                <td class="date-of-the-month">5</td>
                                                                <td class="date-of-the-month">6</td>
                                                                <td class="date-of-the-month">7</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="date-of-the-month">8</td>
                                                                <td class="date-of-the-month">9</td>
                                                                <td class="date-of-the-month">10</td>
                                                                <td class="date-of-the-month">11</td>
                                                                <td class="date-of-the-month">12</td>
                                                                <td class="date-of-the-month">13</td>
                                                                <td class="date-of-the-month">14</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="date-of-the-month">15</td>
                                                                <td class="date-of-the-month">16</td>
                                                                <td class="date-of-the-month">17</td>
                                                                <td class="date-of-the-month">18</td>
                                                                <td class="date-of-the-month">19</td>
                                                                <td class="date-of-the-month">20</td>
                                                                <td class="date-of-the-month">21</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="date-of-the-month">22</td>
                                                                <td class="date-of-the-month">23</td>
                                                                <td class="date-of-the-month">24</td>
                                                                <td class="date-of-the-month">25</td>
                                                                <td class="date-of-the-month">26</td>
                                                                <td class="date-of-the-month">27</td>
                                                                <td class="date-of-the-month">28</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="error" id="frequency-error"></span>
                                </div>
                                
                                <button class="automate-button" onclick="manageAccountAutomation(event)">
                                    <img src="./assets/icons/white-automation-icon.png" alt="White automation icon" />
                                    <span>Automate</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript" src = "./scripts/swiper/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="./scripts/swiper/initialize-swiper.js"></script>
    <script type="text/javascript" src="./scripts/account-automations.js"></script>
    <script type="text/javascript" src="./scripts/account-settings.js"></script>
</body>
</html>