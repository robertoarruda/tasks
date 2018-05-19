<?php

$login = new Login($_SESSION, $_COOKIE);

if ($login->check()) {
    header("Location: http://www.google.com");
    exit();
}

class Login
{
    private $session;
    private $cookie;

    public function __construct($session = array(), $cookie = array())
    {
        $this->session = $session;
        $this->cookie = $cookie;
    }

    public function check()
    {
        if (!empty($this->session['loggedin'])) {
            return true;
        }

        return (!empty($this->cookie['Loggedin']));
    }
}
