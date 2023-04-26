<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 15.01.2018
 * Time: 11:05
 */

namespace K5\Entity\Notify;


class Settings
{
    public $Element = 'body';
    public $Position = '';
    public $Type = 'info';
    public $AllowDismiss = 'true';
    public $NewestOnTop = false;
    public $ShowProgressBar = false;
    public $Placement;
    public $Offset = 20;

    public $Spacing = 10;
    public $ZIndex = 1031;
    public $Delay = 5000;
    public $Timer = 1000;
    public $UrlTarget = '_blank';
    public $MouseOver = null;
    public $Animate;
    public $OnShow = null;
    public $OnShown = null;
    public $OnClose = null;
    public $OnClosed = null;
    public $IconType = null;
    public $Template = '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">'.
'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>'.
'<span data-notify="icon"></span> '.
'<span data-notify="title">{1}</span> '.
'<span data-notify="message">{2}</span>'.
'<div class="progress" data-notify="progressbar">'.
'<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>'.
'</div>'.
'<a href="{3}" target="{4}" data-notify="url"></a>'.
'</div>';
}