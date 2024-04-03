<?php

use App\Controller\Locations\Locations;

?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="feather icon-users"></i> Inventory List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table data-tables nowrap table-striped table-bordered dataTables table-sm"
                           data-order="[[ 0, &quot;asc&quot; ]]">
                        <thead>
                        <tr>
                        <th>#</th>
                            <th>ID/BARCODE</th>
                            <th>CATEGORY</th>
                            <th>NAME</th>
                            <th>LOCATION</th>
                            <th>QUANTITY</th>
                            <th>UNIT PRICE</th>
                            <th>SALE PRICE</th>
                            <th>WHOLESALE PRICE</th>
                            <th>DISCOUNT</th>
                            <th>EXPIRY</th>
                            <th><i class="fal fa-cogs"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (!empty($products)) {
                            $index = 0;
                            foreach ($products as $product) {
                                extract($product);
                                $index++;
                                $location = Locations::LocationName($location);
                                if (empty($location)) $location = '-';
                                ?>
                                <tr>
                                <td><?php echo $index; ?></td>
                                    <td><?php echo $product_id; ?></td>
                                    <td><?php echo $category; ?></td>
                                    <td><?php echo $product_name; ?></td>
                                    <td><?php echo $location; ?></td>
                                    <td><?php echo $quantity; ?></td>
                                    <td><?php echo $unit_price; ?></td>
                                    <td><?php echo $sale_price; ?></td>
                                    <td><?php echo $wholesale_price; ?></td>
                                    <td><?php echo $discount; ?></td>
                                    <td><?php echo $expiry_date; ?></td>
                                    <td class="table-actions">
                                        
                                        
                                        <button type="button" class="btn"
                                                title="Edit Record" data-toggle="tooltip"
                                                onClick="location.replace('<?php echo $path . '/edit/' . ($id); ?>')">
                                            <i class="feather icon-edit-1"></i></button>
                                        <button type="button" class="btn"
                                                data-toggle="tooltip" title="Delete Record"
                                                onClick="deleteRequest('<?php echo base64_encode($id); ?>')">
                                            <i class="feather icon-trash"></i></button>
                                    </td>
                                </tr>
                            <?php }
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteRequest(id) {
        var obj = {
            action: '<?php echo $path;?>/delete',
            message: 'Are you sure to delete record?',
            callback: '<?php echo $path;?>',
            row_id: id,
        }
        DeleteWarning(obj);
    }
</script>