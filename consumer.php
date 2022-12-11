<?php

$connection = new AMQPConnection([
    'host' => 'localhost',
    'port' => 5672,
    'login' => 'guest',
    'password' => 'guest'
]);

$connection->connect();

$channel = new \AMQPChannel($connection);
$smsQueue = new \AMQPQueue($channel);
$smsQueue->setName('Sms queue');

$smsQueue->consume(function (\AMQPEnvelope $envelope, \AMQPQueue $queue) {
    var_dump($envelope->getBody());
    $queue->ack($envelope->getDeliveryTag());
});