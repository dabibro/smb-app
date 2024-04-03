<?php

namespace App\Controller\Inventory;

use App\Controller\Locations\Locations;
use App\DB\Command;
use App\Handlers\DataHandlers;
use App\Handlers\Rendering;
use App\Handlers\Responses;
use App\SMB\Auth;
use App\SMB\Client;
use App\Utility\Constants;
use App\Service\InventoryService;

abstract class inventory extends Command
{


    public function __construct()
    {
        parent::__construct();
    }

    static function CategoryView($edit = "")
    {
        $reference = strtoupper(DataHandlers::generate_random_string(6));
        $cmd = new Command();
        $inventoryService = new InventoryService();
        $arg = [
            'datatable' => 1,
            'locations' => Locations::Locations(),
            'categories' => $inventoryService->getAllProductCategory(["companyId" => $_SESSION[$cmd->companyId]]),
            'reference' => $reference
        ];
        if (!empty($edit)) {
            $category = $inventoryService->getAllProductCategory([
                "companyId" => $_SESSION[$cmd->companyId],
                "id" => $edit
            ])[0];
            if (!empty($category))
                $category = DataHandlers::convertObj($category);
            $arg['reference'] = $category->reference;
            $arg['edit'] = $category;

        }
        Rendering::RenderContent(ADMIN_VIEWS, 'Inventory/category', $arg, DASHBOARD . '/inventory/category');
        exit();
    }

    static function PostCategory()
    {
        $cmd = new Command();
        $auth = new Auth();
        extract($_POST);
        $params = [
            'created_by' => $auth->AuthName(),
        ];
        $params += $_POST;
        $params['companyId'] = $_SESSION[$cmd->companyId];
        unset($params['Path']);

        $inventoryService = new InventoryService();
        if (empty($params['pk'])) {
            $submit = $inventoryService->createProductCategory($params);
        } else {
            $submit = $inventoryService->updateProductCategory($params);
        }
        if ($submit['response'] !== '200') {
            die(Responses::displayResponse($submit));
        }
        echo '<div class="alert alert-success"> Record successfully saved!</div>';
        die('<script>location.reload()</script>');
    }

    static function DeleteCategory()
    {

        $cmd = new Command();
        $pk = base64_decode($_POST['pk']);
        $inventoryService = new InventoryService();
        $deleteRequest = $inventoryService->updateProductCategory(
            [
                'pkField' => 'id',
                'delete_status' => 1,
                'pk' => $pk,
                'companyId' => $_SESSION[$cmd->companyId]
            ]
        );
        if ($deleteRequest['response'] !== '200')
            die(Responses::displayResponse($deleteRequest));
        echo '<div class="alert alert-success"> Record successfully deleted!</div>';
        die('<script>location.reload()</script>');
    }

    static function StorageView($edit = "")
    {
        echo 'heeere';
        $reference = strtoupper(DataHandlers::generate_random_string(6));
        $cmd = new Command();
        $inventoryService = new InventoryService();
        $arg = [
            'datatable' => 1,
            'locations' => Locations::Locations(),
            'storages' => $inventoryService->getAllStorage(["companyId" => $_SESSION[$cmd->companyId]]),
            'reference' => $reference
        ];
        if (!empty($edit)) {
            $storage = $inventoryService->getAllStorage([
                "companyId" => $_SESSION[$cmd->companyId],
                "id" => $edit
            ])[0];
            if (!empty($storage))
                $storage = DataHandlers::convertObj($storage);
            $arg['reference'] = $storage->reference;
            $arg['edit'] = $storage;

        }
        Rendering::RenderContent(ADMIN_VIEWS, 'Inventory/storage', $arg, DASHBOARD . '/inventory/storage');
      exit();
    }

    static function PostStorage()
    {
        $cmd = new Command();
        $auth = new Auth();
        extract($_POST);
        $params = [
            'created_by' => $auth->AuthName(),
        ];
        $params += $_POST;
        $params['companyId'] = $_SESSION[$cmd->companyId];
        unset($params['Path']);

        $inventoryService = new InventoryService();
        if (empty($params['pk'])) {
            $submit = $inventoryService->createStorage($params);
        } else {
            $submit = $inventoryService->updateStorage($params);
        }
        if ($submit['response'] !== '200') {
            die(Responses::displayResponse($submit));
        }
        echo '<div class="alert alert-success"> Record successfully saved!</div>';
        die('<script>location.reload()</script>');
    }

    static function DeleteStorage()
    {

        $cmd = new Command();
        $pk = base64_decode($_POST['pk']);
        $inventoryService = new InventoryService();
        $deleteRequest = $inventoryService->updateStorage(
            [
                'pkField' => 'id',
                'delete_status' => 1,
                'pk' => $pk,
                'companyId' => $_SESSION[$cmd->companyId]
            ]
        );
        if ($deleteRequest['response'] !== '200')
            die(Responses::displayResponse($deleteRequest));
        echo '<div class="alert alert-success"> Record successfully deleted!</div>';
        die('<script>location.reload()</script>');
    }

    
    static function UnitView($edit = "")
    {
        $reference = strtoupper(DataHandlers::generate_random_string(6));
        $cmd = new Command();
        $inventoryService = new InventoryService();
        $arg = [
            'datatable' => 1,
            'locations' => Locations::Locations(),
            'units' => $inventoryService->getAllUnit(["companyId" => $_SESSION[$cmd->companyId]]),
            'reference' => $reference
        ];
        if (!empty($edit)) {
            $unit = $inventoryService->getAllUnit([
                "companyId" => $_SESSION[$cmd->companyId],
                "id" => $edit
            ])[0];
            if (!empty($unit))
                $unit = DataHandlers::convertObj($unit);
            $arg['reference'] = $unit->reference;
            $arg['edit'] = $unit;

        }
        Rendering::RenderContent(ADMIN_VIEWS, 'Inventory/measurementunit', $arg, DASHBOARD . '/inventory/measurementunit');
      exit();
    }

    static function PostUnit()
    {
        $cmd = new Command();
        $auth = new Auth();
        extract($_POST);
        $params = [
            'created_by' => $auth->AuthName(),
        ];
        $params += $_POST;
        $params['companyId'] = $_SESSION[$cmd->companyId];
        unset($params['Path']);

        $inventoryService = new InventoryService();
        if (empty($params['pk'])) {
            $submit = $inventoryService->createUnit($params);
        } else {
            $submit = $inventoryService->updateUnit($params);
        }
        if ($submit['response'] !== '200') {
            die(Responses::displayResponse($submit));
        }
        echo '<div class="alert alert-success"> Record successfully saved!</div>';
        die('<script>location.reload()</script>');
    }

    static function DeleteUnit()
    {

        $cmd = new Command();
        $pk = base64_decode($_POST['pk']);
        $inventoryService = new InventoryService();
        $deleteRequest = $inventoryService->updateUnit(
            [
                'pkField' => 'id',
                'delete_status' => 1,
                'pk' => $pk,
                'companyId' => $_SESSION[$cmd->companyId]
            ]
        );
        if ($deleteRequest['response'] !== '200')
            die(Responses::displayResponse($deleteRequest));
        echo '<div class="alert alert-success"> Record successfully deleted!</div>';
        die('<script>location.reload()</script>');
    }

    static function ProductView($edit = "")
    {
        $reference = strtoupper(DataHandlers::generate_random_string(6));
        $cmd = new Command();
        $inventoryService = new InventoryService();
        $arg = [
            'datatable' => 1,
            'locations' => Locations::Locations(),
            'categories' => $inventoryService->getAllProductCategory(["companyId" => $_SESSION[$cmd->companyId]]),
            'storages' => $inventoryService->getAllStorage(["companyId" => $_SESSION[$cmd->companyId]]),
            'productType' => Constants::ProductType(),
            'reference' => $reference
        ];
        if (!empty($edit)) {
            $product = $inventoryService->getAllInventory([
                "companyId" => $_SESSION[$cmd->companyId],
                "id" => $edit
            ])[0];
            if (!empty($product))
                $product = DataHandlers::convertObj($product);
            $arg['reference'] = $product->product_id;
            $arg['edit'] = $product;

        }

        Rendering::RenderContent(ADMIN_VIEWS, 'Inventory/product', $arg, DASHBOARD . '/inventory/product');
        exit();
    }

    static function PostProduct()
    {
        $cmd = new Command();
        $auth = new Auth();
        extract($_POST);
        $params = [
            'created_by' => $auth->AuthName(),
        ];
        $params += $_POST;
        $params['companyId'] = $_SESSION[$cmd->companyId];
        unset($params['Path']);

        print_r($params);
        $inventoryService = new InventoryService();
        if (empty($params['pk'])) {
            $submit = $inventoryService->createInventory($params);
        } else {
            $submit = $inventoryService->updateInvenotry($params);
        }
        if ($submit['response'] !== '200') {
            die(Responses::displayResponse($submit));
        }
        echo '<div class="alert alert-success"> Record successfully saved!</div>';
        die('<script>location.reload()</script>');
    }

    static function DeleteProduct()
    {

        $cmd = new Command();
        $pk = base64_decode($_POST['pk']);
        $inventoryService = new InventoryService();
        $deleteRequest = $inventoryService->updateInvenotry(
            [
                'pkField' => 'id',
                'delete_status' => 1,
                'pk' => $pk,
                'companyId' => $_SESSION[$cmd->companyId]
            ]
        );
        if ($deleteRequest['response'] !== '200')
            die(Responses::displayResponse($deleteRequest));
        echo '<div class="alert alert-success"> Record successfully deleted!</div>';
        die('<script>location.reload()</script>');
    }

    static function ProductListView($edit = "")
    {

       
        $cmd = new Command();
        $inventoryService = new InventoryService();
            $arg = [
                'datatable' => 1,
                'locations' => Locations::Locations(),
                'products' => $inventoryService->getAllInventory( [
                    
                    'companyId' => $_SESSION[$cmd->companyId]
                ])
            ];
            Rendering::RenderContent(ADMIN_VIEWS, 'Inventory/list', $arg);
            exit();
    }
}
