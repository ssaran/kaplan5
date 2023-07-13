<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 12.01.2018
 * Time: 13:56
 */

namespace K5;

class View5
{
    public Component\Route $Routes;
    public \K5\Entity\View\Dom\Keys $Dom;
    public \K5\Entity\View\Dom\ClassKeys $Css;

    public ?string $HtmlOutput;
    public ?string $JsOutput;
    public ?string $CssOutput;
    public ?string $OtherOutput;

    protected \K5\Entity\Request\Setup $setup;
    protected \K5\Entity\Flex\BaseFlex $data;

    /**
     * @param Entity\Request\Setup $setup
     * @param $data
     * @param $skinPath
     */
    public function __construct(\K5\Entity\Request\Setup $setup,\K5\Entity\Flex\BaseFlex $data)
    {
        $this->setup = $setup;
        $this->data = $data;

        $this->Dom = $this->setup->Dom;
        $this->Css = $this->setup->Css;
        $this->Routes = $this->setup->Routes;
    }

    public function Render() : void
    {
        try {
            $this->HtmlOutput = $this->renderHtml($this->setup,$this->data);
            $this->JsOutput = $this->renderJs($this->setup,$this->data);
            $this->CssOutput = $this->renderCss($this->setup,$this->data);
        } catch (\Exception $e) {
            \K5\Log::Error("View Error",$e->getMessage());
        }
    }

    protected function renderHtml() : string
    {
        return '';
    }

    protected function renderJs() : string
    {
        return '';
    }

    protected function renderCss() : string
    {
        return '';
    }
}
