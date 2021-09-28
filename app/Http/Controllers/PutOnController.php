<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PutOn;
use App\Repositories\PutOnRepository;
use App\Services\PutOnServices;
use App\Traits\General;

class PutOnController extends Controller
{
    use General;

    protected $service_name = 'put-on';

    protected $model, $repository, $services;

    public function __construct(PutOn $model, PutOnRepository $repository, PutOnServices $services)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }

    public function execute_sql($file, $DB, $database)
    {
        //1st method; directly via mysql
        $mysql_paths = array();

        //use mysql location from which command.
        $mysql = trim(`which mysql`);

        if (is_executable($mysql)) {
            array_unshift($mysql_paths, $mysql);
        }

        //Default paths
        $mysql_paths[] = '/Applications/MAMP/Library/bin/mysql';  //Mac Mamp
        $mysql_paths[] = 'c:\xampp\mysql\bin\mysql.exe';//XAMPP

        $mysql_paths[] = '/usr/bin/mysql';  //Linux
        $mysql_paths[] = '/usr/local/mysql/bin/mysql'; //Mac
        $mysql_paths[] = '/usr/local/bin/mysql'; //Linux
        $mysql_paths[] = '/usr/mysql/bin/mysql'; //Linux

        $database = escapeshellarg($database);
        $db_hostname = escapeshellarg($DB["HostName"]);
        $db_username = escapeshellarg($DB["UserName"]);
        $db_password = escapeshellarg($DB["Password"]);
        $file_to_execute = escapeshellarg($file);
        foreach ($mysql_paths as $mysql) {
            if (is_executable($mysql)) {
                $execute_command = "\"$mysql\" --host=$db_hostname --user=$db_username --password=$db_password $database < $file_to_execute";
                $status = false;
                system($execute_command, $status);
                return $status;
            }
        }

    }
}
