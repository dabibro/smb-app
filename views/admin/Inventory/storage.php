<?php

use App\Controller\Locations\Locations;
use App\Handlers\DataHandlers;

?>
<div class="row">
    <div class="col-md-4">
        <div class="card box-shadow-1">
            <div class="card-header pb-3">
                <h5 class="card-title"><i class="feather icon-edit mr-1"></i> Add Storage</h5>
            </div>
            <form class="app-form" action="<?php echo $path; ?>" method="post" id="productCategory">
                <div class="card-body">
                    <div id="form-response"></div>
                    <input type="hidden" id="form-id" value="user-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label for=""><span class="required">*</span> Reference</label>
                                <input type="text" name="reference" class="form-control" required
                                       placeholder="Reference" value="<?php echo @$reference; ?>">
                                <div class="invalid-feedback">* This is a required field.</div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label for=""><span class="required">*</span> Location</label>
                                <select name="location" class="form-control select2"
                                        required tabindex="1">
                                    <option value="">-- Select --</option>
                                    <?php DataHandlers::DropDownList($locations, 'reference', 'location_name', @$edit->location) ?>
                                </select>
                                <div class="invalid-feedback">* This is a required field.</div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for=""><span class="required">*</span> Name</label>
                                <input type="text" name="name" class="form-control" required
                                       placeholder="Name"
                                       value="<?php echo @$edit->name; ?>">
                                <div class="invalid-feedback">* This is a required field.</div>
                            </div>
                        </div>
                        <div class="col-md-12">
                        <div class="form-group">
                        <label for=""> Parent</label>
                                <select name="parent" class="form-control select2"
                                        tabindex="1">
                                    <option value="">-- Select --</option>
                                    <?php DataHandlers::DropDownList($storages, 'reference', 'name', @$edit->parent) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="Path" value="<?php echo $path; ?>">
                    <hr>
                    <?php if (!empty($edit->id)) { ?>
                        <input type="hidden" name="pk" value="<?php echo $edit->id; ?>">
                        <input type="hidden" name="pkField" value="id">
                        <a class="btn btn-danger" href="javascript:;"
                           onclick="location.replace('<?php echo $path; ?>')"><i class="feather icon-x"></i> Cancel </a>
                    <?php } ?>
                    <button class="btn btn-primary form-button"><i class="feather icon-save"></i> Save Record
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="table-responsive">
            <table class="table data-tables nowrap table-striped table-bordered dataTables table-sm"
                   data-order="[[ 2, &quot;asc&quot; ]]">
                <thead>
                <tr>
                    <th data-orderable="false">#</th>
                    <th nowrap>Reference</th>
                    <th nowrap>Name</th>
                    <th nowrap>Location</th>
                    <th>Created By</th>
                    <th data-orderable="false"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($storages)) {
                    $index = 0;
                    foreach ($storages as $store) {
                        extract($store);
                        $index++;
                        $location = Locations::LocationName($location);
                        ?>
                        <tr>
                            <td style="width: 1%"><?php echo $index; ?></td>
                            <td style="width: 2%"><?php echo $reference; ?></td>
                            <td><?php echo $name; ?></td>
                            <td nowrap><?php echo $location; ?></td>
                            <td><?php echo $created_by . '<div class="small">' . $created_on . '</div>'; ?></td>
                            <td class="table-actions text-right">
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
                        <?php
                    }
                } ?>
                </tbody>
            </table>
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