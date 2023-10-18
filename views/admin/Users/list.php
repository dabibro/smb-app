<?php

use App\Controller\Locations\Locations;
use App\Controller\Users\Users;

//use App\Handlers\DataHandlers;

?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="feather icon-users"></i> User List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table data-tables nowrap table-striped table-bordered dataTables table-sm"
                           data-order="[[ 0, &quot;asc&quot; ]]">
                        <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Location</th>
                            <th>Username</th>
                            <th>User Group</th>
                            <th>Account Type</th>
                            <th>Last Login</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (!empty($users)) {
                            $index = 0;
                            foreach ($users as $user) {
                                extract($user);
                                $index++;
                                $location = Locations::LocationName($location);
                                if (empty($location)) $location = '-';
                                $group = Users::UserGroupName($u_group);
                                if (empty($group)) $group = '-';
                                ?>
                                <tr>
                                    <td><?php echo trim($first_name . ' ' . $last_name); ?></td>
                                    <td><?php echo $location; ?></td>
                                    <td><?php echo $username; ?></td>
                                    <td><?php echo $group; ?></td>
                                    <td><?php echo Users::AccountTypes($type, 1); ?></td>
                                    <td><?php echo $last_login; ?></td>
                                    <td class="table-actions">
                                        <button type="button" class="btn"
                                                onclick="location.replace('<?php echo $path . '/permission/' . ($id); ?>');"
                                                title="Permissions" data-toggle="tooltip">
                                            <i class="feather icon-sliders"></i>
                                        </button>
                                        <button type="button"><i class="feather icon-toggle-left"></i></button>
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