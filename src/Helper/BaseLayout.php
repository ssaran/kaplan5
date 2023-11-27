<?php

namespace K5\Helper;

class BaseLayout
{
    /**
     * @return string
     */
    public function Render($content) :string
    {
        $header = isset($content['layout_header']) ? implode("\n",$content['layout_header']) : '';
        $subHeader = isset($content['layout_subHeader']) ? implode("\n",$content['layout_subHeader']) : '';
        $main = isset($content['layout_content']) ? implode("\n",$content['layout_content']) : '';
        $left = isset($content['layout_left']) ? implode("\n",$content['layout_left']) : '';
        $right = isset($content['layout_right']) ? implode("\n",$content['layout_right']) : '';
        $footer = isset($content['layout_footer']) ? implode("\n",$content['layout_footer']) : '';

        return
'<div class="page"><!--lbase-->
    <div class="sticky-top d-print-none" id="layout_header">
            '.$header.'                
    </div>
    <div class="page-wrapper">
        <div class="page-header d-print-none text-white">
            <subheader id="layout_subHeader">
                '.$subHeader.'
            </subheader>            
        </div>      
        <div class="page-body p-0 m-0">
            <div class="container p-0 m-0" id="layout_content">
    '.$main.'
            </div>
            <div class="container p-0 m-0" id="layout_left">
    '.$left.'
            </div>
            <div class="container p-0 m-0" id="layout_right">
    '.$right.'
            </div>
        </div>
        <footer id="layout_footer" class="footer footer-transparent d-print-none p-0 m-0" >
            '.$footer.'
        </footer>
    </div>
</div>
';
    }
}