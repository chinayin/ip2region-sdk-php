# ip2region SDK for PHP (定期更新数据版)

[![Author](https://img.shields.io/badge/author-@chinayin-blue.svg)](https://github.com/chinayin)
[![Software License](https://img.shields.io/badge/license-Apache--2.0-brightgreen.svg)](LICENSE)
[![Latest Version](https://img.shields.io/packagist/v/chinayin/ip2region.svg)](https://packagist.org/packages/chinayin/ip2region)
[![Total Downloads](https://img.shields.io/packagist/dt/chinayin/ip2region.svg)](https://packagist.org/packages/chinayin/ip2region)
![php 7.1+](https://img.shields.io/badge/php-min%207.1-red.svg)

### Installation

运行环境要求 PHP 7.1 及以上版本，以及[cURL](http://php.net/manual/zh/book.curl.php)。

#### 定期更新数据版

特点：`xdb数据`封装在composer包内，数据会定期更新

> composer require chinayin/ip2region

#### 官方原生查询包

特点：包更小，数据路径自定义

使用方法：[github.com/chinayin/ip2region-core](https://github.com/chinayin/ip2region-core-php)

### Quick Examples

#### 完全基于文件的查询

```php
use ip2region\Ip2Region;

$ip = '1.2.3.4';
try {
    $searcher = Ip2Region::newWithFileOnly();
    $region = $searcher->search($ip);
    // 或
    $region = Ip2Region::search($ip);
    var_dump($region);
} catch (\Exception $e) {
    var_dump($e->getMessage());
}
```

> 备注：并发使用，每个线程或者协程需要创建一个独立的 searcher 对象。

#### 缓存 VectorIndex 索引

如果你的 php 母环境支持，可以预先加载 vectorIndex 缓存，然后做成全局变量，每次创建 Searcher 的时候使用全局的
vectorIndex，可以减少一次固定的 IO 操作从而加速查询，减少 io 压力。

```php
use ip2region\Ip2Region;

$ip = '1.2.3.4';
try {
    $region = Ip2Region::newWithVectorIndex()->search($ip);
    var_dump($region);
} catch (\Exception $e) {
    var_dump($e->getMessage());
}
```

> 备注：并发使用，每个线程或者协程需要创建一个独立的 searcher 对象，但是都共享统一的只读 vectorIndex。

#### 缓存整个 xdb 数据

如果你的 PHP 母环境支持，可以预先加载整个 xdb 的数据到内存，这样可以实现完全基于内存的查询，类似之前的 memory search 查询。

```php
use ip2region\Ip2Region;

$ip = '1.2.3.4';
try {
    $region = Ip2Region::newWithBuffer()->search($ip);
    var_dump($region);
} catch (\Exception $e) {
    var_dump($e->getMessage());
}
```

> 备注：并发使用，用整个 xdb 缓存创建的 searcher 对象可以安全用于并发。
