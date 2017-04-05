<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HelpersTest extends TestCase
{
    /**
     * Check on 200 function returns true
     */
    public function test_checkHTTPCallSuccessful_TrueResponse()
    {
        $this->assertTrue(checkHTTPCallSucessful(200));
    }

    /**
     * Test getting JSON via localhost
     */
    public function test_getJSON_Success()
    {
        $responseJSON = getJSON(env('TEST_JSON_URL',config('gb.Website_Address')));
        $this->assertEquals($responseJSON->results[0]->id,11408);
    }

    /**
     * Test bad characters get removed from stribg
     */
    public function test_removeSpecialCharactersFromString()
    {
        $badString = "A/:34xwFR!dec&";
        $niceString = "A34xwFRdec";

        $this->assertEquals($niceString, removeSpecialCharactersFromString($badString));
    }

    /**
     * Test bytes to Human Conversion works as expected
     */
    public function test_human_filesize()
    {
        $this->assertEquals("4.16GB", human_filesize(4466431481));
    }
}
