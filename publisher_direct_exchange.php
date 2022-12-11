<?php

$connection = new AMQPConnection([
    'host' => 'test-rabbitmq',
    'port' => 5672,
    'login' => 'guest',
    'password' => 'guest'
]);

$connection->connect();

$channel = new \AMQPChannel($connection);
$directExchange = new \AMQPExchange($channel);
$exchangeName = 'test_direct_exchange';
$directExchange->setName($exchangeName);
$directExchange->setType(AMQP_EX_TYPE_DIRECT);
$directExchange->declareExchange();


$smsQueue = new \AMQPQueue($channel);
$smsQueue->setName('Sms queue');
$smsQueue->setFlags(AMQP_DURABLE);
$smsQueue->declareQueue();
$smsQueue->bind($exchangeName, 'sms');

$emailQueue = new \AMQPQueue($channel);
$emailQueue->setName('Email queue');
$emailQueue->setFlags(AMQP_DURABLE);
$emailQueue->declareQueue();
$emailQueue->bind($exchangeName, 'email');

$directExchange->publish('foobar', 'sms');
$directExchange->publish('foobar', 'email');



