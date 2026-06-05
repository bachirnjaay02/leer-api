<?php
require 'vendor/autoload.php';
$vapid = Minishlink\WebPush\VAPID::createVapidKeys();
echo 'PUBLIC: ' . $vapid['publicKey'] . PHP_EOL;
echo 'PRIVATE: ' . $vapid['privateKey'] . PHP_EOL;
