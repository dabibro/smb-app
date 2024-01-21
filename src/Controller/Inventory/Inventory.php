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

        Rendering::RenderContent(ADMIN_VIEWS, 'Inventory/inventory', $arg, DASHBOARD . '/inventory/category');
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
}
