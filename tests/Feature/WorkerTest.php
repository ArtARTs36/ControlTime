<?php

namespace Tests\Feature;

use App\Models\Worker;
use Tests\TestCase;

class WorkerTest extends TestCase
{
    public function testGetAll(): void
    {
        $response = $this->getJson('/api/workers')
            ->assertOk()
            ->decodeResponseJson();

        self::assertArrayHasKey('data', $response);
        self::assertNotEmpty($response['data']);
    }

    public function testGetWorker(): void
    {
        /** @var Worker $exceptedWorker */
        $exceptedWorker = $this->getRandomModel(Worker::class);

        $response = $this->getJson('/api/workers/' . $exceptedWorker->id)
            ->assertOk()
            ->decodeResponseJson();

        self::assertTrue($response == $exceptedWorker->toArray());
    }
}
