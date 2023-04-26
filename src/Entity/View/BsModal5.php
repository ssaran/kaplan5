<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 12.01.2018
 * Time: 16:14
 */

namespace K5\Entity\View;


class BsModal5 extends DomElement
{
    public string $Type = 'modal5';
    public string $Mode = 'add';
    public bool $Refresh = false;
    public string $Modal_DomID;
    public string $Modal_Title = '';
    public string $Modal_Body = '';
    public string $Modal_Footer = '';
    public string $Modal_Size = 'medium';
    public string $Modal_Width = '';
    public string $Modal_Sidebar = '';
    public string $Modal_Callback = '';
    public int $Modal_Force = 0;
}
