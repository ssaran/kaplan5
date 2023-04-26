<?php

namespace K5\Modules\Micro\Model;

class Domains extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     */
    public $domain_name;

    /**
     *
     * @var string
     */
    public $account_id;

    /**
     *
     * @var int
     */
    public $is_active;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setConnectionService('db');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'domains';
    }

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return array(
            'domain_name' => 'domain_name',
            'account_id' => 'account_id',
            'is_active' => 'is_active'
        );
    }


}
