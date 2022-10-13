<?php

/**
 * Setup application environment
 */
$dotenv = Dotenv\Dotenv::createImmutable(dirname(dirname(__DIR__)));
$dotenv->load();

defined('YII_DEBUG') or define('YII_DEBUG', getenv('YII_DEBUG') != null);
defined('YII_ENV') or define('YII_ENV', getenv('YII_ENV') ?: 'prod');