<?php
namespace Config;

use CodeIgniter\Database\Config;

class Database extends Config
{
    public string $filesPath;
    public string $defaultGroup;
    public array $default;
    public array $tests;

    public function __construct()
    {
        parent::__construct();

        $this->filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

        $this->defaultGroup = 'default';

        $this->default = [
            'DSN'      => '',
            'hostname' => env('database.default.hostname', 'db'),
            'username' => env('database.default.username', 'ci4_user'),
            'password' => env('database.default.password', 'ci4_pass'),
            'database' => env('database.default.database', 'ci4_db'),
            'DBDriver' => env('database.default.DBDriver', 'MySQLi'),
            'DBPrefix' => '',
            'pConnect' => false,
            'DBDebug'  => (ENVIRONMENT !== 'production'),
            'charset'  => 'utf8mb4',
            'DBCollat' => 'utf8mb4_general_ci',
            'swapPre'  => '',
            'encrypt'  => false,
            'compress' => false,
            'strictOn' => true,
            'failover' => [],
            'port'     => (int) env('database.default.port', 3306),
        ];

        $this->tests = [
            'DSN'      => '',
            'hostname' => env('database.default.hostname', 'db'),
            'username' => env('database.default.username', 'ci4_user'),
            'password' => env('database.default.password', 'ci4_pass'),
            'database' => env('database.default.database', 'ci4_db'),
            'DBDriver' => env('database.default.DBDriver', 'MySQLi'),
            'DBPrefix' => '',
            'pConnect' => false,
            'DBDebug'  => (ENVIRONMENT !== 'production'),
            'charset'  => 'utf8mb4',
            'DBCollat' => 'utf8mb4_general_ci',
            'swapPre'  => '',
            'encrypt'  => false,
            'compress' => false,
            'strictOn' => true,
            'failover' => [],
            'port'     => (int) env('database.default.port', 3306),
        ];

        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}
