<?php

use App\DB\Queries;
use App\Handlers\Pagination;

$db = new Queries();
//$cmd = new Command();

$condition = "";

@$pages = new Pagination();
@$pages->default_ipp = 25;
@$sql_forms = $db->query("SELECT id FROM " . $db->logger . " WHERE 1 " . $condition . " ")['dataArray'];
$pages->items_total = $sql_forms->num_rows;
$pages->mid_range = 5;
$pages->paginate();
echo $sql = "SELECT * FROM " . $db->logger . "  WHERE 1  " . $condition . " ORDER BY event_time DESC, user ASC " . $pages->limit . " ";
//------------------------------------------------------------------------------------------------------
$records = $db->getArray($sql);
//------------------------------------------------------------------------------------------------------
?>
    <div class="row mb-3 pb-2 border-bottom">
        <div class="col-auto ml-auto pr-0">
            <div class="">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="collapse"
                        aria-expanded="false" data-target="#filter-collapse" aria-controls="filter-collapse">
                    <i class="feather icon-search"></i> <span class="hide-text">Apply Filter</span>
                </button>
                <div class="collapse mt-1" aria-labelledby="dLabel" id="filter-collapse"
                     style="z-index: 1 !important; position: absolute; width: 450px; right: .6rem">
                    <div class="card">
                        <div class="card-body">
                            <form class="m-0">
                                <input type="hidden" name="p" value="<?php echo $request; ?>">
                                <input type="hidden" name="v" value="<?php echo $view; ?>">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-2">
                                            <label for="">User Account</label>
                                            <select name="user_id" class=" form-control form-control-sm  select2"
                                                    style="width: 100%">
                                                <option value="">-- Select --</option>
                                                <?php
                                                //$users = $cmd->getRecord(['tbl_scheme' => $cmd->tbl_users])['dataArray'];
                                                foreach ($users as $user):
                                                    echo $cmd->dropDownList($user['id'], $user['firstname'] . ' ' . $user['lastname']);
                                                endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group mb-0">
                                            <label for="">Start Date</label>
                                            <input type="text" class="form-control form-control-sm datepicker "
                                                   name="start_date"
                                                   id="start_date" placeholder="Start Date" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mb-0" id="stp">
                                            <label for="">Stop Date</label>
                                            <input type="text" class="form-control form-control-sm datepicker "
                                                   name="stop_date"
                                                   id="stop_date"
                                                   placeholder="Stop Date" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-3">
                                <button class="btn btn-primary btn-block" type="submit"> Apply
                                    Filter <i class="fal fa-angle-double-right"></i>
                                </button>
                                <input type="hidden" name="filter" value="1">
                            </form>
                        </div>
                    </div>
                </div>
                <?php if (!empty($records)): ?>
                    <button class="btn btn-primary" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="feather icon-more-vertical m-0"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <?php //if (!empty($delete_user_log)): ?>
                        <a href="javascript:;" class="dropdown-item"
                           onclick="TablePostRequest('Are you sure to delete selections?','log-list');">
                            <i class="fal fa-trash-alt mr-2"></i> Delete Selection</a>
                        <?php //endif; ?>
                    </div>
                    <input type="hidden" id="table-action" name="actions" form="log-list">
                <?php endif; ?>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php if ($pages->items_total > 0) { ?>
                <?php echo $pages->display_pages(); ?>
                <?php echo $pages->display_items_per_page().'</div>'; ?>
                <?php //echo $pages->display_jump_menu(); ?>
            <?php } ?>
        </div>
    </div>
    <div class="table-responsive datatable-buttons">
        <form method="post" id="log-list" novalidate>
            <table class="table data-tables nowrap table-striped table-bordered dynamic-datatable table-sm"
                   data-order="[[ 1, &quot;asc&quot; ]]">
                <?php if (!empty($filter)): ?>
                    <caption>Displaying filtered record
                        [<a href="javascript:;" onclick="location.replace('<?php echo $path; ?>')">
                            Reset Filter</a>]
                    </caption>
                <?php endif; ?>
                <thead>
                <tr>
                    <th data-orderable="false">
                        <label for="log-list" class="m-0">
                            <input type="checkbox" class="toggle-checkbox pointer" id="log-list" readonly>
                        </label>
                    </th>
                    <th nowrap>Date/Time</th>
                    <th nowrap>Full Name</th>
                    <th>Username</th>
                    <th nowrap>IP</th>
                    <th nowrap>Host</th>
                    <th nowrap>Action</th>
                    <th>Description</th>
                    <th data-orderable="false"></th>
                </tr>
                </thead>
                <tbody class="log-list">
                <?php
                if (!empty($records['dataArray'])) {
                    foreach ($records['dataArray'] as $lists) {
                        extract($lists); ?>
                        <tr>
                            <td style="width: 2%">
                                <input type="checkbox" id="<?php echo $id; ?>" class="pointer" name="selection[]"
                                       value="<?php echo base64_encode($id); ?>"></td>
                            <td style="width:2%">
                                <label class="pointer m-0" for="<?php echo $id; ?>"><?php echo $event_time; ?></label>
                            </td>
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $user; ?></td>
                            <td><?php echo $remote_address; ?></td>
                            <td><?php echo $host_address; ?></td>
                            <td><?php echo $action; ?></td>
                            <td><?php echo $description; ?></td>
                            <td class="table-actions text-right">
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
        </form>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?php if ($pages->items_total > 0) { ?>
                <?php echo $pages->display_pages() . '</div>'; ?>
            <?php } ?>
        </div>
    </div>

    <script>
        function deleteRequest(id) {
            let obj = {
                action: '<?php echo $path;?>/delete',
                message: 'Are you sure to delete record?',
                callback: '<?php echo $path;?>',
                row_id: id,
            };
            DeleteWarning(obj);
        }
    </script>

<?php
if (!empty($_POST['selection'])):
    foreach ($_POST['selection'] as $key):
        $_POST['pk'] = $key;
        $_POST['callback'] = "";
        \App\Controller\Users\Users::DeleteLog();
    endforeach;
    echo '<script>location.replace("' . $path . '")</script>';
endif;