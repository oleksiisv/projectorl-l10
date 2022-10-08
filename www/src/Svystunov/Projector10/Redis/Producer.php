<?php
declare(strict_types=1);

namespace Svystunov\Projector10\Redis;

use Faker\Factory;
use Faker\Generator;
use Redis;

class Producer
{
    public function execute($connector)
    {
        return $this->connect($connector)->rPush('ProjectorL10', json_encode($this->createSampleUser()));
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