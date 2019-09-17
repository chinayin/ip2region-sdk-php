<?php

namespace lionsoul2014\Tests;

use lionsoul2014\Ip2Region;

class TestCase extends \PHPUnit\Framework\TestCase
{

    public function testFeature()
    {
        $funs = [
            'binarySearch', 'memorySearch', 'btreeSearch'
        ];
        $ip = '220.181.38.150';
        $expected = [
            'city_id' => 215,
            'region' => '中国|0|北京|北京市|电信',
        ];
        $ip2region = new Ip2Region;
        foreach ($funs as $fn) {
            $start = $this->getTime();
            $data = $ip2region->$fn($ip);
            $end = $this->getTime() - $start;
            printf("%s (%s) ==> %s|%s in %.5f millseconds\n", $ip, $fn, $data['city_id'], $data['region'], $end);
            $this->assertEquals($expected, $data);
        }
    }

    function getTime()
    {
        return (microtime(true) * 1000);
    }
}
