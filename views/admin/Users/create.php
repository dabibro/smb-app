<?php
use App\Handlers\DataHandlers;
use App\Controller\AppController;

$App = new AppController();
$app_permissions = $App->BuildMenus();
?>
<div class="container">
    <div class="card-header">
        <h5><i class="feather icon-user-plus"></i> Create User</h5>
    </div>
    <div class="tab-content mt-2">
        <!-- Basic Info Tab -->
        <div class="tab-pane fade show active" id="basic">
            <form class="app-form" action="<?php echo $path; ?>" method="post" id="user">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">

                        <h5 class="mb-3">Employee Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="employmentType">Employement Type
                                    </label>
                                    <select name="employmentType" id="employmentType" class="form-control">
                                        <?php DataHandlers::DropDownList($employmentType, 'value', 'label', @$edit->employmentType) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="employeeId"><span class="required">*</span> Employee Id</label>
                                    <input type="text" name="employeeId" id="employeeId" placeholder="Employee Id"
                                           class="form-control" value="<?php echo @$reference; ?>">
                                    <div class="invalid-feedback">* This is a required field.</div>
                                </div>
                            </div>
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="dateOfBirth"> Date of Birth
                                    </label>
                                    <input type="date" name="employment_details[dateOfBirth]" id="dateOfBirth"
                                           class="form-control" value="<?php echo @$employment_details->dateOfBirth; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender">Gender
                                    </label>
                                    <select name="employment_details[gender]" id="gender" class="form-control">
                                        <?php DataHandlers::DropDownList($gender, 'value', 'label', @$employment_details->gender) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="maritalStatus">Marital Status
                                    </label>
                                    <select name="employment_details[maritalStatus]" id="maritalStatus" class="form-control">
                                        <?php DataHandlers::DropDownList($maritalStatus, 'value', 'label', @$employment_details->maritalStatus) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="state">State
                                    </label>
                                    <select name="employment_details[state]" id="state" class="form-control">
                                        <?php DataHandlers::DropDownList($locations, 'reference', 'location_name', @$employment_details->state) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="maritalStatus">LGA
                                    </label>
                                    <select name="employment_details[lga]" id="lga" class="form-control">
                                        <?php DataHandlers::DropDownList($locations, 'reference', 'location_name', @$employment_details->lga) ?>
                                    </select>
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Contact Address
                                        <small>(Optional)</small>
                                    </label>
                                    <textarea name="address" class="form-control" id="address" rows="3"
                                              placeholder="Contact Address"
                                              autocomplete="off"><?php echo @$edit->address; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <h5 class="mb-3 mt-3">Employment Details</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location">Location
                                        <small>(Optional)</small>
                                    </label>
                                    <select name="location" id="location" class="form-control">
                                        <option value="">--- Select Location ---</option>
                                        <?php DataHandlers::DropDownList($locations, 'reference', 'location_name', @$edit->location) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="group">User Group
                                        <small>(Optional)</small>
                                    </label>
                                    <select name="u_group" id="u_group" class="form-control">
                                        <option value="">--- Select Group ---</option>
                                        <?php DataHandlers::DropDownList($groups, 'reference', 'description', @$edit->u_group) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department">Department
                                        <small>(Optional)</small>
                                    </label>
                                    <select name="employment_details[department]" id="department" class="form-control">
                                        <option value="">--- Select Department ---</option>
                                        <?php DataHandlers::DropDownList($locations, 'reference', 'location_name', @$employment_details->department) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="group">Unit/Section
                                        <small>(Optional)</small>
                                    </label>
                                    <select name="employment_details[unit]" id="unit" class="form-control">
                                        <option value="">--- Select Unit ---</option>
                                        <?php DataHandlers::DropDownList($groups, 'reference', 'description', @$employment_details->unit) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="designation"> Designation
                                        <small>(Optional)</small>
                                    </label>
                                    <input type="text" name="employment_details[designation]" id="designation" placeholder="Designation"
                                           class="form-control" value="<?php echo @$employment_details->designation; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dateOfEmployment"> Date of Employment
                                        <small>(Optional)</small>
                                    </label>
                                    <input type="Date" name="employment_details[dateOfEmployment]" id="dateOfEmployment"
                                           class="form-control" value="<?php echo @$employment_details->dateOfEmployment; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="basicSalary"> Basic Salary
                                        <small>(monthly)</small>
                                    </label>
                                    <input type="text" name="employment_details[basicSalary]" id="basicSalary"
                                           class="form-control" value="<?php echo @$employment_details->basicSalary; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">

                    <div class="card-body">
                        <h5 class="mb-3">Next Of Kin</h5>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nokFullName"><span class="required">*</span> Name</label>
                                    <input type="text" name="next_of_kin[FullName]" id="nokFullName" placeholder="Full Name"
                                           class="form-control" value="<?php echo @$next_of_kin->FullName; ?>" required>
                                    <div class="invalid-feedback">* This is a required field.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nokPhoneNumber"> Phone Number
                                        <small>(Optional)</small>
                                    </label>
                                    <input type="text" name="next_of_kin[PhoneNumber]" id="nokPhoneNumber" placeholder="Phone Number"
                                           class="form-control" value="<?php echo @$next_of_kin->PhoneNumber; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nokEmailAddress"> Email Address
                                        <small>(Optional)</small>
                                    </label>
                                    <input type="email" name="next_of_kin[EmailAddress]" id="nokEmailAddress" placeholder="Email Address"
                                           class="form-control" value="<?php echo @$next_of_kin->EmailAddress; ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Contact Address
                                        <small>(Optional)</small>
                                    </label>
                                    <textarea name="next_of_kin[Address]" class="form-control" id="nokAddress" rows="3"
                                              placeholder="Contact Address"
                                              autocomplete="off"><?php echo @$next_of_kin->Address; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <h5 class="mb-3">Guarantor</h5>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="guarantorFullName"><span class="required">*</span> Name</label>
                                    <input type="text" name="guarantor[FullName]" id="guarantorFullName" placeholder="Full Name"
                                           class="form-control" value="<?php echo @$guarantor->FullName; ?>" required>
                                    <div class="invalid-feedback">* This is a required field.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="guarantorPhoneNumber"> Phone Number
                                        <small>(Optional)</small>
                                    </label>
                                    <input type="text" name="guarantor[PhoneNumber]" id="guarantorPhoneNumber" placeholder="Phone Number"
                                           class="form-control" value="<?php echo @$guarantor->PhoneNumber; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="guarantorEmailAddress"> Email Address
                                        <small>(Optional)</small>
                                    </label>
                                    <input type="email" name="guarantor[EmailAddress]" id="guarantorEmailAddress" placeholder="Email Address"
                                           class="form-control" value="<?php echo @$guarantor->EmailAddress; ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Contact Address
                                        <small>(Optional)</small>
                                    </label>
                                    <textarea name="guarantor[Address]" class="form-control" id="guarantorAddress" rows="3"
                                              placeholder="Contact Address"
                                              autocomplete="off"><?php echo @$guarantor->Address; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group mb-0 pt-lg-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="isSoftwareUser" <?php echo  @$edit->isSoftwareUser; ?>
                                           id="isSoftwareUser" value="<?php echo @$edit->isSoftwareUser; ?>">
                                    <label class="custom-control-label pointer" for="isSoftwareUser">
                                        Allow Software access</label>
                                </div>
                            </div>
                        </div>

                        <div id ="accountInformation">
                            <h5 class="mb-3 mt-3">Account Information</h5>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type"><span class="required">*</span> Type</label>
                                        <select name="type" id="type" class="form-control" required>
                                            <option value="">--- Select Type ---</option>
                                            <?php DataHandlers::DropDownList($types, 'code', 'description', @$edit->type) ?>

                                        </select>
                                        <div class="invalid-feedback">* This is a required field.</div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username"><span class="required">*</span> Username</label>
                                        <input type="text" name="username" id="username" placeholder="Username"
                                               class="form-control" value="<?php echo @$edit->username; ?>" required>
                                        <div class="invalid-feedback">* This is a required field.</div>

                                    </div>
                                </div>
                                <!-- <div class="col-md-6">
                                    <div class="form-group mb-0 pt-lg-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="AddNew"
                                                   id="AddNew">
                                            <label class="custom-control-label pointer" for="AddNew">
                                                Add Another User</label>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="col-md-6">
                                    <label for="" class="small w-100 text-left">Default password: 12345678</label>
                                    <?php if (empty($edit->id)) { ?>
                                        <input type="hidden" name="password" value="12345678">
                                    <?php } ?>
                                    <button class="btn-sm btn mr-0 " type="button"><i class="feather icon-lock"></i> Reset
                                        password
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="Path" value="<?php echo DASHBOARD . '/users/list'; ?>">
                            <hr>
                            <div id="form-response"></div>
                            <?php if (!empty($edit->id)) { ?>
                                <input type="hidden" name="pk" value="<?php echo $edit->id; ?>">
                                <input type="hidden" name="pkField" value="id">
                                <a class="btn btn-danger" href="javascript:;"
                                   onclick="location.replace('<?php echo $path; ?>')"><i class="feather icon-x"></i> Cancel </a>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
            <div>
                <button class="btn btn-primary form-btn"><i class="feather icon-save"></i> Save Record
                </button>
            </div>
            </form>
        </div>
    </div>

</div>



