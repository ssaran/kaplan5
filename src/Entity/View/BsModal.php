<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 12.01.2018
 * Time: 16:14
 */

namespace K5\Entity\View;


class BsModal extends Element
{
    public string $Type = 'modal';
    public string $Mode = 'add';
    public bool $Refresh = false;
    public ?string $Modal_DomID;
    public ?string $Modal_Title;
    public ?string $Modal_Body = '';
    public ?string $Modal_Footer;
    public string $Modal_Size = 'medium';
    public ?string $Modal_Width = null;
    public ?string $Modal_Sidebar = null;
    public ?string $Modal_Callback = null;
    public ?string  $Modal_Force = '0';
}
