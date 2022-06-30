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

namespace ip2region;

class Ip2Region
{
    public const XDB_PATH = __DIR__ . '/../assets/ip2region.xdb';

    /**
     * 完全基于文件的查询
     *
     * @param $ip
     * @return string|null
     * @throws \Exception
     */
    public static function search($ip)
    {
        return XdbSearcher::newWithFileOnly(self::XDB_PATH)->search($ip);
    }

    /**
     * 完全基于文件的查询
     *
     * 备注：并发使用，每个线程或者协程需要创建一个独立的 searcher 对象。
     * @return XdbSearcher
     */
    public static function newWithFileOnly()
    {
        return XdbSearcher::newWithFileOnly(self::XDB_PATH);
    }

    /**
     * 缓存 VectorIndex 索引
     *
     * 备注：并发使用，每个线程或者协程需要创建一个独立的 searcher 对象，但是都共享统一的只读 vectorIndex。
     * @return XdbSearcher
     * @throws \RuntimeException
     */
    public static function newWithVectorIndex()
    {
        // 从 path 加载 VectorIndex 缓存，把下述的 vIndex 变量缓存到内存里面。
        $vIndex = XdbSearcher::loadVectorIndexFromFile(self::XDB_PATH);
        if ($vIndex === null) {
            throw new \RuntimeException(sprintf("failed to load vector index from '%s'", self::XDB_PATH));
        }
        // 使用全局的 vIndex 创建带 VectorIndex 缓存的查询对象。
        return XdbSearcher::newWithVectorIndex(self::XDB_PATH, $vIndex);
    }

    /**
     * 缓存整个 xdb 数据
     *
     * 备注：并发使用，用整个 xdb 缓存创建的 searcher 对象可以安全用于并发。
     * @return XdbSearcher
     * @throws \RuntimeException
     */
    public static function newWithBuffer()
    {
        // 从 path 加载整个 xdb 到内存。
        $cBuff = XdbSearcher::loadContentFromFile(self::XDB_PATH);
        if ($cBuff === null) {
            throw new \RuntimeException(sprintf("failed to load content buffer from '%s'", self::XDB_PATH));
        }
        return XdbSearcher::newWithBuffer($cBuff);
    }
}
