<?php

namespace Em4nl\U;

require_once(dirname(__DIR__) . '/vendor/autoload.php');

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/mock/header.php';


class send_text_Test extends TestCase {

    protected $preserveGlobalState = FALSE;
    protected $runTestInSeparateProcess = TRUE;

    function test_sets_correct_status_header() {
        global $header_calls;
        $this->assertEmpty($header_calls);
        ob_start();
        send_text('iusdfasdf', true, '200');
        ob_end_clean();
        $this->assertEquals(count($header_calls), 2);
        $this->assertEquals($header_calls[0], 'HTTP/1.1 200 OK');
    }

    function test_sets_correct_content_type_header() {
        global $header_calls;
        $this->assertEmpty($header_calls);
        ob_start();
        send_text('iusdfasdf', true, '200');
        ob_end_clean();
        $this->assertEquals(count($header_calls), 2);
        $this->assertEquals($header_calls[1], 'Content-Type: text/plain');
    }

    function test_defines_unplug_response_sent() {
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        ob_start();
        send_text('iusdfasdf', true, '200');
        ob_end_clean();
        $this->assertTrue(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertTrue(UNPLUG_RESPONSE_SENT);
    }

    function test_echoes_body_text() {
        ob_start();
        send_text('iusdfasdf', true, '200');
        $output = ob_get_clean();
        $this->assertEquals($output, 'iusdfasdf');
    }
}
