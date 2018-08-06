<?php

namespace CakeMix\View\Helper;

use Cake\Core\Configure;
use Cake\View\Helper;

/**
 * Mix helper
 *
 * @property Helper\UrlHelper Url
 * @property Helper\HtmlHelper Html
 */
class MixHelper extends Helper
{
    /**
     * List of helpers used by this helper
     *
     * @var array
     */
    public $helpers = [
        'Url',
        'Html'
    ];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'hotPath' => WWW_ROOT . 'hot',
        'manifestPath' => WWW_ROOT . 'mix-manifest.json'
    ];

    /**
     * @param string $path Script path
     * @return string
     * @throws \Exception
     */
    public function script(string $path)
    {
        if (file_exists($this->getConfig('hotPath'))) {
            $hotUrl = file_get_contents($this->getConfig('hotPath'));

            return $this->Url->script($path, ['pathPrefix' => $hotUrl . Configure::read('App.jsBaseUrl')]);
        }

        return $this->_mix($path, 'script');
    }

    /**
     * @param string $path Css path
     * @return string
     * @throws \Exception
     */
    public function css(string $path)
    {
        if (file_exists($this->getConfig('hotPath'))) {
            $hotUrl = file_get_contents($this->getConfig('hotPath'));

            return $this->Url->css($path, ['pathPrefix' => $hotUrl . Configure::read('App.cssBaseUrl')]);
        }

        return $this->_mix($path, 'css');
    }

    /**
     * @param string $path path
     * @param string $method url method
     * @return string
     * @throws \Exception
     */
    protected function _mix(string $path, string $method)
    {
        static $manifests = [];

        $manifestPath = $this->getConfig('manifestPath');
        if (!isset($manifests[$manifestPath])) {
            if (!file_exists($manifestPath)) {
                throw new \Exception('The Mix manifest does not exist.');
            }
            $manifests[$manifestPath] = json_decode(file_get_contents($manifestPath), true);
        }

        $manifest = $manifests[$manifestPath];
        $path = $this->Url->{$method}($path);
        if (!isset($manifest[$path])) {
            throw new \Exception("Unable to locate Mix file: {$path}.");
        }

        return $manifest[$path];
    }

    /**
     * @param string $path Script path
     * @param array $options Options array
     * @return string
     * @throws \Exception
     */
    public function htmlScript(string $path, array $options = [])
    {
        return $this->Html->script($this->script($path), $options);
    }

    /**
     * @param string $path Css path
     * @param array $options Options array
     * @return string
     * @throws \Exception
     */
    public function htmlCss(string $path, array $options = [])
    {
        return $this->Html->css($this->css($path), $options);
    }
}
