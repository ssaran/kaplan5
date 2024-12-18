<?php


namespace K5\Entity\Request;

class Headers
{
    public ?string $ApiPrefix = null;
    public ?string $IssuerPrefix = null;
    public ?string $Employer = null;
    public ?string $DomDestination = 'layout_content';
    public bool $IsAjax = false;
    public ?string $IsApi = null;
    public ?string $IsModal = null;
    public ?string $IsIframe = null;
    public ?string $IsData = null;
    public ?string $IsCommon = null;
    public ?string $IsComponent = null;
    public ?string $ActiveTabId = null;
}
