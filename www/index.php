<?php
require 'vendor/autoload.php';

use Svystunov\Projector10\Redis\Consumer as RedisConsumer;
use Svystunov\Projector10\Redis\Producer as RedisProducer;

use Svystunov\Projector10\Beanstalkd\Producer as BeanstalkdProducer;
use \Svystunov\Projector10\Beanstalkd\Consumer as BeanstalkdConsumer;

$connector = $_GET['connector'] ?? '';
$action = $_GET['action'] ?? '';

if($connector === '' OR $action === ''){
    echo 'Please define connector and action params. Example: http://localhost/index.php?connector=redis&action=write';
}

// Redis
if ($connector === 'redis-rdb' || $connector === 'redis-aof') {
    if($action === 'write'){
        $writer = new RedisProducer();
        echo $writer->execute($connector);
    }
    if ($action === 'read'){
        $reader = new RedisConsumer();
        $reader->execute($connector);
    }

}

//Beanstalkd
if ($connector === 'beanstalkd') {
    if($action === 'write'){
        $producer = new BeanstalkdProducer();
        print_r($producer->execute($connector));
    }
    if ($action === 'read'){
        $consumer = new BeanstalkdConsumer;
        $consumer->execute($connector);
    }
}

