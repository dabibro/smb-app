<?php

use App\Handlers\DataHandlers;

?>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="feather icon-user-plus"></i> Create Customer</h5>
            </div>
            <div class="card-body">
                <form class="app-form" action="<?php echo $path; ?>" method="post" id="user-group">
                    <h5 class="mb-3">Personal Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name"><span class="required">*</span> First Name</label>
                                <input type="text" name="first_name" id="first_name" placeholder="First Name"
                                       class="form-control" value="<?php echo @$edit->first_name; ?>" required>
                                <div class="invalid-feedback">* This is a required field.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name"><span class="required">*</span> Last Name</label>
                                <input type="text" name="last_name" id="last_name" placeholder="Last Name"
                                       class="form-control" value="<?php echo @$edit->last_name; ?>"
                                       required>
                                <div class="invalid-feedback">* This is a required field.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_number"> Phone Number
                                    <small>(Optional)</small>
                                </label>
                                <input type="text" name="phone_number" id="phone_number" placeholder="Phone Number"
                                       class="form-control" value="<?php echo @$edit->phone_number; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email_address"> Email Address
                                    <small>(Optional)</small>
                                </label>
                                <input type="email" name="email_address" id="email_address" placeholder="Email Address"
                                       class="form-control" value="<?php echo @$edit->email_address; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bank_name"> Bank Name
                                    <small>(Optional)</small>
                                </label>
                                <input type="text" name="bank_name" id="bank_name" placeholder="Bank Name"
                                       class="form-control" value="<?php echo @$edit->bank_name; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="account_number"> Account Number
                                    <small>(Optional)</small>
                                </label>
                                <input type="number" name="account_number" id="account_number"
                                       class="form-control" value="<?php echo @$edit->account_number; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="credit_limit"> Credit Limit
                                    <small>(Optional)</small>
                                </label>
                                <input type="number" name="credit_limit" id="credit_limit"
                                       class="form-control" value="<?php echo @$edit->account_number; ?>">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="customer_address">Contact Address
                                    <small>(Optional)</small>
                                </label>
                                <textarea name="customer_address" class="form-control" id="customer_address" rows="3"
                                          placeholder="Contact Address"
                                          autocomplete="off"><?php echo @$edit->address; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_location">Location
                                    <small>(Optional)</small>
                                </label>
                                <select name="customer_location" id="customer_location" class="form-control">
                                    <option value="">--- Select Location ---</option>
                                    <?php DataHandlers::DropDownList($locations, 'reference', 'location_name', @$edit->location) ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_group">Customer Group
                                    <small>(Optional)</small>
                                </label>
                                <select name="customer_group" id="customer_group" class="form-control">
                                    <option value="">--- Select Group ---</option>
                                    <?php DataHandlers::DropDownList($groups, 'reference', 'description', @$edit->customer_group) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0 pt-lg-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="AddNew"
                                           id="AddNew">
                                    <label class="custom-control-label pointer" for="AddNew">
                                        Add Another User</label>
                                </div>
                            </div>
                    <input type="hidden" name="Path" value="<?php echo DASHBOARD.'/customers/list'; ?>">
                    <hr>
                    <div id="form-response"></div>
                    <?php if (!empty($edit->id)) { ?>
                        <input type="hidden" name="pk" value="<?php echo $edit->id; ?>">
                        <input type="hidden" name="pkField" value="id">
                        <a class="btn btn-danger" href="javascript:;"
                           onclick="location.replace('<?php echo $path; ?>')"><i class="feather icon-x"></i> Cancel </a>
                    <?php } ?>
                    <button class="btn btn-primary form-btn"><i class="feather icon-save"></i> Save Record
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
