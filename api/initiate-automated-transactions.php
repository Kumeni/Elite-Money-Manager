<?php

    require './db.php';
    require './db-operations.php';
    require './upload.php';
	require './mpesa-functions.php';

	$currentDateTime = getCurrentDateTime();
	writeToTextFile("api_log.txt", "$currentDateTime API called by cron_job");
    /**
     * Fetch all the daily automations
     * populate all the related automation details
     * automation, daily_automation_id
     */
    $newArray = [];
    $sql = "SELECT * FROM daily_automations WHERE deleted='0'";
    $dailyAutomations = find($host, $user, $password, $database, $sql);
    foreach ($dailyAutomations as $index => $dailyAutomation) {
        # code...
        unset($dailyAutomation["deleted"]);
		$automationId = $dailyAutomation["automation_id"];
		
		$sql = "SELECT * FROM automations WHERE id='$automationId'";
        $automations = find($host, $user, $password, $database, $sql);

		foreach ($automations as $index2 => $automation) {
			# code...
			$automation["daily_automation_id"] = $dailyAutomation["id"];
			$automation["day"] = $dailyAutomation["day_id"];
			$newArray[] = $automation;
		}
    }
	$dailyAutomations = $newArray;
	//echo json_encode($dailyAutomations);

    /**
     * Fetch all the monthly automations
     * populate all the related automation details
     * automation, monthly_automation_id
     */
	$newArray = [];
	$sql = "SELECT * FROM monthly_automations WHERE deleted='0'";
	$monthlyAutomations = find($host, $user, $password, $database, $sql);
	foreach ($monthlyAutomations as $index => $monthlyAutomation) {
		# code...
		unset($monthlyAutomation["deleted"]);
		$automationId = $monthlyAutomation["automation_id"];
		
		$sql = "SELECT * FROM automations WHERE id='$automationId'";
        $automations = find($host, $user, $password, $database, $sql);

		foreach ($automations as $index2 => $automation) {
			# code...
			$automation["monthly_automation_id"] = $monthlyAutomation["id"];
			$automation["date"] = $monthlyAutomation["date"];
			//$newArray[] = $monthlyAutomation;
			$newArray[] = $automation;
		}
	}
	$monthlyAutomations = $newArray;
	//echo json_encode($monthlyAutomations);

    /**
     * Get the current date and time
     */
	
	//echo json_encode($datetime);

    /**
     * Filter all the daily_automations and monthly automations those that match
     * whose date and time is greater than the current date and time.
     * 
     * Store them in activeDailyAutomations and activeMonthlyAutomations;
     */
	$newArray = [];

	foreach ($dailyAutomations as $index => $dailyAutomation) {
		# code...
		if(isPastAutomationActivationTime($dailyAutomation["time_of_the_day"]) == true){
		} else {
			//Skip the automation
		}

		if(isPastAutomationActivationDay($dailyAutomation["day"]) == true){
			//Activate automation
		} else {
			//Skip the automation
		}
	}
	$dailyAutomations = $newArray;

	foreach ($monthlyAutomations as $index => $monthlyAutomation) {
		# code...
		if(isPastAutomationActivationTime($monthlyAutomation["time_of_the_day"]) == true){
			if(automationCompleted($monthlyAutomation["id"]) == false){
				
				//Activate the automation;
				//initiateWeeklyAutomation($monthlyAutomation["automation_id"], $monthlyAutomation["id"]);
			}
		}

		if(isPastAutomationActivationDate($monthlyAutomation["date"]) == true){
			if(automationCompleted($monthlyAutomation["id"]) == false){
				//Activate the automation;
				//initiateMonthlyAutomation($monthlyAutomation["automation_id"], $monthlyAutomation["id"]);
			}
		}
	}

	function automationCompleted($automationId){
		//get the latest automation that matches it's id
		//Check if it's activated today
		//Check if the automation was completed.
		//Check if the automation was completed successfully
			//return true;

		//All others should return false;
		return false;
	}
	
	function initiateMonthlyAutomation($automationId, $monthlyAutomationId){
		$newArray = [];
		$sql = "SELECT * FROM automations WHERE id=$automationId";
		$automations = find($host, $user, $password, $database, $sql);
		foreach ($automations as $index => $automation) {
			# code...
			unset($dailyAutomation["deleted"]);
			$newArray[] = $automation;
		}
		$automations = $newArray;
		$automation = $automations[0];

		//Get the payment method
		if($automation["payment_method"] == 1){
			//Initiate stk push and store in the database;
			$phoneNumber = $automation["mpesa_phone_number"];
			$amount = $automation["regular_deposit_amount"];
			$transactionDesc = $automation["name"];

			$stkPushResponse = initiateSTKPush($phoneNumber, $amount, $transactionDesc);
			
			//Create an entry under mpesa_transactions
			$merchantRequestId = $stkPushResponse["MerchantRequestID"];
			$checkoutRequestId = $stkPushResponse["CheckoutResponseId"];
			$responseCode = $stkPushResponse["ResponseCode"];
			$responseDescription = $stkPushResponse["ResponseDescription"];

			$sql = "INSERT INTO mpesa_transactions(`stk_push_merchant_request_id`, `stk_push_checkout_request_id`, `stk_push_response_code`, `stk_push_response_description`) VALUES('$merchantRequestId', '$checkoutRequestId', '$responseCode', '$responseDescription')";
        	$mpesaTransactionId = create($host, $user, $password, $database, $sql);
			
			//Create an entry under initiatedautomations
			$sql = "INSERT INTO initiated_automations(`automation_id`, `monthly_automation_id`, `mpesa_transaction_id`) VALUES('$automationId', '$monthlyAutomationId', '$mpesaTransactionId')";
        	$initiatedAutomationId = create($host, $user, $password, $database, $sql);
		} else {
			//do nothing till we expand the business;
		}
	}

	function initiateWeeklyAutomation($automationId, $weeklyAutomationId){
		//Fetch the automation

		//Get the payment method

		//If mpesa, initiate the stk push

		//Create a record to show the transaction was initiated
	}

	function isPastAutomationActivationTime($activationTime){
		$datetime = getCurrentDateDetails();
		//$todaysDay = $datetime["day"];
		//$todaysDate = $datetime["date"];
		//$todaysTime = $datetime["time"];
		$todaysHour = $datetime["hour"];
		$todaysMinute = $datetime["minute"];
		$todaysSecond = $datetime["second"];

		//echo "Todays\n hour: $todaysHour\n minute: $todaysMinute\n second: $todaysSecond\n\n";

		//$activationTime = date($activationTime);
		$activationTime = new DateTime($activationTime);
		$activationHour = $activationTime->format("H");
		$activationMinute = $activationTime->format("i");
		$activationSecond = $activationTime->format("s");

		//echo "Activation\n hour: $activationHour\n minute: $activationMinute\n second: $activationSecond\n\n";
		
		// Compare the timestamps
		if ($todaysHour >= $activationHour && $todaysMinute >= $activationMinute && $todaysSecond >= $activationSecond) {
			echo "Automation time $activationHour:$activationMinute:$activationSecond todays time $todaysHour:$todaysMinute:$todaysSecond \n";
			return true;
		} else {
			return false;
		}
	}

	function isPastAutomationActivationDay($automationActivationDay){
		$datetime = getCurrentDateDetails();
		$todaysDay = $datetime["day"];
		//$todaysDate = $datetime["date"];
		//$todaysTime = $datetime["time"];

		// Convert the days to numerical representations (1 = Monday, 2 = Tuesday, ..., 7 = Sunday)
		//$todaysDayNum = date("N", strtotime($todaysDay));
		$automationActivationDay = (int)$automationActivationDay;
		$todaysDay = date("N", strtotime($todaysDay));

		// Compare the numerical values
		if ($todaysDay >= $automationActivationDay) {
			//echo "Automation day $automationActivationDay todays day $todaysDay \n";
			return true;
		} else {
			return false;
		}
	}
	
	function isPastAutomationActivationDate($automationActivationDate){
		$datetime = getCurrentDateDetails();
		//$todaysDay = $datetime["day"];
		//$todaysTime = $datetime["time"];
		$todaysDate = $datetime["date"];

		$todaysDate = (int)$todaysDate;
		$automationActivationDate = (int)$automationActivationDate;
	
		// Compare the days
		if ($todaysDate >=  $automationActivationDate) {
			//echo "Automation date $automationActivationDate todays date $todaysDate \n";
			return true;
		} else {
			return false;
		}
	}
	
	function getCurrentDateDetails() {
		// Get the current date and time
		//$currentDate = date("Y-m-d"); // Format: YYYY-MM-DD
		$currentDate = date("d"); // Format: YYYY-MM-DD
		$currentTime = date("H:i:s"); // Format: HH:MM:SS
		$currentDay = date("l"); // Day of the week (e.g., Monday, Tuesday)
		$currentHour = date("H");
		$currentMinute = date("i");
		$currentSecond = date("s");
	
		// Return the details in an associative array
		return [
			"day" => $currentDay,
			"date" => $currentDate,
			"time" => $currentTime,
			"hour" => $currentHour,
			"minute" => $currentMinute,
			"second" => $currentSecond,
		];
	}

	function writeToTextFile($filename, $content) {
		// Check if the file exists, create it if not
		if (!file_exists($filename)) {
			file_put_contents($filename, ""); // Create an empty file
		}
		
		// Open the file in append mode
		$file = fopen($filename, "a");
		if ($file) {
			fwrite($file, $content . PHP_EOL); // Write content with a newline
			fclose($file);
			return "Content written successfully.";
		} else {
			return "Error opening the file.";
		}
	}
	
	function getCurrentDateTime() {
		return date("Y-m-d H:i:s");
	}
?>