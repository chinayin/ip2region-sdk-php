<?php

namespace lionsoul2014\Tests;

use lionsoul2014\Ip2Region;

class TestCase extends \PHPUnit\Framework\TestCase
{

    public function testBinarySearch()
    {
        $ip = '220.181.38.150';
        $ip2region = new Ip2Region;
        $s_time = $this->getTime();
        $data = $ip2region->binarySearch($ip);
        $c_time = $this->getTime() - $s_time;
        printf("%s ==> %s|%s in %.5f millseconds\n", $ip, $data['city_id'], $data['region'], $c_time);
        $this->assertNotEmpty($data);
    }

    public function testMemorySearch()
    {
        $ip = '220.181.38.150';
        $ip2region = new Ip2Region;
        $s_time = $this->getTime();
        $data = $ip2region->memorySearch($ip);
        $c_time = $this->getTime() - $s_time;
        printf("%s ==> %s|%s in %.5f millseconds\n", $ip, $data['city_id'], $data['region'], $c_time);
        $this->assertNotEmpty($data);
    }

    function getTime()
    {
        return (microtime(true) * 1000);
    }
}
