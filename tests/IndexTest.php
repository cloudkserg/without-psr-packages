<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 06.02.18
 * Time: 2:26
 */

class IndexTest extends \PHPUnit\Framework\TestCase
{

    public function testIndex()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get('/?format=json');
        $this->assertEquals('200', $response->getStatusCode());

    }

}