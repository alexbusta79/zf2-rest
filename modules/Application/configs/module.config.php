<?php
return array(
    'bootstrap_class' => 'Application\Bootstrap',
    'layout'          => 'layouts/layout.phtml',
    'di'              => array(
        'definition' => array(
            'class' => array(
                'Gists\Service\Api' => array(
                    'methods' => array(
                            '__construct' => array(
                                'em'   => array('type' => 'doctrine', 'required' => true),
                            )
                    )
                )
            ),
        ),
        'instance' => array(
            'alias' => array(
                'index' => 'Application\Controller\IndexController',
                'error' => 'Application\Controller\ErrorController',
                'view'  => 'Zend\View\PhpRenderer',
                'api'   => 'Gists\Service\Api',
            ),

            'Zend\View\HelperLoader' => array(
                'parameters' => array(
                    'map' => array(
                        'url' => 'Application\View\Helper\Url',
                    ),
                ),
            ),

            'Zend\View\HelperBroker' => array(
                'parameters' => array(
                    'loader' => 'Zend\View\HelperLoader',
                ),
            ),

            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'resolver' => 'Zend\View\TemplatePathStack',
                    'options'  => array(
                        'script_paths' => array(
                            'application' => __DIR__ . '/../views',
                        ),
                    ),
                    'broker' => 'Zend\View\HelperBroker',
                ),
            ),
            'doctrine' => array(
                'parameters' => array(
                    'conn' => array(
                        'driver'   => 'pdo_mysql',
                        'host'     => 'localhost',
                        'port'     => '3306',
                        'user'     => 'zf2gists',
                        'password' => 'zf2gists',
                        'dbname'   => 'zf2gists',
                    ),
                    'config' => array(
                        'auto_generate_proxies'     => true,
                        // @todo: figure out how to de_couple the Proxy dir
                        'proxy_dir'                 => realpath(__DIR__ . '/../../Gists/src/Gists/Proxy'),
                        'proxy_namespace'           => 'Gists\Proxy',
                        'metadata_driver_impl' => array(
                            // to add multiple drivers just follow the format below and give them a different keyed name
                            // cache_class is only required for annotation drivers
                            'application_annotation_driver' => array(
                                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                                'namespace' => 'Gists\Entity',
                                'paths' => array(realpath(__DIR__ . '/../../Gists/src/Gists/Entity')),
                                'cache_class' => 'Doctrine\Common\Cache\ArrayCache',
                            )
                        )
                    )
                ),
            ),
        ),
    ),

    'routes' => array(
        'default' => array(
            'type'    => 'Zend\Mvc\Router\Http\Regex',
            'options' => array(
                'regex'    => '/(?P<controller>[^/]+)(/(?P<action>[^/]+)?)?',
                'spec'     => '/%controller%/%action%',
                'defaults' => array(
                    'controller' => 'error',
                    'action'     => 'index',
                ),
            ),
        ),
        'home' => array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
                'route'    => '/',
                'defaults' => array(
                    'controller' => 'index',
                    'action'     => 'index',
                ),
            ),
        ),
    ),
);
