<?php

namespace Tests\Unit;

use Tests\TestCase;

class HelpersTest extends TestCase
{
    /**
     * Test getting human fileize returns as expected
     *
     * @return void
     */
    public function test_human_filesize()
    {
        $this->assertEquals(
            '0.93GB',
            humanFilesize(1000000000)
        );
    }

    /**
     * Test special characters get removed from string
     *
     * @return void
     */
    public function test_removeSpecialCharactersFromString()
    {
        $this->assertEquals(
            'asd4gvrfrfeg',
            removeSpecialCharactersFromString('/a:s!d&4(g)v\'r,f\r-f?e.g')
        );
    }

    /**
     * Test the name we provide is good for local disk use
     *
     * @return void
     */
    public function test_localFilename()
    {
        $this->assertEquals(
            'oregon_trail_deluxe',
            localFilename('Oregon Trail Deluxe')
        );
    }

    /**
     * Test making a http get and json is decoded
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function test_getJSON()
    {
        $request = getJSON('https://jsonplaceholder.typicode.com/posts/1');

        $this->assertEquals(
            1,
            $request["id"]
        );
    }

    /**
     * Test checking http response code works
     *
     * @return void
     */
    public function test_checkHTTPCallSuccessful()
    {
        $this->assertTrue(checkHTTPCallSuccessful(200));
        $this->assertFalse(checkHTTPCallSuccessful(400));
    }

    /**
     * Test I get Service Id back from a name
     *
     * @return void
     */
    public function test_returnServiceId()
    {
        $this->assertEquals(
            1,
            returnServiceId("Giantbomb")
        );
    }
}
