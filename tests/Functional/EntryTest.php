<?php

namespace Search\Tests\Functional;

class EntryTest extends BaseTestCase
{
    /**
     * Test that the index route returns a rendered response containing the text 'SlimFramework' but not a greeting
     */
    public function testGetEntryWithoutName()
    {
        $response = $this->runApp( 'GET', '/search?query=bible');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('{"_links":{"self":{"href":null},"pageSearch":{"href":null},"objectSearch":{"href":null}}}', (string)$response->getBody());
        $this->assertEmpty($response->getHeader("Access-Control-Allow-Origin"));
    }

    /**
     * Test that there is a CORS Header when HTTP_ORIGIN is set 
     */
    public function testCorsHeader()
    {
        $response = $this->runApp( 'GET', '/', [], ['HTTP_ORIGIN'=> 'test.com']);
        $this->assertNotEmpty($response->getHeader("Access-Control-Allow-Origin"));
    }

    /**
     * Test searching
     */
    public function testSearching()
    {
        $searchResult = new \Search\Entities\SearchResult;
        $stub->method('runSearch')->willReturn($searchResult);
        $response = $this->runApp( 'GET', '/search?query=test');

    }

    /**
     * Test that the index route won't accept a post request
     */
    public function testPostHomepageNotAllowed()
    {
        $response = $this->runApp('POST', '/', ['test']);
        $this->assertEquals(405, $response->getStatusCode());
        $this->assertContains('Method not allowed', (string)$response->getBody());
    }
}
