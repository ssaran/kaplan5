<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 12.01.2018
 * Time: 16:14
 */

namespace K5\Entity\Html;

class BsModal5 extends Component
{
    public string $Type = 'modal5';
    public string $Mode = 'add';
    public int $Modal_Force = 0;
    public string $Modal_DomID;
    public ?string $Modal_Title = '';
    public string $Modal_Body = '';
    public ?string $Modal_Footer = '';
    public string $Modal_Size = 'medium';
    public string $Modal_Close = 'right';
    public ?\K5\Entity\Config\BsModal5 $Config = null;

}
