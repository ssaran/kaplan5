<?php

namespace K5\Entity\View;

class BaseAsset
{
    protected string $baseUrl;
    protected string $develMode;
    protected array $collection;
    protected string $jsLib = "";

    public function __construct(string $baseUrl,string $develMode)
    {
        $this->baseUrl = $baseUrl;
        $this->develMode = $develMode;
    }

    public function Append(\K5\Entity\View\Element $elm) : void
    {
        if($elm->Type === 'lib' || $elm->Type === 'js_lib' || $elm->Type === 'css' ) {
            $elm->Content = $this->baseUrl.$elm->Content;
            if($elm->Refresh) {
                $elm->Content = $elm->Content.$this->develMode;
            }
        }
        $this->collection[$elm->DomID] = $elm;
    }

    public function AppendRemote(\K5\Entity\View\Element $elm) : void
    {
        $this->collection[$elm->DomID] = $elm;
    }

    public function Remove(string $domId) : void
    {
        if(isset($this->collection[$domId])) {
            unset($this->collection[$domId]);
        }
    }

    public function GetByDomId(string $domId) : ?\K5\Entity\View\Element
    {
        if(!isset($this->collection[$domId])) {
            return null;
        }
        return $this->collection[$domId];
    }

    public function GetCollection() : array
    {
        return $this->collection;
    }
}