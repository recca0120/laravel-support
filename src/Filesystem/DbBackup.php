<?php

namespace Recca0120\Support\Filesystem;

use Carbon\Carbon;
use DB;
use Ifsnop\Mysqldump\Mysqldump;

class DbBackup extends Collection
{
    public function save(array $options = [])
    {
        $config = config('database.connections.'.DB::getName());
        $dsn = static::parseDSN($config);
        $compress = Mysqldump::GZIP;
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
        $dumpper = new Mysqldump($dsn, $config['username'], $config['password'], [
            'compress'           => $compress,
            'single-transaction' => false,
        ]);
        $dumpper->start($this->getDirectory().$filename);

        return true;
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
