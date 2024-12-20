<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 12.01.2018
 * Time: 16:14
 */

namespace K5\Entity\Html;

class Bs5Tab extends Component
{
    public string $Mode = 'add';
    public string $TabKey;
    public ?string $Title = null;
    public string $Body = '';
    public ?\K5\Entity\Config\BsModal5 $Config = null;

}
