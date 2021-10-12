<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;


class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicSearchText()
    {
        $response = $this->get('/');
        $this->withoutExceptionHandling();
        $response->assertSee('Search by language :', $escaped = true);
        $response->assertStatus(200);
    }

    public function testRepositoriesApi()
    {

        $client = new Client();
        $response = $client->get('https://api.github.com/search/repositories?q=created:%3E2019-01-10&sort=stars&order=desc&page=1&per_page=10');
        $result = $response->getBody()->getContents();
        $result  = json_decode($result,true);
        $this->assertEquals($result['incomplete_results'],true);
    }
    public function testAssertPerPage()
    {

        $client = new Client();
        $response = $client->get('https://api.github.com/search/repositories?q=created:%3E2019-01-10&sort=stars&order=desc&page=1&per_page=10');
        $result = $response->getBody()->getContents();
        $result  = json_decode($result,true);
        $this->assertEquals(count($result['items']),10);
    }
}
