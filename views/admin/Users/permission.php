<?php

use App\Controller\AppController;

$App = new AppController();
$app_permissions = $App->BuildMenus();

//----------------------------------------------------------------------------------------------------------------------------
//if (empty($user_access_right) || empty($param)):echo '<script>location.replace("' . WEB_ROOT . '")</script>'; endif;
//----------------------------------------------------------------------------------------------------------------------------
?>
<style>
    .card-body .col-md-12 {
        border-bottom: 0 !important;
    }

    #access-rights .permissions label {
        font-weight: normal;
        font-size: 0.85rem;
        cursor: pointer;
    }

    #access-rights table tbody td {
        font-size: 0.85rem;
        padding-bottom: 0px !important;
    }

    #access-rights input, label {
        cursor: pointer;
    }
</style>

<form method="post" action="<?php echo $path . '/permission'; ?>" class="app-form" id="access-rights" novalidate>
    <input type="hidden" name="tbl_scheme" value="<?php echo $tbl_scheme; ?>">
    <input type="hidden" name="pkField" value="<?php echo $pkField; ?>">
    <input type="hidden" name="pk" value="<?php echo $pk; ?>">
    <input type="hidden" name="type" value="<?php echo $type; ?>">
    <div class="row border-bottom">
        <div class="col-lg-6">
            <div class="text-muted pl-0 btn">
                <?php if ($type == 'group') { ?> Group Permission <i class="feather icon-arrow-right ml-2"></i>
                    <b><?php echo $info['description']; ?></b>
                <?php } else { ?>
                    Permission <i
                            class="feather icon-arrow-right ml-2"></i>
                    <b><?php echo $info['first_name'] . ' ' . $info['last_name'] . ' <small>( ' . $info['username'] . ')</small>'; ?></b>
                <?php } ?>
            </div>
        </div>
        <div class="col-auto ml-auto text-right">
            <div class="btn-group-justified btn-group-sm mb-0">
                <button class="btn btn-primary form-btn"><i
                            class="feather icon-save"></i><span class="hide-text"> Save Changes</span>
                </button>
                <button class="btn btn-success" type="button"
                        onClick="location.reload()">
                    <i class="feather icon-refresh-cw"></i> <span class="hide-text">Refresh</span>
                </button>
                <button class="btn btn-danger px-3" type="button"
                        onClick="location.replace('<?php echo $path; ?>')">
                    <i class="feather icon-x"></i> <span class="hide-text">Close </span>
                </button>
            </div>
        </div>
    </div>
    <div id="form-response"></div>
    <div class="mt-1 text-right">
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox"
                       class="custom-control-input toggle-checkbox" <?php if (@$count > 0): echo 'checked'; endif; ?>
                       id="AppPermissions">
                <label class="custom-control-label pt-1" for="AppPermissions">Check/Uncheck All</label>
            </div>
        </div>
    </div>
    <div style="overflow: auto; overflow-x: hidden; max-height: 100vh;">
        <div class="row mt-1 AppPermissions">
            <?php if (!empty($app_permissions)):
                foreach ($app_permissions as $menu => $options):
                    extract($options);
                    $menu_name = strip_tags($menu);
                    if (!empty($status)):
                        ?>
                        <div class="col-lg-4 mb-3">
                            <div class="card shadow-1">
                                <div class="card-header bg-light py-2">
                                    <h5 class="w-100 m-0" style="font-size: .75rem">
                                        <input type="checkbox" id="<?php echo $menu_name; ?>"
                                               class="float-right toggle-checkbox"
                                               name="permission[<?php echo $menu_name; ?>]"
                                               value="1" <?php if (!empty($permission[$menu_name])):echo 'checked';endif; ?>>
                                        <label class="pointer m-0"
                                               for="<?php echo $menu_name; ?>"> <?php echo '<i class="' . $options['icon'] . ' mr-2"></i>' . strtoupper($menu_name); ?></label>
                                    </h5>
                                </div>
                                <div class="card-body py-3" style="font-size: .75rem;">
                                    <div class="<?php echo $menu_name; ?> row">
                                        <?php if (!empty($submenus)): ?>
                                            <?php foreach ($submenus as $sub):
                                                extract($sub);
                                                $name = strip_tags($sub['link_name']);
                                                $name = str_ireplace('/', '_', $name);
                                                if (!empty($sub['status'])):?>
                                                    <div class="col-md-12 mb-2 mr-1 border-bottom">
                                                        <div class="w-100 pb-0 mb-0">
                                                            <input type="checkbox" class="float-right"
                                                                   id="<?php echo base64_encode($name); ?>"
                                                                   name="permission[<?php echo $name; ?>]"
                                                                   value="1" <?php if (!empty($permission[$name])):echo 'checked';endif; ?>>
                                                            <label for="<?php echo base64_encode($name); ?>"
                                                                   class="font-weight-bold m-0"
                                                                   style="font-size: .70rem !important;"><?php echo '<i class="' . $sub['icon'] . ' mr-1"></i>' . ucwords($sub['sub_label']); ?></label>
                                                            <?php if (!empty($sub['roles'])): ?>
                                                                <div class="ml-3">
                                                                    <table width="100%" class="m-0 p-0 table">
                                                                        <tbody>
                                                                        <?php foreach ($sub['roles'] as $key => $val):
                                                                            $key = $name . '_' . $key;
                                                                            ?>
                                                                            <tr class="permissions">
                                                                                <td class="p-0">
                                                                                    <input type="checkbox"
                                                                                           class="float-right my-1"
                                                                                           id="<?php echo $key; ?>"
                                                                                           name="permission[<?php echo $key; ?>]"
                                                                                           value="1" <?php if (!empty($permission[$key])):echo 'checked';endif; ?>>
                                                                                    <label for="<?php echo $key; ?>"
                                                                                           class="m-0"
                                                                                           style="font-size: .70rem !important;"><?php echo @$val['icon'] . ' ' . @$val['label']; ?></label>
                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>

                                                    </div>
                                                <?php endif;
                                            endforeach;
                                        endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    endif;
                endforeach;
            endif; ?>
        </div>
    </div>
</form>