<?php

/**
 * kuyoto getallheaders (https://github.com/kuyoto/getallheaders/)
 *
 * PHP version 5 and 7
 *
 * @category  Library
 * @package   kuyoto\getallheaders
 * @author    Tolulope Kuyoro <nifskid1999@gmail.com>
 * @copyright 2020 Tolulope Kuyoro <nifskid1999@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php (MIT License)
 * @version   GIT: master
 * @link      https://github.com/kuyoto/getallheaders/
 */

declare(strict_types=1);

namespace Kuyoto\GetAllHeaders\Tests;

use PHPUnit\Framework\TestCase;

/**
 * GetAllHeaders test.
 *
 * @category Library
 * @package  kuyoto\getallheaders
 * @author   Tolulope Kuyoro <nifskid1999@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php (MIT License)
 * @link     https://github.com/kuyoto/getallheaders/
 */
class GetAllHeadersTest extends TestCase
{
    /**
     * GetAllHeadersTest::testGetAllHeaders()
     *
     * @param string $testType The test type.
     * @param string $expected The expected data.
     * @param string $server   The server.
     *
     * @return void
     *
     * @dataProvider headerProvider
     */
    public function testGetAllHeaders($testType, $expected, $server)
    {
        foreach ($server as $key => $val) {
            $_SERVER[$key] = $val;
        }

        $result = getallheaders();

        $this->assertEquals($expected, $result, sprintf('Error testing %s works.', $testType));

        // Clean up.
        foreach ($server as $key => $val) {
            unset($_SERVER[$key]);
        }
    }

    /**
     * GetAllHeadersTest::headerProvider()
     *
     * @return array
     */
    public function headerProvider()
    {
        return [
            [
                'normal case',
                [
                    'Key-One'                 => 'foo',
                    'Key-Two'                 => 'bar',
                    'Another-Key-For-Testing' => 'baz',
                ],
                [
                    'HTTP_KEY_ONE'                 => 'foo',
                    'HTTP_KEY_TWO'                 => 'bar',
                    'HTTP_ANOTHER_KEY_FOR_TESTING' => 'baz',
                ],
            ],
            [
                'Content-Type',
                ['Content-Type' => 'two'],
                ['CONTENT_TYPE' => 'two'],
            ],
            [
                'Content-Length',
                ['Content-Length' => '222'],
                ['CONTENT_LENGTH' => '222'],
            ],
            [
                'Content-MD5',
                ['Content-Md5' => 'aef123'],
                ['CONTENT_MD5' => 'aef123'],
            ],
            [
                'Authorization (normal)',
                ['Authorization' => 'testing'],
                ['HTTP_AUTHORIZATION' => 'testing'],
            ],
            [
                'Authorization (redirect)',
                ['Authorization' => 'testing redirect'],
                ['REDIRECT_HTTP_AUTHORIZATION' => 'testing redirect'],
            ],
        ];
    }
}
