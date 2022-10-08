<?php
declare(strict_types=1);

namespace Svystunov\Projector10\Redis;

use Redis;

class Consumer
{
    public function execute($connector)
    {
        $redis = $this->connect($connector);
        $i = 0;
        $start = microtime(true);
        $recordsRead = 0;
        while(true){
            $result = $redis->lPop('ProjectorL10' );
            if($result){
                $recordsRead++;
            }
            print_r($result . "\n");
            $i++;
            if($i === 2500){
                break;
            }
        }
        $delta = microtime(true) - $start;
        file_put_contents(
            $connector . '.log',
            sprintf("Records read: %s, Estimated time: %s ", $recordsRead, $delta)
        );
    }

    /**
     * @return Redis
     */
    private function connect($connector)
    {
        $redis = new Redis();
        $redis->connect($connector, 6379);
        $redis->auth(['password']);

        return $redis;
    }
}