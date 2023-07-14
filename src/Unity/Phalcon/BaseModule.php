<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 8.11.2018
 * Time: 13:16
 */

namespace K5\Unity\Phalcon;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Phalcon\Encryption\Security\Random;

//class BaseModule extends Plugin
class BaseModule
{
    public $Routes;
    public $Dom;
    public $Css;

    /** @var  \K5\Entity\Request\Setup */
    protected $setup;

    public function __construct(\K5\Entity\Request\Setup $setup)
    {
        $this->setup = $setup;
    }

    public function GetUuid()
    {
        $random = new Random();
        return $random->uuid();
    }

    /**
     * @param $post
     * @param $form
     * @param $model
     * @return mixed
     * @throws \Exception
     */
    public function CreateRecord($post,$form,$model)
    {
        try {

            $emsg = '';
            $form->bind($post,$model);

            if (!$form->isValid()) {
                throw new \Exception(implode("<br>",$this->ParseFormMessages($form->getMessages())));
            }

            if (!$model->create()) {
                throw new \Exception(implode("<br>",$this->ParseFormMessages($model->getMessages())));
            }

            return $model;
        } catch (\Exception $e) {
            \K5\U::lerr("Create Record Error");
            \K5\U::lerr($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param $post
     * @param $form
     * @param $model
     * @return mixed
     * @throws \Exception
     */
    public function UpdateRecord($post,$form,$model)
    {
        try {
            $form->bind($post,$model);
            if (!$form->isValid()) {
                throw new \Exception("<br>".\la::ng(\la::$keys->form_error)."<br>".implode("<br>",$this->ParseFormMessages($form->getMessages())));
            }

            if (!$model->save()) {
                throw new \Exception("<br>".\la::ng(\la::$keys->database_error)."<br>".implode("<br>",$this->ParseFormMessages($model->getMessages())));
            }

            return $model;
        } catch (\Exception $e) {
            \K5\U::lerr($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param $messages
     * @return array
     */
    public function ParseFormMessages($messages)
    {
        $r = [];
        foreach($messages as $m) {
            $r[] = $m->getMessage();
        }
        return $r;
    }

    /**
     * @param $data
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function Paginate($data,$page=1,$limit=10)
    {
        $paginator = new \Phalcon\Paginator\Adapter\Model([
            "data" => $data,
            "limit"=> $limit,
            "page" => $page
        ]);

        return $paginator->getPaginate();
    }
}
