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
    public $companyId;
    public $currency;
    protected $config;
    protected $locations;
    protected $users_group;
    protected $users;
    protected $users_sessions;
    protected $customers;
    protected $customers_group;
    protected $suppliers;
    protected $suppliers_group;
    protected $department;
    protected $productCategories;
    protected $storages;
    protected $units;
    protected $inventory;


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
        $this->customers_group = 'customers_group';
        $this->companyId = 'companyId';
        $this->suppliers = 'suppliers';
        $this->suppliers_group = 'suppliers_group';
        $this->department = 'departments';
        $this->productCategories = 'product_categories';
        $this->storages = 'storages';
        $this->units = 'measurement_units';
        $this->currency = 'currency';
        $this->inventory = 'inventory';

    }
}