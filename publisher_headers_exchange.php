<?php

$connection = new AMQPConnection([
    'host' => 'localhost',
    'port' => 5672,
    'login' => 'guest',
    'password' => 'guest'
]);

$connection->connect();

$channel = new \AMQPChannel($connection);
$headersExchange = new \AMQPExchange($channel);
$exchangeName = 'test_headers_exchange';
$headersExchange->setName($exchangeName);
$headersExchange->setType(AMQP_EX_TYPE_HEADERS);

$headersExchange->declareExchange();


$smsQueue = new \AMQPQueue($channel);
$smsQueue->setName('Sms queue');
$smsQueue->setFlags(AMQP_DURABLE);
$smsQueue->declareQueue();
$smsQueue->bind($exchangeName, null, [
    'x-match' => 'all',
    'type' => 'sms',
]);

$emailQueue = new \AMQPQueue($channel);
$emailQueue->setName('Email queue');
$emailQueue->setFlags(AMQP_DURABLE);
$emailQueue->declareQueue();
$emailQueue->bind($exchangeName, null, [
    'x-match' => 'all',
    'type' => 'email',
]);

$allMessagesQueue = new \AMQPQueue($channel);
$allMessagesQueue->setName('All messages queue');
$allMessagesQueue->setFlags(AMQP_DURABLE);
$allMessagesQueue->declareQueue();
$allMessagesQueue->bind($exchangeName, null, [
    'x-match' => 'any',
    'type' => 'email',
]);

$headersExchange->publish('foobar', null, AMQP_NOPARAM, ['headers' => ['type' => 'email']]);
$headersExchange->publish('foobar', null, AMQP_NOPARAM, ['headers' => ['type' => 'sms']]);




