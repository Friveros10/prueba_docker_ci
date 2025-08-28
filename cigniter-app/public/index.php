<?php

// Check PHP version
$minPhpVersion = '7.4';
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    exit(sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION
    ));
}

define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
chdir(FCPATH);

require FCPATH . '/app/Config/Paths.php';
$paths = new Config\Paths();

// Carga .env antes de bootstrap
require_once rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

// Carga bootstrap
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();
$context = is_cli() ? 'php-cli' : 'web';
$app->setContext($context);

$app->run();
