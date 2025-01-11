<?php
    require './db.php';
    require './db-operations.php';
    require './upload.php';

    /**
     * Check if user is authenticated
     */

     if($_SERVER["REQUEST_METHOD"] == "POST"){
        $automationName = $_POST["automation-name"];
        $transactionType = $_POST["transaction-type"];
        $paymentMethod = $_POST["payment-method"];
        $mpesaPhoneNumber = $_POST["mpesa-phone-number"];
        $regularDepositAmount = $_POST["regular-deposit-amount"];
        $targetAmount = $_POST["target-amount"];
        $timeOfTheDay = $_POST["time-of-the-day"];
        $repetitionFrequency = $_POST["repetition-frequency"];
        
        $daysOfTheWeek = $_POST["days-of-the-week"];
        $daysOfTheWeek = json_decode($daysOfTheWeek);

        $datesOfTheMonth = $_POST["dates-of-the-month"];
        $datesOfTheMonth = json_decode($datesOfTheMonth);

        $userId = "1";

        /**
         * update account
         */
        if(isset($_POST["id"])){
            $automationId = $_POST["id"];

            /**
             * Update automation
             */
            $sql = "UPDATE automations SET name='$automationName', payment_method_id='$paymentMethod', mpesa_phone_number='$mpesaPhoneNumber' , target_amount='$targetAmount', regular_deposit_amount='$regularDepositAmount', time_of_the_day='$timeOfTheDay' , user_id='$productDescription' WHERE id=$automationId";
            update($host, $user, $password, $database, $sql);

            //Delete all existing automations (daily and monthly)
            /**
             * Get all related daily automations
             */
            $sql = "SELECT * FROM daily_automations WHERE deleted='0' AND automation_id='$automationId'";
            $dailyAutomations = find($host, $user, $password, $database, $sql);
            foreach ($dailyAutomations as $index => $dailyAutomation) {
                # code...
                $dailyAutomationId = $dailyAutomation["id"];
                $sql = "UPDATE daily_automations SET deleted='1' WHERE id=$dailyAutomationId";
                update($host, $user, $password, $database, $sql);
            }

            /**
             * Get all related monthly automations
             */
            $sql = "SELECT * FROM mothly_automations WHERE deleted='0' AND automation_id='$automationId'";
            $monthlyAutomations = find($host, $user, $password, $database, $sql);
            foreach ($monthlyAutomations as $index => $monthlyAutomation) {
                # code...
                $monthlyAutomationId = $monthlyAutomation["id"];
                $sql = "UPDATE mothly_automations SET deleted='1' WHERE id=$monthlyAutomationId";
                update($host, $user, $password, $database, $sql);
            }

            /**
             * Create daily automations
             */
            foreach ($daysOfTheWeek as $index => $dayOfTheWeek) {
                # code...
                $sql = "INSERT INTO daily_automations(`day_id`, `automation_id`) VALUES('$dayOfTheWeek', '$automationId')";
                $dailyAutomationId = create($host, $user, $password, $database, $sql);
            }
            
            /**
             * Create monthly automations
             */
            foreach ($datesOfTheMonth as $index => $dateOfTheMonth) {
                # code...
                $sql = "INSERT INTO monthly_automations(`date`, `automation_id`) VALUES('$dateOfTheMonth', '$automationId')";
                $monthlyAutomationId = create($host, $user, $password, $database, $sql);
            }

            $userAutomations = json_encode(getUserAutomations($host, $user, $password, $database, $userId));
            echo $userAutomations;
        }

        if(isset($_POST["deleted"])){
            $automationId = $_POST["deleted"];

            $sql = "UPDATE automations SET deleted='1' WHERE id=$automationId";
            update($host, $user, $password, $database, $sql);

            $userAutomations = getUserAutomations($host, $user, $password, $database, $userId);
            echo json_encode($userAccounts);
            die();
        }
       /**
         * Create the account;
         */

        /**
         * Generate a new token for each account
         */
        // Generate unique ID
        
        $account_uuid = generateUniqueId();

        while(isAccountUuidAvailable($host, $user, $password, $database, $account_uuid)){
            $account_uuid = generateUniqueId();
        }

        /**
         * Create and automation
         */
        $sql = "INSERT INTO automations(`name`, `payment_method_id`, `mpesa_phone_number`, `target_amount`, `regular_deposit_amount`, `time_of_the_day`, `user_id`) VALUES('$automationName', '$paymentMethod', '$mpesaPhoneNumber', '$targetAmount', '$regularDepositAmount', '$timeOfTheDay', '$user_id')";
        $automationId = create($host, $user, $password, $database, $sql);

        /**
         * Create daily automations
         */
        foreach ($daysOfTheWeek as $index => $dayOfTheWeek) {
            # code...
            $sql = "INSERT INTO daily_automations(`day_id`, `automation_id`) VALUES('$dayOfTheWeek', '$automationId')";
            $dailyAutomationId = create($host, $user, $password, $database, $sql);
        }
        
        /**
         * Create monthly automations
         */
        foreach ($datesOfTheMonth as $index => $dateOfTheMonth) {
            # code...
            $sql = "INSERT INTO monthly_automations(`date`, `automation_id`) VALUES('$dateOfTheMonth', '$automationId')";
            $monthlyAutomationId = create($host, $user, $password, $database, $sql);
        }

        $userAutomations = json_encode(getUserAutomations($host, $user, $password, $database, $userId));
        echo $userAutomations;

    } else if($_SERVER["REQUEST_METHOD"] == "GET"){

        $userId = 1;
        $userAccounts = json_encode(getUserAutomations($host, $user, $password, $database, $userId));
        echo $userAccounts;
    }

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
            $sql = "SELECT * FROM mothly_automations WHERE deleted='0' AND automation_id='$automationId'";
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
?>