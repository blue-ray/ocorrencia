<?php

return array(
    # definir e gerenciar controllers
    'controllers' => array(
        'invokables' => array(
            'AuthController' => 'Auth\Controller\AuthController'
        ),
    ),

    # definir e gerenciar rotas
    'router' => array(
        'routes' => array(
            'auth' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/auth',
                    'defaults' => array(
                        'module' => 'auth',
                        'controller' => 'AuthController',
                        'action' => 'index',
                    ),
                ),
            ),
            'login' => array(
                'type'      => 'Literal',
                'options'   => array(
                    'route'    => '/auth/login',
                    'defaults' => array(
                        'module' => 'auth',
                        'controller' => 'AuthController',
                        'action' => 'login',
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/auth/logout',
                    'defaults' => array(
                        'module' => 'auth',
                        'controller' => 'AuthController',
                        'action' => 'logout',
                    ),
                ),
            ),
        ),
    ),
    

    # definir e gerenciar servicos
    'service_manager' => array(
        'factories' => array(
            'Session' => function($sm) {
                return new Zend\Session\Container('ocorrencia');
            },
            'Auth\Service\Auth' => function($sm) {
                $dbAdapter = $sm->get('AdapterDb');
                return new Auth\Service\Auth($dbAdapter);
            },
        #'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),

    # definir e gerenciar layouts, erros, exceptions, doctype base
    'view_manager' => array(
        'display_not_found_reason'  => true,
        'display_exceptions'        => true,
        'doctype'                   => 'HTML5',
        'not_found_template'        => 'error/404',
        'exception_template'        => 'error/index',
        'template_map'              => array(
            'layout/auth'         => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'             => __DIR__ . '/../view/error/404.phtml',
            'error/index'           => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);