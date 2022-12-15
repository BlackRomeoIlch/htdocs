<?php
/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Layouts\Ilch2Professional\Config;

class Config extends \Ilch\Config\Install
{
    public $config = [
        'name' => 'Ilch-Professional',
        'version' => '1.0.0',
        'ilchCore' => '2.1.44',
        'author' => 'BlackRomeo',
        'link' => 'http://ilch.de',
        'desc' => 'Professional Layout',
        'layouts' => [
            'index_full' => [
                ['module' => 'user', 'controller' => 'panel'],
                ['module' => 'forum'],
                ['module' => 'guestbook'],
            ]//only for example
        ],
        //'modulekey' => 'Name of Module'
    ];

    public function getUpdate($installedVersion)
    {
    }
}
