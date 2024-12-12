<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 24.12.2018
 * Time: 14:46
 */

namespace K5\Component\HandsonTable;

use K5\Entity\Config\HandsonTable\Grid as GridConfig;
use K5\Ui;
use K5\U;
use K5\Component\HandsonTable as Handson;

class Base extends \K5\Unity\Phalcon\BaseModule
{
    /** @var \K5\Component\HandsonTable\Setup */
    protected $hotSetup;
    protected $vars = [];
    protected $buttonRouteEdit = false;
    protected $buttonRouteDisable = false;
    protected $jsContent = '';
    protected $jsContentKey = '';
    protected $dom;
    protected $css;
    protected $routes;
    protected $data;

    public function __construct(\K5\Entity\Request\Setup $setup,$data,$domAnchor)
    {
        parent::__construct($setup);

        $this->hotSetup = new \K5\Component\HandsonTable\Setup($domAnchor,'_k5_',$this->setup->BaseUrl);
        $this->data = $data;
        if($this->setup->Dom != null) {
            $this->dom = $this->setup->Dom;
        }

        if($this->css != null) {
            $this->css = $this->setup->Css;
        }

        if($this->setup->Routes != null) {
            $this->routes = $this->setup->Routes;
        }
    }

    public function SetDomDestination($domId)
    {
        $this->hotSetup->SetDestination($domId);
    }

    public function AddLookup($key,$data)
    {
        $this->hotSetup->AddLookup($key,$data);
    }

    public function AddParam($key,$data)
    {
        $this->hotSetup->AppendParameter($key,$data);
    }

    public function RenderHeader($refresh=true)
    {
        $this->setRoutes();
        $this->setButtons();
        $this->setFields();
        $this->setupComponents();

        return $this->jsContent;
    }

    public function Load()
    {
        return $this->loadData();
    }

    public function Search()
    {
        return $this->searchData();
    }

    protected function loadData()
    {
        return '';
    }


    protected function searchData()
    {
        return '';
    }

    protected function setupComponents()
    {

    }

    protected function setRoutes()
    {
        $this->hotSetup->Routes = [];
        $this->hotSetup->ButtonRoutes = [];
    }

    protected function setButtons()
    {
        $this->hotSetup->ButtonRoutes['Edit'] = isset($this->Routes['Edit']) ? $this->Routes['Edit'] : false;
        $this->hotSetup->ButtonRoutes['Disable'] = isset($this->Routes['Disable']) ? $this->Routes['Disable'] : false;
    }

    public function SetDefaultButtons()
    {
        //--- Default Buttons
        if($this->hotSetup->ButtonRoutes['Edit']) {
            $btnEdit = new Button(
                $this->hotSetup->ButtonRoutes['Edit'],
                "Düzenle",
                "Düzenle",
                Button::ICON_EDIT,
                Button::CLASS_EDIT,
                "edit"
            );
            $btnEdit->SetTitle('Düzenle')->SetClass(Button::CLASS_EDIT,true)
                ->SetIcon(Button::ICON_EDIT)->SetKey('edit');
            $this->hotSetup->AddButton($btnEdit);
        }

        if($this->hotSetup->ButtonRoutes['Disable']) {
            $btnDisable = new Button(
                $this->hotSetup->ButtonRoutes['Disable'],
                "Sil",
                "Sil",
                Button::ICON_DELETE,
                Button::CLASS_DELETE,
                "delete"
            );
            $btnDisable->SetTitle('Sil')->SetClass(Button::CLASS_DELETE,true)
                ->SetIcon(Button::ICON_DELETE)->SetKey('delete')
                ->SetData(['question'=> 'Bu kaydı silmek istiyormusunuz ?']);
            $this->hotSetup->AddButton($btnDisable);
        }
    }

    protected function setFields($config=false){}

    protected function prepareFilters($filters,$look)
    {
        $r = [];
        $_filter = [];
        $r['look'] = $look;
        $r['filter'] = $_filter;
        return $r;
    }

    protected function parseList($list,$fields)
    {
        return $list;
    }

    protected function renderResultsForPrint($list,$labels,$fields)
    {
        $r = "<table class='display dataTable' id='".$this->hotSetup->DomElements['HotSelector']."_search_result_table'>\n";
        $r.= "\t<thead>\n";
        $r.= "\t\t<tr>\n";
        foreach ($labels as $lk => $lv) {
            if(in_array($lk,$fields)) {
                $r.= "\t\t\t<th>".$lv."</th>\n";
            }
        }
        $r.= "\t\t</tr>\n";
        $r.= "\t</thead>\n";
        $r.= "\t<tbody>\n";
        foreach($list['data'] as $k => $v) {
            $r.= "\t\t<tr>\n";
            foreach($v as $kv => $vv) {
                $r.= "\t\t\t<td>".$vv."</td>\n";
            }
            $r.= "\t\t</tr>\n";
        }
        $r.= "\t</tbody>\n";
        $r.= "</table>\n";
        return $r;
    }

    protected function getGridConfig()
    {
        $cConfig = new GridConfig();
        $cConfig->Labels = $this->hotSetup->Labels;
        $cConfig->Fields = $this->hotSetup->Fields;
        $cConfig->Routes = $this->hotSetup->Routes;
        $cConfig->DomElements = $this->hotSetup->DomElements;
        $cConfig->ExportPrefix = $this->hotSetup->ExportPrefix;
        $cConfig->RequestAppend = $this->hotSetup->RequestAppend;
        $cConfig->Components = $this->hotSetup->Components;
        $cConfig->Employer = '_k5_';

        return $cConfig;
    }

    /**
     * @param $data
     * @return \K5\Component\HandsonTable\DataPacket
     */
    protected function fromPhalconPaginate($data,$loaderUrl) : \K5\Component\HandsonTable\DataPacket
    {
        $ret = new \K5\Component\HandsonTable\DataPacket();
        $ret->data = $data->Paginate->items;
        $ret->current_page = $data->Paginate->current;
        $ret->path = $this->setup->BaseUrl;
        $ret->first_page_url = $loaderUrl."/?page=".$data->Paginate->first;
        $ret->last_page_url = $loaderUrl."/?page=".$data->Paginate->last;
        $ret->next_page_url = $loaderUrl."/?page=".$data->Paginate->next;
        $ret->prev_page_url = $loaderUrl."/?page=".$data->Paginate->previous;
        $ret->per_page = $data->Paginate->limit;
        $ret->total = $data->Paginate->total_items;

        return $ret;
    }
}
