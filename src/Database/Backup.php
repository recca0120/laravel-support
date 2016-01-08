<?php

namespace Recca0120\Support\Database;

use Carbon\Carbon;
use Ifsnop\Mysqldump\Mysqldump;
use Illuminate\Contracts\Config\Repository as RepositoryContract;
use Illuminate\Database\Connection;
use Recca0120\Support\Filesystem\Fluent;

class Backup
{
    private $dsn;

    private $username;

    private $password;

    public function __construct(Connection $connection, RepositoryContract $config)
    {
        $dbconfig = $config->get('database.connections.'.$connection->getName());
        $this->dsn = static::parseDSN($dbconfig);
        $this->username = $dbconfig['username'];
        $this->password = $dbconfig['password'];
    }

    public function dump($directory, array $options = [])
    {
        $directory = rtrim($directory, '/').'/';
        $compress = array_get($options, 'compress', Mysqldump::GZIP);
        if (function_exists('gzopen') === false && $compress === Mysqldump::GZIP) {
            $compress = Mysqldump::NONE;
        }
        $filename = sprintf('sqldump-%s.sql', Carbon::now()->format('YmdHis'));

        switch ($compress) {
            case Mysqldump::GZIP:
                $filename .= '.gz';
                break;
            case Mysqldump::BZIP2:
                $filename .= '.bz2';
                break;
        }
        $dumpper = new Mysqldump($this->dsn, $this->username, $this->password, [
            'compress'           => $compress,
            'single-transaction' => false,
        ]);

        $dumpper->start($directory.$filename);

        return new Fluent($directory.$filename);
    }

    public static function parseDSN(array $params)
    {
        $driver = array_pull($params, 'driver');
        $database = array_pull($params, 'database');
        $params = array_merge([
                'dbname' => $database,
            ], array_except($params, [
                'username',
                'password',
                'collation',
                'prefix',
                'strict',
            ]));

        $data = [];
        foreach ($params as $key => $value) {
            $data[] = $key.'='.$value;
        }

        return $driver.':'.implode(';', $data);
    }
}
