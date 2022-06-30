<?php

/*
 * This file is part of the Ip2Region package.
 *
 * Copyright 2022 The Ip2Region Authors. All rights reserved.
 * Use of this source code is governed by a Apache2.0-style
 * license that can be found in the LICENSE file.
 *
 * @link   https://github.com/chinayin/ip2region-sdk-php
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ip2region\Tests;

use ip2region\Ip2Region;

class Ip2RegionTest extends TestCase
{
    private $ips = [
        '220.181.38.251' => '中国|0|北京|北京市|电信',
        '123.151.137.18' => '中国|0|天津|天津市|电信',
        '103.100.62.111' => '中国|0|香港|0|0',
        '20.205.243.166' => '美国|0|0|0|微软',
    ];

    public static function builder($cachePolicy)
    {
        if ('vectorIndex' === $cachePolicy) {
            return Ip2Region::newWithVectorIndex();
        } elseif ('content' === $cachePolicy) {
            return Ip2Region::newWithBuffer();
        }
        return Ip2Region::newWithFileOnly();
    }

    private function search($searcher, $ip, $expected)
    {
        $ts = self::now();
        $r = $searcher->search($ip);
        printf(
            "ip: %s, region: %s, ioCount: %d, took: %.5f ms\n",
            $ip,
            $r,
            $searcher->getIOCount(),
            self::now() - $ts
        );
        $this->assertEquals($expected, $r);
    }

    public function testSearch()
    {
        foreach (['file', 'vectorIndex', 'content'] as $cachePolicy) {
            printf("cachePolicy = %s\n", $cachePolicy);
            $searcher = $this->builder($cachePolicy);
            foreach ($this->ips as $ip => $expected) {
                $this->search($searcher, $ip, $expected);
            }
            printf(PHP_EOL);
        }
    }
}
