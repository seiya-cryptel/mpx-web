<?php

// 2018/10/14 apply Phalcon3

error_reporting(E_ALL);

use Phalcon\Mvc\Application;
use Phalcon\Config\Adapter\Ini as ConfigIni;

try {
    define('APP_PATH', realpath('..') . '/');

    /**
     * Read the configuration
     */
    $config = new ConfigIni(APP_PATH . 'app/config/config.ini');
    if (is_readable(APP_PATH . 'app/config/config.ini.dev')) {
        $override = new ConfigIni(APP_PATH . 'app/config/config.ini.dev');
        $config->merge($override);
    }

    /**
     * Auto-loader configuration
     */
    require APP_PATH . 'app/config/loader.php';

    $application = new Application(new Services($config));

    // NGINX - PHP-FPM already set PATH_INFO variable to handle route
    // var_dump($_SERVER);    exit(0);
    echo $application->handle(!empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : null)->getContent();
} catch (Exception $e) {
    echo $e->getMessage();
    // error detail
    echo '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}