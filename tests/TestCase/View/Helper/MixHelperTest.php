<?php

namespace CakeMix\Test\TestCase\View\Helper;

use CakeMix\View\Helper\MixHelper;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use Cake\View\View;

class MixHelperTest extends TestCase
{
    /**
     * Instance of HtmlHelper.
     *
     * @var MixHelper
     */
    public $Mix;

    public function setUp()
    {
        parent::setUp();
        Router::connect('/:controller/:action/*');
        $this->Mix = new MixHelper(new View());
        $this->Mix->setConfig([
            'hotPath' => TEST_APP_DIR . 'hot',
            'manifestPath' => TEST_APP_DIR . 'mix-manifest.json'
        ]);
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testScript()
    {
        $this->assertSame('/js/app.js?test', $this->Mix->script('app'));
        $this->assertSame('/js/test.js', $this->Mix->script('test'));
    }

    public function testCss()
    {
        $this->assertSame('/css/app.css?test', $this->Mix->css('app'));
        $this->assertSame('/css/test.css', $this->Mix->css('test'));
    }

    public function testHot()
    {
        $this->Mix->setConfig(['hotPath' => TEST_APP_DIR . 'hot1']);

        $this->assertSame('http://localhost:8080/js/app.js', $this->Mix->script('app'));
    }
}
