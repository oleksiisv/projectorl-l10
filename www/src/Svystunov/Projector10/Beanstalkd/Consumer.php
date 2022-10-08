<?php
declare(strict_types=1);

namespace Svystunov\Projector10\Beanstalkd;

use Pheanstalk\Pheanstalk;

class Consumer
{
    public function execute($connector)
    {
        $beanstalkd = $this->connect($connector);
        $beanstalkd->watch('projectorL10');
        $start = microtime(true);
        $recordsRead = 0;
        while ($job = $beanstalkd->reserveWithTimeout(0)) {
            try {
                $jobData = $job->getData();
                print_r($jobData . "\n");
                $recordsRead++;
                $beanstalkd->delete($job);
            } catch (\Exception $e) {
                $beanstalkd->bury($job);
            }
        }
        $delta = microtime(true) - $start;
        file_put_contents(
            'beanstalkd.log',
            sprintf("Records read: %s, Estimated time: %s ", $recordsRead, $delta)
        );
    }

    /**
     * @param $connector
     *
     * @return Pheanstalk
     */
    private function connect($connector)
    {
        return Pheanstalk::create($connector);
    }
}