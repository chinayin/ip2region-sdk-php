### ip2region SDK for PHP

### Installation
> composer require chinayin/ip2region

### Quick Examples
```php
use lionsoul2014\Ip2Region;

$ip2region = new Ip2Region;

$ip = '220.181.38.150';
$data = $ip2region->memorySearch($ip);
$data = $ip2region->binarySearch($ip);
$data = $ip2region->btreeSearch($ip);

// binary算法/b-tree算法/Memory算法：
// 0.x毫秒/0.1x毫秒/0.1x毫秒
// 任何客户端b-tree都比binary算法快，当然Memory算法固然是最快的！
```
