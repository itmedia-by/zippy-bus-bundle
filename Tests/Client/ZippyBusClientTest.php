<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle\Tests\Client;

use Itmedia\ZippyBusBundle\Client\ZippyBusClient;
use Itmedia\ZippyBusBundle\Tests\Token;
use PHPUnit\Framework\TestCase;

class ZippyBusClientTest extends TestCase
{
    public function testGet()
    {
        $client = new ZippyBusClient(Token::TOKEN);
        $content = $client->get('cities/?include=currentVersions');
        $this->assertNotEmpty($content);
    }
}
