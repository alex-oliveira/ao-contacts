<?php

namespace AoContacts\Utils;

use AoScrud\Utils\Traits\Build;
use AoTools\Router as BaseRouter;

class Router extends BaseRouter
{

    use Build;

    protected $configs = [
        'prefix' => 'contacts',
        'as' => 'contacts.',
    ];

    protected $routes = [
        ['method' => 'get',     'url' => '/',                                 'configs' => ['as' => 'index',      'uses' => '@index']],
        ['method' => 'get',     'url' => '/{id}',                             'configs' => ['as' => 'show',       'uses' => '@show']],
        ['method' => 'post',    'url' => '/',                                 'configs' => ['as' => 'store',      'uses' => '@store']],
        ['method' => 'put',     'url' => '/{id}',                             'configs' => ['as' => 'update',     'uses' => '@update']],
        ['method' => 'put',     'url' => '/{id}/restore',                     'configs' => ['as' => 'restore',    'uses' => '@restore']],
        ['method' => 'delete',  'url' => '/{id}',                             'configs' => ['as' => 'destroy',    'uses' => '@destroy']],

        ['method' => 'post',    'url' => '/{contact_id}/phones/',             'configs' => ['as' => 'phones.store',      'uses' => '@storePhone']],
        ['method' => 'put',     'url' => '/{contact_id}/phones/{id}',         'configs' => ['as' => 'phones.update',     'uses' => '@updatePhone']],
        ['method' => 'delete',  'url' => '/{contact_id}/phones/{id}',         'configs' => ['as' => 'phones.destroy',    'uses' => '@destroyPhone']],

        ['method' => 'post',    'url' => '/{contact_id}/emails/',             'configs' => ['as' => 'emails.store',      'uses' => '@storeEmail']],
        ['method' => 'put',     'url' => '/{contact_id}/emails/{id}',         'configs' => ['as' => 'emails.update',     'uses' => '@updateEmail']],
        ['method' => 'delete',  'url' => '/{contact_id}/emails/{id}',         'configs' => ['as' => 'emails.destroy',    'uses' => '@destroyEmail']],
    ];

    public function foreign($foreign)
    {
        $this->configs['prefix'] = '{' . $foreign . '}/contacts';
        return $this;
    }

    public function controller($controller)
    {
        $actions = ['index', 'show', 'store', 'update', 'restore', 'destroy', 'storePhone', 'updatePhone', 'destroyPhone', 'storeEmail', 'updateEmail', 'destroyEmail'];

        foreach ($actions as $key => $action)
            $this->routes[$key]['configs']['uses'] = $controller . '@' . $action;

        return $this;
    }

}