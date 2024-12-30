<?php
    require './db.php';
    require './db-operations.php';
    require './upload.php';

    /**
     * Check if user is authenticated
     */

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $accountName = $_POST["account-name"];
        $userId = "1";

        /**
         * update account
         */
        if(isset($_POST["id"])){
            $accountId = $_POST["id"];

            $userAccounts = getUserAccounts($host, $user, $password, $database, $userId);
            foreach ($userAccounts as $index => $userAccount) {
                # code...
                if($userAccount["id"] == $accountId){
                    $sql = "UPDATE accounts SET name='$accountName' WHERE id=$accountId";
                    update($host, $user, $password, $database, $sql);

                    $userAccounts = getUserAccounts($host, $user, $password, $database, $userId);
                    echo json_encode($userAccounts);
                    die();
                }
            }
        }

        if(isset($_POST["deleted"])){
            $accountId = $_POST["deleted"];

            $userAccounts = getUserAccounts($host, $user, $password, $database, $userId);
            foreach ($userAccounts as $index => $userAccount) {
                # code...
                if($userAccount["id"] == $accountId){
                    $sql = "UPDATE accounts SET deleted='1' WHERE id=$accountId";
                    update($host, $user, $password, $database, $sql);

                    $userAccounts = getUserAccounts($host, $user, $password, $database, $userId);
                    echo json_encode($userAccounts);
                    die();
                }
            }
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

        $sql = "INSERT INTO accounts(`name`, `user_id`, `account_uuid`) VALUES('$accountName', '$userId', '$account_uuid')";
        $accountId = create($host, $user, $password, $database, $sql);

        $userAccounts = json_encode(getUserAccounts($host, $user, $password, $database, $userId));
        echo $userAccounts;

    } else if($_SERVER["REQUEST_METHOD"] == "GET"){

        $userId = 1;
        $userAccounts = json_encode(getUserAccounts($host, $user, $password, $database, $userId));
        echo $userAccounts;
    }

    function getUserAccounts($host, $user, $password, $database, $userId){
        /**
         * Get all the products
         */
        $sql = "SELECT * FROM accounts WHERE deleted='0' AND user_id='$userId'";
        $accounts = find($host, $user, $password, $database, $sql);

        $newArray = [];

        foreach ($accounts as $index => $account) {
            # code...
            unset($account["deleted"]);
            $newArray[] = $account;
        }

        $accounts = $newArray;
        return $accounts;
    }

    function isAccountUuidAvailable ($host, $user, $password, $database, $account_uuid){

        /**
         * Get all the products
         */
        $sql = "SELECT * FROM accounts WHERE deleted='0' AND account_uuid='$account_uuid'";
        $accounts = find($host, $user, $password, $database, $sql);

        $newArray = [];

        foreach ($accounts as $index => $account) {
            # code...
            $newArray[] = $account;
        }

        $accounts = $newArray;
        if(count($accounts) > 0){
            return true;
        }

        return false;
    }
    // Function to generate a unique ID
    function generateUniqueId($length = 32) {
        // Use uniqid and random_bytes for better uniqueness
        $uniqueId = uniqid() . bin2hex(random_bytes($length / 2));
        return substr($uniqueId, 0, $length); // Trim to desired length
    }
?>