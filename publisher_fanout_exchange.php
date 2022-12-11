<?php

$connection = new AMQPConnection([
    'host' => 'localhost',
    'port' => 5672,
    'login' => 'guest',
    'password' => 'guest'
]);

$connection->connect();

$channel = new \AMQPChannel($connection);
$directExchange = new \AMQPExchange($channel);
$exchangeName = 'test_fanout_exchange';
$directExchange->setName($exchangeName);
$directExchange->setType(AMQP_EX_TYPE_FANOUT);
$directExchange->declareExchange();


$smsQueue = new \AMQPQueue($channel);
$smsQueue->setName('Sms queue');
$smsQueue->setFlags(AMQP_DURABLE);
$smsQueue->declareQueue();
$smsQueue->bind($exchangeName);

$emailQueue = new \AMQPQueue($channel);
$emailQueue->setName('Email queue');
$emailQueue->setFlags(AMQP_DURABLE);
$emailQueue->declareQueue();
$emailQueue->bind($exchangeName);

$directExchange->publish('foobar');



