<?php
    require './db.php';
    require './db-operations.php';
    require './upload.php';

    /**
     * Check if user is authenticated
     */

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $userId = 1;

        if(isset($_POST["deleted"])){
            $automationId = $_POST["deleted"];

            /**
             * Check if account balance is zero
             */

            $sql = "UPDATE automations SET deleted='1' WHERE id=$automationId";
            update($host, $user, $password, $database, $sql);

            $userAutomations = getUserAutomations($host, $user, $password, $database, $userId);
            $accountAutomations = json_encode(getAccountAutomations($userAutomations, $accountUuid));
            echo $accountAutomations;
            die();
        }

        $automationName = $_POST["automation-name"];
        $transactionType = $_POST["transaction-type"];

        if($transactionType == "deposit"){
            $transactionType = 1;
        } else if($transactionType == "payment"){
            $transactionType =2;
        }

        $paymentMethod = $_POST["payment-method"];
        $mpesaPhoneNumber = $_POST["mpesa-phone-number"];
        $regularDepositAmount = $_POST["regular-deposit-amount"];
        $targetAmount = $_POST["target-amount"];
        $timeOfTheDay = $_POST["time-of-the-day"];
        $repetitionFrequency = $_POST["repetition-frequency"];
        $accountUuid = $_POST["account-uuid"];
        
        $daysOfTheWeek = $_POST["days-of-the-week"];
        $daysOfTheWeek = json_decode($daysOfTheWeek);

        $datesOfTheMonth = $_POST["dates-of-the-month"];
        $datesOfTheMonth = json_decode($datesOfTheMonth);

        /**
         * update account
         */
        if(isset($_POST["id"])){
            $automationId = $_POST["id"];
            //var_dump($userId);

            /**
             * Check if the automation user id matches the current user id
             */

            /**
             * Update automation
             */
            //$sql = "UPDATE automations SET name='$automationName', payment_method_id='$paymentMethod', automation_type_id='$transactionType', mpesa_phone_number='$mpesaPhoneNumber' , target_amount='$targetAmount', regular_deposit_amount='$regularDepositAmount', time_of_the_day='$timeOfTheDay' , user_id='$$userId' WHERE id=$automationId";
            $sql = "UPDATE automations SET name='$automationName', automation_type_id='$transactionType', mpesa_phone_number='$mpesaPhoneNumber' , target_amount='$targetAmount', regular_deposit_amount='$regularDepositAmount', time_of_the_day='$timeOfTheDay', user_id='$userId', account_uuid = '$accountUuid' WHERE id=$automationId";
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
            $sql = "SELECT * FROM monthly_automations WHERE deleted='0' AND automation_id='$automationId'";
            $monthlyAutomations = find($host, $user, $password, $database, $sql);
            foreach ($monthlyAutomations as $index => $monthlyAutomation) {
                # code...
                $monthlyAutomationId = $monthlyAutomation["id"];
                $sql = "UPDATE monthly_automations SET deleted='1' WHERE id=$monthlyAutomationId";
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
            
            $userAutomations = getUserAutomations($host, $user, $password, $database, $userId);
            $accountAutomations = json_encode(getAccountAutomations($userAutomations, $accountUuid));
            echo $accountAutomations;
            die();
        }
    
        /**
         * Create and automation
         */
        $sql = "INSERT INTO automations(`name`, `automation_type_id`, `payment_method_id`, `mpesa_phone_number`, `target_amount`, `regular_deposit_amount`, `time_of_the_day`, `user_id`, `account_uuid`) VALUES('$automationName', '$transactionType', '$paymentMethod', '$mpesaPhoneNumber', '$targetAmount', '$regularDepositAmount', '$timeOfTheDay', '$userId', '$accountUuid')";
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
        $accountUuid = $_GET["id"];
        $userAutomations = getUserAutomations($host, $user, $password, $database, $userId);
        $accountAutomations = json_encode(getAccountAutomations($userAutomations, $accountUuid));
        echo $accountAutomations;
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
?>