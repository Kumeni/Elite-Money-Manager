<?php

    require './vendor/autoload.php';

    //$courier = new Courier\Courier;
    //$canadianCourier = new Courier\Courier(['body' => 'I <3 Vancouver'], ['region' => 'canada']);
    $internationalCourier = new Courier\Courier(['body' => 'I <3 Vancouver'], ['region' => 'intl']);
    $internationalCourier->setRegion('intl');
    //$courier->setRegion('intl');

    function sendSMS($courier){
        $courier->setRecipient('254717551542')->send();
    }

    sendSMS($internationalCourier);
?>