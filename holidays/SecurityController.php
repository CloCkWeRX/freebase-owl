<?php
class SecurityController {

    public $authenticated = false;

    public function __construct($user, $pass) {
        $this->user = $user;
        $this->pass = $pass;
    }

    public function authenticate($user, $pass) {
        return ($user == $this->user && $pass == $this->pass);
    }

    public function challenge($server) {
        if (!empty($server['PHP_AUTH_USER']) && $this->authenticate($server['PHP_AUTH_USER'], $server['PHP_AUTH_PW'])) {
            $this->authenticated = true;
            return true;
        }

        header('WWW-Authenticate: Basic realm="Administration facilities"');
        header('HTTP/1.0 401 Unauthorized');

        die("Not authorised to access this resource");
    }
}