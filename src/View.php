<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 12.01.2018
 * Time: 13:56
 */

namespace K5;

class View
{
    public ?\K5\Component\Route $Routes;
    public ?\K5\Entity\View\Dom\Keys  $Dom;
    public ?\K5\Entity\View\Dom\ClassKeys $Css;

    public $HtmlOutput;
    public $JsOutput;
    public $CssOutput;
    public $OtherOutput;

    /** @var  \K5\Entity\Request\Setup */
    protected \K5\Entity\Request\Setup $setup;
    protected $vars = [];

    protected $jsCustom = false;
    protected $cssCustom = false;

    private $_htmlFile;
    private $_jsFile;
    private $_cssFile = false;

    private $_skinName;
    private $_skinPath;
    private $_callerClassName;

    /**
     * @param Entity\Request\Setup $setup
     * @param $data
     * @param $skinPath
     */
    public function __construct(\K5\Entity\Request\Setup $setup,$data=[],$skinPath=false)
    {
        $this->setup = $setup;
        $this->vars['data'] = $data;
        $this->_skinName = 'default';

        $this->Dom = $this->setup->Dom;
        $this->Css = $this->setup->Css;
        $this->Routes = $this->setup->Routes;
    }

    protected function setTemplate()
    {
        if($this->jsCustom && $this->_skinName !== 'default') {
            $jsFile = $this->_skinPath."_js.php";
            if(is_file($jsFile)) {
                $this->_jsFile = $jsFile;
            }
        }

        if($this->cssCustom && $this->_skinName !== 'default') {
            $cssFile = $this->_skinPath."_css.php";
            if(is_file($cssFile)) {
                $this->_cssFile = $cssFile;
            }
        }
    }

    public function Render()
    {
        try {
            $this->vars['dom'] = $this->Dom;
            $this->vars['routes'] = $this->Routes;
            $this->vars['css'] = $this->Css;
            $this->vars['setup'] = $this->setup;

            if(!$this->_htmlFile) {
                $this->renderHtml($this->vars);
            } else {
                $this->_getHtml($this->vars);
            }

            $this->setTemplate();

            if(!$this->_jsFile) {
                $this->renderJs($this->vars);
            } else {
                $this->_getJs($this->vars);
            }

            if(!$this->_cssFile) {
                $this->renderCss();
            } else {
                $this->_getCss();
            }

        } catch (\Exception $e) {
            \K5\Log::Error("View Error",$e->getMessage());
        }
    }


    private function _getHtml($vars)
    {
        try {
            extract($this->vars);
            ob_start();
            include $this->_htmlFile;
            $this->HtmlOutput = ob_get_clean();
        } catch (\Exception $e) {
            \K5\Log::Error("View Error",$e->getMessage());
        }
    }

    private function _getJs($vars)
    {
        extract($this->vars);
        ob_start();
        include $this->_jsFile;
        $this->JsOutput = \K5\V::StripCode(ob_get_clean());
    }

    private function _getCss()
    {
        ob_start();
        include $this->_cssFile;
        $this->CssOutput = ob_get_clean();
    }

    protected function renderHtml($vars)
    {
        $this->HtmlOutput = false;
    }

    protected function renderJs($vars)
    {
        $this->JsOutput = false;
    }

    protected function renderCss()
    {
        $this->CssOutput = false;
    }
}
