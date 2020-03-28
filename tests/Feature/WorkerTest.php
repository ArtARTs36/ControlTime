<?php

namespace Tests\Feature;

use App\Models\Worker;
use Tests\TestCase;

class WorkerTest extends TestCase
{
    public function testGetAll(): void
    {
        $response = $this->getJson('/api/workers');
        $array = $this->decodeResponse($response);

        $response->assertOk();

        self::assertArrayHasKey('data', $array);
        self::assertNotEmpty($array['data']);
    }

    public function testGetWorker(): void
    {
        /** @var Worker $exceptedWorker */
        $exceptedWorker = $this->getRandomModel(Worker::class);

        $response = $this->getJson('/api/workers/' . $exceptedWorker->id);
        $array = $this->decodeResponse($response);

        $response->assertOk();

        self::assertTrue($array == $exceptedWorker->toArray());
    }
}
