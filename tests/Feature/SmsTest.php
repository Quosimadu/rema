<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SmsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {


        $testData = [
            "msisdn" => "441632960960",
            "to" => "441632960961",
            "messageId" => "02000000E68951D8",
            "text" => "Hello7",
            "type" => "text",
            "keyword" => "HELLO7",
            "message-timestamp" => "2016-07-05 21:46:15"
        ];
        $response = $this->postJson('/receive-sms', $testData);

        $response->assertStatus(200);
    }
}
