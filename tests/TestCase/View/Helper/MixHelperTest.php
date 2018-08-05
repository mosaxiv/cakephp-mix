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
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
