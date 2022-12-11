<?php

$connection = new AMQPConnection([
    'host' => 'test-rabbitmq',
    'port' => 5672,
    'login' => 'guest',
    'password' => 'guest'
]);

$connection->connect();

$channel = new \AMQPChannel($connection);
$fanoutExchange = new \AMQPExchange($channel);
$exchangeName = 'test_fanout_exchange';
$fanoutExchange->setName($exchangeName);
$fanoutExchange->setType(AMQP_EX_TYPE_FANOUT);
$fanoutExchange->declareExchange();


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

echo "publish to fanout exchange message: foobar\n";
$fanoutExchange->publish('foobar');



