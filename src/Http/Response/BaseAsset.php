<?php

namespace K5\Http\Response;

class BaseAsset
{
    protected string $baseUrl;
    protected string $basePath;
    protected string $develMode;
    protected array $collection;
    protected array $packed;
    protected string $jsLib = "";

    public function __construct(string $baseUrl,string $develMode,string $basePath='')
    {
        $this->baseUrl = $baseUrl;
        $this->develMode = $develMode;
        $this->basePath = $basePath;
        $this->collection = [];
        $this->packed = [];
        $this->packed['js_lib'] = '';
        $this->packed['css'] = '';
    }

    public function Append(\K5\Entity\Html\Component $elm) : void
    {
        if($elm->Type === 'lib' || $elm->Type === 'js_lib' || $elm->Type === 'css' ) {
            $elm->Content = $this->baseUrl.$elm->Content;
            if($elm->Refresh) {
                $elm->Content = $elm->Content.$this->develMode;
            }
        }
        $this->collection[$elm->DomID] = $elm;
    }

    public function AppendRemote(\K5\Entity\Html\Component $elm) : void
    {
        $this->collection[$elm->DomID] = $elm;
    }

    public function Remove(string $domId) : void
    {
        if(isset($this->collection[$domId])) {
            unset($this->collection[$domId]);
        }
    }

    public function GetByDomId(string $domId) : ?\K5\Entity\Html\Component
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

    public function MinifyCollection() : array
    {
        /** @var \K5\Entity\Html\Component $item */
        foreach ($this->collection as $item) {
            $_file = $this->basePath.$item->Content;
            if (file_exists($_file)) {
                $content = file_get_contents($_file);
                if($item->Type == 'css') {
                    $this->packed['css'] .= $this->MinifyCSS($content) . "\n";
                } else {
                    $this->packed['js_lib'] .= $this->MinifyJavascript($content) . "\n";
                }
            } else {
                \K5\U::linfo('Minify component '.$_file.' not exist \n');
            }
        }
        return $this->packed;
    }


    public function MinifyJavascript(string $code) : string
    {
        // Remove comments
        $code = preg_replace('/\/\*.*?\*\/|\/\/.*(?=[\n\r])/', '', $code);
        // Remove whitespace and new lines
        $code = preg_replace('/\s{2,}/', ' ', $code);
        $code = preg_replace('/\s*([{};,:])\s*/', '$1', $code);
        $code = str_replace(["\n", "\r", "\t"], '', $code);

        return trim($code);
    }

    // Function to minify CSS content
    public function MinifyCSS(string $code) : string
    {
        // Remove comments
        $code = preg_replace('/\/\*.*?\*\//s', '', $code);
        // Remove whitespace and new lines
        $code = preg_replace('/\s{2,}/', ' ', $code);
        $code = preg_replace('/\s*([{};,:])\s*/', '$1', $code);
        $code = str_replace(["\n", "\r", "\t"], '', $code);

        return trim($code);
    }
}
