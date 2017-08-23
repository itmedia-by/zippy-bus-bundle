<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle\Tests;

use Itmedia\ZippyBusBundle\Client\ZippyBusClient;
use Itmedia\ZippyBusBundle\Schedule\City;
use Itmedia\ZippyBusBundle\Schedule\Direction;
use Itmedia\ZippyBusBundle\ZippyBusProvider;
use PHPUnit\Framework\TestCase;

class ZippyBusProviderTest extends TestCase
{

    public function testGetCity()
    {

        $responseJson = '{"id":1,"name":"Лида","uniqueTechName":"lida","timeZone":"Europe/Minsk","currentVersions":[{"id":362,"cityId":1,"transportTypeId":1,"startDate":"2017-08-03T13:08:15.78689","uniqueTechName":"1-201708030807"}]}';

        $client = $this->createClientMock($responseJson);
        $provider = new ZippyBusProvider($client);

        $city = $provider->getCity(1);

        $this->assertEquals('Лида', $city->getName());
        $this->assertEquals(1, $city->getId());
        $this->assertGreaterThan(0, $city->getVersion());
    }


    public function testGetRoutes()
    {
        $responseJson = '{"list":[{"id":32772,"name":"3","uniqueTechName":"3","versionId":362,"directions":[{"id":115903,"routeId":32772,"name":"Автовокзал-Индустриальный","techName":"avtovokzal-industrialnyy","uniqueTechName":"avtovokzal-industrialnyy-12345","days":[1,2,3,4,5]},{"id":115904,"routeId":32772,"name":"Автовокзал-Индустриальный","techName":"avtovokzal-industrialnyy","uniqueTechName":"avtovokzal-industrialnyy-67","days":[6,7]},{"id":115905,"routeId":32772,"name":"Индустриальный-Автовокзал","techName":"industrialnyy-avtovokzal","uniqueTechName":"industrialnyy-avtovokzal-12345","days":[1,2,3,4,5]},{"id":115906,"routeId":32772,"name":"Индустриальный-Автовокзал","techName":"industrialnyy-avtovokzal","uniqueTechName":"industrialnyy-avtovokzal-67","days":[6,7]}]},{"id":32773,"name":"1","uniqueTechName":"1","versionId":362,"directions":[{"id":115907,"routeId":32773,"name":"Шейбаки-Красноармейский","techName":"sheybaki-krasnoarmeyskiy","uniqueTechName":"sheybaki-krasnoarmeyskiy-12345","days":[1,2,3,4,5]},{"id":115908,"routeId":32773,"name":"Шейбаки-Красноармейский","techName":"sheybaki-krasnoarmeyskiy","uniqueTechName":"sheybaki-krasnoarmeyskiy-67","days":[6,7]},{"id":115909,"routeId":32773,"name":"Красноармейский-Шейбаки","techName":"krasnoarmeyskiy-sheybaki","uniqueTechName":"krasnoarmeyskiy-sheybaki-12345","days":[1,2,3,4,5]},{"id":115910,"routeId":32773,"name":"Красноармейский-Шейбаки","techName":"krasnoarmeyskiy-sheybaki","uniqueTechName":"krasnoarmeyskiy-sheybaki-67","days":[6,7]}]},{"id":32774,"name":"6","uniqueTechName":"6","versionId":362,"directions":[{"id":115911,"routeId":32774,"name":"Красноармейский-Южный городок","techName":"krasnoarmeyskiy-yuzhnyy-gorodok","uniqueTechName":"krasnoarmeyskiy-yuzhnyy-gorodok-12345","days":[1,2,3,4,5]},{"id":115912,"routeId":32774,"name":"Южный городок-Красноармейский","techName":"yuzhnyy-gorodok-krasnoarmeyskiy","uniqueTechName":"yuzhnyy-gorodok-krasnoarmeyskiy-12345","days":[1,2,3,4,5]}]},{"id":32775,"name":"9","uniqueTechName":"9","versionId":362,"directions":[{"id":115913,"routeId":32775,"name":"Лидаагротехсервис-Тухачевского","techName":"lidaagrotehservis-tuhachevskogo","uniqueTechName":"lidaagrotehservis-tuhachevskogo-12345","days":[1,2,3,4,5]},{"id":115914,"routeId":32775,"name":"Лидаагротехсервис-Тухачевского","techName":"lidaagrotehservis-tuhachevskogo","uniqueTechName":"lidaagrotehservis-tuhachevskogo-67","days":[6,7]},{"id":115915,"routeId":32775,"name":"Тухачевского-Лидаагротехсервис","techName":"tuhachevskogo-lidaagrotehservis","uniqueTechName":"tuhachevskogo-lidaagrotehservis-12345","days":[1,2,3,4,5]},{"id":115916,"routeId":32775,"name":"Тухачевского-Лидаагротехсервис","techName":"tuhachevskogo-lidaagrotehservis","uniqueTechName":"tuhachevskogo-lidaagrotehservis-67","days":[6,7]}]},{"id":32776,"name":"12","uniqueTechName":"12","versionId":362,"directions":[{"id":115917,"routeId":32776,"name":"Лакокраска-Тухачевского","techName":"lakokraska-tuhachevskogo","uniqueTechName":"lakokraska-tuhachevskogo-12345","days":[1,2,3,4,5]},{"id":115918,"routeId":32776,"name":"Тухачевского-Лакокраска","techName":"tuhachevskogo-lakokraska","uniqueTechName":"tuhachevskogo-lakokraska-12345","days":[1,2,3,4,5]}]},{"id":32777,"name":"2","uniqueTechName":"2","versionId":362,"directions":[{"id":115919,"routeId":32777,"name":"Крупской-Лакокраска","techName":"krupskoy-lakokraska","uniqueTechName":"krupskoy-lakokraska-12345","days":[1,2,3,4,5]},{"id":115920,"routeId":32777,"name":"Крупской-Лакокраска","techName":"krupskoy-lakokraska","uniqueTechName":"krupskoy-lakokraska-67","days":[6,7]},{"id":115921,"routeId":32777,"name":"Лакокраска-Крупской","techName":"lakokraska-krupskoy","uniqueTechName":"lakokraska-krupskoy-12345","days":[1,2,3,4,5]},{"id":115922,"routeId":32777,"name":"Лакокраска-Крупской","techName":"lakokraska-krupskoy","uniqueTechName":"lakokraska-krupskoy-67","days":[6,7]}]},{"id":32778,"name":"5","uniqueTechName":"5","versionId":362,"directions":[{"id":115923,"routeId":32778,"name":"Оптик-Южный городок","techName":"optik-yuzhnyy-gorodok","uniqueTechName":"optik-yuzhnyy-gorodok-12345","days":[1,2,3,4,5]},{"id":115924,"routeId":32778,"name":"Оптик-Южный городок","techName":"optik-yuzhnyy-gorodok","uniqueTechName":"optik-yuzhnyy-gorodok-67","days":[6,7]},{"id":115925,"routeId":32778,"name":"Южный городок-Оптик","techName":"yuzhnyy-gorodok-optik","uniqueTechName":"yuzhnyy-gorodok-optik-12345","days":[1,2,3,4,5]},{"id":115926,"routeId":32778,"name":"Южный городок-Оптик","techName":"yuzhnyy-gorodok-optik","uniqueTechName":"yuzhnyy-gorodok-optik-67","days":[6,7]}]}]}';

        $client = $this->createClientMock($responseJson);
        $provider = new ZippyBusProvider($client);

        $routes = $provider->getRoutes(new City(1, 'Lida', 132), 1);

        $route = $routes[5];
        $this->assertEquals('2', $route->getName());
        $this->assertEquals(32777, $route->getId());
        $this->assertCount(2, $route->getDirections());

        $direction = $route->getDirections()[0];
        $this->assertEquals('Крупской-Лакокраска', $direction->getName());
        $this->assertEquals('krupskoy-lakokraska', $direction->getSlug());
        $this->assertEquals([1, 2, 3, 4, 5], $direction->getDays());
        $this->assertEquals(115919, $direction->getId());


        $routes = $provider->getRoutes(new City(1, 'Lida', 132), 7);

        $route = $routes[5];
        $this->assertEquals('2', $route->getName());
        $this->assertEquals(32777, $route->getId());
        $this->assertCount(2, $route->getDirections());

        $direction = $route->getDirections()[0];

        $this->assertEquals('Крупской-Лакокраска', $direction->getName());
        $this->assertEquals('krupskoy-lakokraska', $direction->getSlug());
        $this->assertEquals([6, 7], $direction->getDays());
        $this->assertEquals(115920, $direction->getId());


        $this->assertCount(7, $routes);
    }


    public function testGetDirectionStops()
    {
        $responseJson = '{"list":[{"id":62,"cityId":1,"name":"Индустриальный","uniqueName":"Индустриальный","techName":"industrialnyy","uniqueTechName":"industrialnyy","schedule":{"minutes":[365,385,410,430,450,470,490,510,530,550,570,590,610,650,690,715,740,765,790,815,840,865,890,915,940,965,990,1015,1040,1065,1090,1115,1140,1165,1190,1230,1273,1306,1339,1373,1406,1439,1473,1515],"partialMinutes":[]}},{"id":55,"cityId":1,"name":"Лидастройматериалы","uniqueName":"Лидастройматериалы","techName":"lidastroymaterialy","uniqueTechName":"lidastroymaterialy","schedule":{"minutes":[367,387,412,432,452,472,492,512,532,552,572,592,612,652,692,717,742,767,792,817,842,867,892,917,942,967,992,1017,1042,1067,1092,1117,1142,1167,1192,1232,1275,1308,1341,1375,1408,1441,1475,1517],"partialMinutes":[]}},{"id":89,"cityId":1,"name":"Притыцкого","uniqueName":"Притыцкого","techName":"pritytskogo","uniqueTechName":"pritytskogo","schedule":{"minutes":[369,389,415,435,455,475,495,515,535,555,575,595,615,655,695,720,745,770,795,820,845,870,895,920,945,970,995,1020,1045,1070,1095,1120,1145,1170,1195,1235,1278,1311,1344,1378,1411,1444,1478,1519],"partialMinutes":[]}},{"id":34,"cityId":1,"name":"Завод Неман","uniqueName":"Завод Неман","techName":"zavod-neman","uniqueTechName":"zavod-neman","schedule":{"minutes":[375,395,422,442,462,482,502,522,542,562,582,602,622,662,702,727,752,777,802,827,852,877,902,927,952,977,1002,1027,1052,1077,1102,1127,1152,1177,1202,1242,1285,1318,1351,1385,1418,1451,1483,1525],"partialMinutes":[]}},{"id":26,"cityId":1,"name":"Дачи","uniqueName":"Дачи","techName":"dachi","uniqueTechName":"dachi","schedule":{"minutes":[377,397,424,444,464,484,504,524,544,564,584,604,624,664,704,729,754,779,804,829,854,879,904,929,954,979,1004,1029,1054,1079,1104,1129,1154,1179,1204,1244,1287,1320,1353,1387,1420,1453,1485,1527],"partialMinutes":[]}},{"id":43,"cityId":1,"name":"Кольцевая","uniqueName":"Кольцевая","techName":"koltsevaya","uniqueTechName":"koltsevaya","schedule":{"minutes":[381,401,428,448,468,488,508,528,548,568,588,608,628,668,708,733,758,783,808,833,858,883,908,933,958,983,1008,1033,1058,1083,1108,1133,1158,1183,1208,1248,1291,1324,1357,1391,1424,1457,1489,1531],"partialMinutes":[]}},{"id":65,"cityId":1,"name":"Магазин Алми","uniqueName":"Магазин Алми","techName":"magazin-almi","uniqueTechName":"magazin-almi","schedule":{"minutes":[383,403,430,450,470,490,510,530,550,570,590,610,630,670,710,735,760,785,810,835,860,885,910,935,960,985,1010,1035,1060,1085,1110,1135,1160,1185,1210,1250,1293,1326,1359,1393,1426,1459,1491,1533],"partialMinutes":[]}},{"id":21,"cityId":1,"name":"Гастелло","uniqueName":"Гастелло","techName":"gastello","uniqueTechName":"gastello","schedule":{"minutes":[385,405,432,452,472,492,512,532,552,572,592,612,632,672,712,737,762,787,812,837,862,887,912,937,962,987,1012,1037,1062,1087,1112,1137,1162,1187,1212,1252,1295,1328,1361,1395,1428,1461,1493,1535],"partialMinutes":[]}},{"id":29,"cityId":1,"name":"Детский сад №31","uniqueName":"Детский сад №31","techName":"detskiy-sad-31","uniqueTechName":"detskiy-sad-31","schedule":{"minutes":[387,407,434,454,474,494,514,534,554,574,594,614,634,674,714,739,764,789,814,839,864,889,914,939,964,989,1014,1039,1064,1089,1114,1139,1164,1189,1214,1254,1297,1330,1363,1397,1430,1463,1495,1537],"partialMinutes":[]}},{"id":47,"cityId":1,"name":"Куйбышева","uniqueName":"Куйбышева","techName":"kuybysheva","uniqueTechName":"kuybysheva","schedule":{"minutes":[389,409,436,456,476,496,516,536,556,576,596,616,636,676,716,741,766,791,816,841,866,891,916,941,966,991,1016,1041,1066,1091,1116,1141,1166,1191,1216,1256,1299,1332,1365,1399,1432,1465,1497,1539],"partialMinutes":[]}},{"id":57,"cityId":1,"name":"Лидсельмаш","uniqueName":"Лидсельмаш","techName":"lidselmash","uniqueTechName":"lidselmash","schedule":{"minutes":[392,414,441,461,481,501,521,541,561,578,601,621,641,681,721,746,771,796,821,846,871,896,921,946,971,996,1021,1046,1071,1096,1121,1146,1171,1196,1221,1261,1304,1337,1370,1404,1437,1470,1500,1543],"partialMinutes":[]}},{"id":1,"cityId":1,"name":"8 Марта","uniqueName":"8 Марта","techName":"8-marta","uniqueTechName":"8-marta","schedule":{"minutes":[394,416,443,463,483,503,523,543,563,580,603,623,643,683,723,748,773,798,823,848,873,898,923,948,973,998,1023,1048,1073,1098,1123,1148,1173,1198,1223,1263,1306,1339,1372,1406,1442,1472,1502,1547],"partialMinutes":[]}},{"id":98,"cityId":1,"name":"Советская","uniqueName":"Советская","techName":"sovetskaya","uniqueTechName":"sovetskaya","schedule":{"minutes":[396,419,445,465,485,505,525,545,565,582,605,625,645,685,725,750,775,800,825,850,875,900,925,950,975,1000,1025,1050,1075,1100,1125,1150,1175,1200,1225,1263,1308,1342,1374,1408,1442,1474,1504,1550],"partialMinutes":[]}},{"id":74,"cityId":1,"name":"Музыкальная школа","uniqueName":"Музыкальная школа","techName":"muzykalnaya-shkola","uniqueTechName":"muzykalnaya-shkola","schedule":{"minutes":[398,421,447,467,487,507,527,547,567,584,607,627,647,687,727,752,777,802,827,852,877,902,927,952,977,1002,1027,1052,1077,1102,1127,1152,1177,1202,1227,1265,1310,1344,1376,1410,1444,1476,1506,1552],"partialMinutes":[]}},{"id":12,"cityId":1,"name":"Бульвар Гедымина","uniqueName":"Бульвар Гедымина","techName":"bulvar-gedymina","uniqueTechName":"bulvar-gedymina","schedule":{"minutes":[400,423,450,470,490,510,530,550,570,587,610,630,650,690,730,755,780,805,830,855,880,905,930,955,980,1005,1030,1055,1080,1105,1130,1155,1180,1205,1230,1268,1313,1346,1379,1413,1446,1479,1508,1554],"partialMinutes":[]}},{"id":95,"cityId":1,"name":"Рынок","uniqueName":"Рынок","techName":"rynok","uniqueTechName":"rynok","schedule":{"minutes":[402,425,452,472,492,512,532,552,572,589,612,632,637,652,662,687,692,707,732,757,782,807,832,857,882,907,932,957,982,1007,1032,1057,1082,1107,1132,1157,1182,1207,1232,1270,1315,1348,1381,1415,1448,1481,1510,1556],"partialMinutes":[]}}]}';

        $client = $this->createClientMock($responseJson);
        $provider = new ZippyBusProvider($client);

        $stops = $provider->getDirectionStops(new Direction(123, '111', '12312', [6, 7]));

        $this->assertCount(16, $stops);

        $stop = $stops[0];

        $this->assertEquals(62, $stop->getId());
        $this->assertEquals('Индустриальный', $stop->getName());
        $this->assertEquals('industrialnyy', $stop->getSlug());
        $this->assertCount(44, $stop->getTimes());

    }


    private function createClientMock(string $willReturnRawJson)
    {
        $mock = $this->getMockBuilder(ZippyBusClient::class)
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMock();

        $mock
            ->method('get')
            ->willReturn(\GuzzleHttp\json_decode($willReturnRawJson, true));

        return $mock;
    }

}