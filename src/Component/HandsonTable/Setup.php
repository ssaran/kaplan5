<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 24.12.2018
 * Time: 13:48
 */

namespace K5\Component\HandsonTable;


class Setup
{
    public string $DomAnchor;
    public array $DomElements;
    public string $ExportPrefix;
    public array $ListRoute = [];
    public array $Routes = [];
    public array $Fields = [];
    public array $Labels = [];
    public array $Buttons = [];
    public array $ButtonRoutes = [];
    public $Lookup;
    public $Components;
    public $RequestAppend;
    public $Navbar;

    protected $domPrefix;
    protected $routeBase;

    /** Creates auto config for handson table include button config and route config */
    public function __construct($domAnchor, $domPrefix, $routeBase)
    {
        $this->DomAnchor = $domAnchor;
        $this->domPrefix = $domPrefix;
        $this->routeBase = $routeBase;
        $this->DomElements = [
            'Destination' => 'layout_content',
            'DomAnchor' => $domAnchor,
            'HotObject' => $domAnchor . '.Grid',
            'HotSelector' => $domPrefix . '_hot',
            'SearchSelector' => $domPrefix . '_search',
            'Paginator' => $domPrefix . '-paginator-cover',
            'PaginatorLink' => $domPrefix . '-paginator-link'
        ];
        $this->Lookup = new \stdClass();
        $this->RequestAppend = new \stdClass();
        $this->Components = new \stdClass();
    }

    public function AddButton(\K5\Component\HandsonTable\Button $button)
    {
        $this->Buttons[$button->Uri] = $button;
    }

    public function AddField(\K5\Component\HandsonTable\Column $column)
    {
        $this->Fields[$column->Config->data] = $column;
    }

    public function GetButtons()
    {
        return $this->Buttons;
    }

    public function SetDestination($destination)
    {
        $this->DomElements['Destination'] = $destination;
    }

    public function SetDomElement($key,$destination)
    {
        $this->DomElements[$key] = $destination;
    }

    public function AddLookup($lookupKey, $lookupData)
    {
        $this->Lookup->{$lookupKey} = $lookupData;
    }

    public function AppendParameter($paramKey, $paramValue)
    {
        $this->RequestAppend->{$paramKey} = $paramValue;
    }

    public function AddComponent($key, $value)
    {
        $this->Components->{$key} = $value;
    }
}
