<?php

use App\Controller\Locations\Locations;
use App\Controller\Users\Users;
use App\Controller\Customers\Customers;

//use App\Handlers\DataHandlers;

?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="feather icon-users"></i> Customer List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table data-tables nowrap table-striped table-bordered dataTables table-sm"
                           data-order="[[ 0, &quot;asc&quot; ]]">
                        <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Group</th>
                            <th>Location</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Bank</th>
                            <th>Account No:</th>
                            <th>Credit Limit</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (!empty($users)) {
                            $index = 0;
                            foreach ($users as $user) {
                                extract($user);
                                $index++;
                                $location = Locations::LocationName($customer_location);
                                if (empty($location)) $location = '-';
                                $group = Customers::CustomerGroupName($customer_group);
                                if (empty($group)) $group = '-';
                                ?>
                                <tr>
                                    <td><?php echo trim($first_name . ' ' . $last_name); ?></td>
                                    <td><?php echo $group; ?></td>
                                    <td><?php echo $location; ?></td>
                                    <td><?php echo $email_address; ?></td>
                                    <td><?php echo $phone_number; ?></td>
                                    <td><?php echo $bank_name; ?></td>
                                    <td><?php echo $account_number; ?></td>
                                    <td><?php echo $credit_limit; ?></td>
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