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
        if(isset($_POST["account-id"])){
            $accountId = $_POST["account-id"];

            $userAccounts = getUserAccounts($userId);
            foreach ($userAccounts as $index => $userAccount) {
                # code...
                if($userAccount["id"] == $accountId){
                    $sql = "UPDATE accounts SET name='$accountName' WHERE id=$accountId";
                    update($host, $user, $password, $database, $sql);

                    $userAccounts = getUserAccounts($userId);
                    return json_encode($userAccounts);
                    die();
                }
            }
        }

        if(isset($_POST["deleted"])){
            $accountId = $_POST["deleted"];

            $userAccounts = getUserAccounts($userId);
            foreach ($userAccounts as $index => $userAccount) {
                # code...
                if($userAccount["id"] == $accountId){
                    $sql = "UPDATE accounts SET deleted='1' WHERE id=$accountId";
                    update($host, $user, $password, $database, $sql);

                    $userAccounts = getUserAccounts($userId);
                    return json_encode($userAccounts);
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
        $accountUUID = "ab12afdkal;8789sadjh8897jhasf";
        $sql = "INSERT INTO accounts(`name`, `user_id`, `uuid`) VALUES('$accountName', '$userId')";
        $accountId = create($host, $user, $password, $database, $sql);

        $userAccounts = getUserAccounts($userId);
        return json_encode($userAccounts);
    }

    function getUserAccounts($userId){
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
        return json_encode($accounts);
    }
?>