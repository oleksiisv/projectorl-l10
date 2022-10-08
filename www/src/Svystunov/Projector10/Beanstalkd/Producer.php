<?php
declare(strict_types=1);

namespace Svystunov\Projector10\Beanstalkd;

use Faker\Factory;
use Faker\Generator;
use Pheanstalk\Pheanstalk;

class Producer
{
    public function execute($connector)
    {
        $beanstalkd = $this->connect($connector);
        $beanstalkd->useTube('projectorL10');
        return $beanstalkd->put(json_encode($this->createSampleUser()));
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

    /**
     * @return array
     */
    private function createSampleUser()
    {
        /** @var Generator $faker */
        $faker = Factory::create();

        return [
            'first_name' => $faker->firstname(),
            'last_name' => $faker->lastname(),
            'email' => $faker->email(),
            'address' => $faker->address(),
            'dob' => $faker->date('Y-m-d'),
        ];
    }
}