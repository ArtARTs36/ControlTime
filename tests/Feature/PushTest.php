<?php

namespace Tests\Feature;

use App\Events\PushCreated;
use Tests\TestCase;

class PushTest extends TestCase
{
    public function testStore()
    {
        $this->expectsEvents(PushCreated::class);

        $data = [
            'title' => 'Важный разговор',
            'message' => 'Привет, как дела?',
        ];

        $response = $this->postJson('/api/pushes', $data)
            ->assertOk()
            ->decodeResponseJson();

        self::assertIsArray($response);
        self::assertNotEmpty($response);
        self::assertArrayHasKey('success', $response);
        self::assertTrue($response['success']);
    }
}
