ZippyBus client
===============

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/itmedia-by/zippy-bus-bundle/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/itmedia-by/zippy-bus-bundle/?branch=develop)
[![Build Status](https://scrutinizer-ci.com/g/itmedia-by/zippy-bus-bundle/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/itmedia-by/zippy-bus-bundle/build-status/develop)

Интеграция с сервисом [ZippyBus.com](https://zippybus.com/):
- Symfony 3.0+
- Нативный PHP 7.0+


Установка и настройка 
---------------------


### Symfony 3

app/AppKernel.php: 

```php
<?php

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            new Itmedia\ZippyBusBundle\ItmediaZippyBusBundle(),        
        ];
    }
    
    // ...
}
```

app/config/config.yml:

```yaml
itmedia_zippy_bus:
    token: 'my_token'   # Токен, выданный сервисом
    cache_ttl: 3600     # Время жизни кэша (секунд). По умолчанию 3600 (1 час)
```

Получить сервис доступа к расписанию:

```php
$zippyBusProvider = $container->get('itmedia_zippy_bus.provider');
```


### Без использования Symfony

В этом случае необходимые сервисы (`ZippyBusProvider`) нужно собрать вручную.

```php
<?php

use \Itmedia\ZippyBusBundle\Client\ZippyBusClient;
use \Itmedia\ZippyBusBundle\ZippyBusProvider;
use \Itmedia\ZippyBusBundle\Factory\ScheduleObjectFromArrayFactory;

// Токен, выданный сервисом
$token = 'my_token';

// Любая библиотека кэширования с поддержкой PSR6 Simple cache, например https://github.com/symfony/cache
$cache = new Cache();

// Время жизни кэша (секунд). По умолчанию 3600 (1 час)
$cacheTtl = 3600; 

$apiClient = new ZippyBusClient($token, $cache, $cacheTtl);
$zippyBusProvider = new ZippyBusProvider($apiClient, new ScheduleObjectFromArrayFactory());
```



Примеры использования
---------------------

@todo
