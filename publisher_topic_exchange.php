<?php

$connection = new AMQPConnection([
    'host' => 'test-rabbitmq',
    'port' => 5672,
    'login' => 'guest',
    'password' => 'guest'
]);

$connection->connect();

$channel = new \AMQPChannel($connection);
$topicExchange = new \AMQPExchange($channel);
$exchangeName = 'test_topic_exchange';
$topicExchange->setName($exchangeName);
$topicExchange->setType(AMQP_EX_TYPE_TOPIC);
$topicExchange->declareExchange();


$smsQueue = new \AMQPQueue($channel);
$smsQueue->setName('Sms queue');
$smsQueue->setFlags(AMQP_DURABLE);
$smsQueue->declareQueue();
$smsQueue->bind($exchangeName, 'message.sms');

$emailQueue = new \AMQPQueue($channel);
$emailQueue->setName('Email queue');
$emailQueue->setFlags(AMQP_DURABLE);
$emailQueue->declareQueue();
$emailQueue->bind($exchangeName, 'message.email');

$allMessagesQueue = new \AMQPQueue($channel);
$allMessagesQueue->setName('All messages queue');
$allMessagesQueue->setFlags(AMQP_DURABLE);
$allMessagesQueue->declareQueue();
$allMessagesQueue->bind($exchangeName, 'message.*');

$topicExchange->publish('foobar', 'message.sms');
$topicExchange->publish('foobar', 'message.email');



