<?php

namespace soovorow\letter_ape;

/**
 * Letter ape module
 *
 * Add following code into your `config\main.php` for start using it
 *
 * 'modules' => [
 *     'letter_ape' => [
 *         'class' => 'soovorow\letter_ape\Module',
 *     ],
 * ],
 *
 * Add followeing rules into url manager
 *
 * [
 *     'pattern' => '/letter_ape/track-open/<key>',
 *     'route' => '/letter_ape/action/track-open'
 * ],
 *
 * @author Dmitry Suvorov <soovorow@gmail.com>
 *
 */
class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();
    }
}