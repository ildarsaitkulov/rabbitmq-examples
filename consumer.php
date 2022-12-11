<?php

$connection = new AMQPConnection([
    'host' => 'test-rabbitmq',
    'port' => 5672,
    'login' => 'guest',
    'password' => 'guest'
]);

$connection->connect();

$channel = new \AMQPChannel($connection);
$smsQueue = new \AMQPQueue($channel);
$smsQueue->setName('Sms queue');

echo "reading form queue: Sms queue...<br>";
$envelope = $smsQueue->get();

if ($envelope === false) {
    return;
}
var_dump($envelope->getBody());
$smsQueue->ack($envelope->getDeliveryTag());
