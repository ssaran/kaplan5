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
    public ?Entity\Dom\IdKeys $Dom;
    public ?Entity\Dom\ClassKeys $Css;

    public ?string $HtmlOutput = null;
    public ?string $JsOutput = null;
    public ?string $CssOutput = null;
    public ?string $OtherOutput = null;

    protected \K5\Entity\Request\Setup $setup;

    protected array $vars = [];

    /**
     * @param Entity\Request\Setup $setup
     * @param $data
     */
    public function __construct(\K5\Entity\Request\Setup $setup,$data)
    {
        $this->setup = $setup;
        $this->vars['data'] = $data;

        $this->Dom = $this->setup->Dom;
        $this->Css = $this->setup->Css;
        $this->Routes = $this->setup->Routes;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function Render() : void
    {
        try {
            $this->vars['dom'] = $this->Dom;
            $this->vars['routes'] = $this->Routes;
            $this->vars['css'] = $this->Css;
            $this->vars['setup'] = $this->setup;


            $this->renderHtml($this->vars);
            $this->renderJs($this->vars);
            $this->renderCss();
        } catch (\Exception $e) {
            \K5\U::lerr("View Error : ".$e->getMessage());
            throw $e;
        }
    }

    protected function translate(string $key) : string
    {
         return $this->setup->Locale->Translate[$key] ?? $key;
    }

    protected function renderHtml($vars) : void
    {
        $this->HtmlOutput = null;
    }

    protected function renderJs($vars) : void
    {
        $this->JsOutput = null;
    }

    protected function renderCss() : void
    {
        $this->CssOutput = null;
    }
}
