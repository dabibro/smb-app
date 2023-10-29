<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 13/10/2023
 * Time: 12:16 AM
 */

namespace App\DB;


class DBTables
{
    protected $config;
    protected $locations;
    protected $users_group;
    protected $users;
    protected $users_sessions;
    protected $customers;

    protected $logger;

    public function __construct()
    {
        $this->config = 'config';
        $this->locations = 'locations';
        $this->users_group = 'users_group';
        $this->users = 'users';
        $this->logger = 'logger';
        $this->users_sessions = 'users_sessions';
        $this->customers = 'customers';

    }
}