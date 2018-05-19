<?php

class Configs
{
    private static $configs = array(
        'database' => array(
            'host' => 'localhost',
            'user' => 'user',
            'password' => 'password',
        ),
    );

    public static function database($key = '')
    {
        if (empty($key)) {
            return self::$configs['database'];
        }

        if (!isset(self::$configs['database'][$key])) {
            return false;
        }

        return self::$configs['database'][$key];
    }
}

class Model
{
    protected $dbconn;

    public function __construct()
    {
        return $this->connect();
    }

    protected function connect()
    {
        $host = Configs::database('host');
        $user = Configs::database('user');
        $password = Configs::database('password');

        $this->dbconn = new DatabaseConnection($host, $user, $password);

        return $this->dbconn;
    }

    public function query($sql, $dbconn = '')
    {
        if (empty($dbconn)) {
            $dbconn = $this->dbconn;
        }

        return $dbconn->query($sql);
    }
}

class MyUserClass extends Model
{
    public function getUserList()
    {
        $results = $this->query('select name from user');

        sort($results);

        return $results;
    }
}
