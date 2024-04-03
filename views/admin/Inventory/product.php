<?php
use App\Controller\AppController;
use App\Handlers\DataHandlers;

$App = new AppController();
$app_permissions = $App->BuildMenus();
?>
<div class="container">
    <div>
        <h5><i class="feather icon-product-plus"></i> Add Product</h5>
    </div>
    <div class="tab-content mt-2">
        <form class="app-form" action="<?php echo $path; ?>" method="post" id="product">
            <div class="text-right mb-2 pb-2 border-bottom">
                <div class="row">
                    <?php if (empty ($basic)): ?>
                        <div class="col-auto ml-auto">
                            <div class="icheck-blue">
                                <input type="radio" id="remain" name="remain" value="remain">
                                <label for="remain">Remain on page</label>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icheck-blue">
                                <input type="radio" id="add_new" name="remain" value="add_new">
                                <label for="add_new">Add New</label>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-auto <?php if (!empty ($basic)): ?>ml-auto<?php endif; ?>">
                        <button class="btn bg-gradient-primary form-btn">
                            <i class="fal fa-save"></i> Save Record
                        </button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label> <span class="required">*</span> Product ID/Barcode</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn bg-gradient-primary btn-sm px-2" type="button"
                                    onclick="genId('product_id',6,'M')" title="Random ID" data-toggle="tooltip"><i
                                        class="fal fa-barcode m-0"></i></button>
                            </div>
                            <input name="product_id" type="search" required
                                class="form-control form-control-sm inventory-lookup" id="product_id"
                                onkeyup="inventoryLookup('all')" placeholder="Product ID/Barcode" autocomplete="off"
                                value="<?php echo @$reference; ?>">
                            <?php if (empty ($basic)): ?>
                                <div class="input-group-append">
                                    <button class="btn bg-gradient-primary btn-sm" type="button"
                                        onclick="fetchProductLookup($('.inventory-lookup').val(),$('#store-branch').val());">
                                        <i class="fal fa-search m-0"></i>
                                    </button>
                                    <button type="button" title="Batch ID/Barcode"
                                        class="btn bg-gradient-primary btn-sm dropdown-toggle px-2" data-toggle="collapse"
                                        aria-expanded="false" data-target="#batchId" aria-controls="filterCriteria">
                                        <i class="fal fa-layer-group m-0"></i></button>
                                </div>
                            <?php endif; ?>
                            <input type="hidden" name="batch_id" id="sku-input-list" value="<?php echo @$batch_id; ?>">
                        </div>
                        <div class="invalid-feedback">* Required field.</div>
                        <div class="collapse p-3 card shadow-sm mt-1" aria-labelledby="dLabel" id="batchId"
                            style="z-index: 1 !important; position: absolute; width: 450px; right: .5rem">
                            <label class="mb-0"><i class="fal fa-layer-group"></i> SKU/Barcode Batch Upload</label>
                            <hr class="my-2">
                            <div id="batchSKUResponse"></div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="sku-barcode" id="sku_barcode"
                                        class="form-control-sm form-control" required autocomplete="off"
                                        placeholder="SKU/Barcode" form="sku-form">
                                    <div class="input-group-append">
                                        <button class="btn bg-gradient-primary btn-sm" form="sku-form"><i
                                                class="fal fa-check-circle mr-0 pr-0"></i>
                                            Submit
                                        </button>
                                    </div>
                                </div>
                                <div class="invalid-feedback">* Require field</div>
                            </div>
                            <div id="SKU-list" style="min-height:145px; max-height: 145px; overflow: auto">
                                <table class="table table-striped table-sm">
                                    <?php if (@$edit):
                                      //  $batch_list = explode(', ', $batch_id);
                                     //   foreach ($batch_list as $sku):
                                        //    echo '<tr id="' . $sku . '"><td>' . $sku . '</td><td class="text-right"><a href="javascript:void(0)" onclick="delSKU(\'' . $sku . '\')"><i class="fal fa-trash-alt"></i></a></td></tr>';
                                      //  endforeach;
                                    endif; ?>
                                </table>
                            </div>
                            <div id="cache-sku" class="hide">
                                <!-- <?php if (!empty ($edit) && !empty ($batch_id)):
                                    echo $batch_id . ', '; endif; ?> -->
                            </div>
                            <hr class="my-2">
                            <button type="button" class="btn btn-danger btn-sm" onclick="discardSKU();"><i
                                    class="fal fa-eraser"></i>
                                Discard
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group mb-2">
                        <label for=""><span class="required">*</span> Location</label>
                        <select name="location" class="form-control select2" required >
                            <option value="">-- Select --</option>
                            <?php DataHandlers::DropDownList($locations, 'reference', 'location_name', @$edit->location) ?>
                        </select>
                        <div class="invalid-feedback">* This is a required field.</div>
                    </div>
                </div>

               
                <div class="col-lg-3">
                    <div class="form-group mb-2">
                        <label> <span class="required">*</span> Product Type</label>
                        <select name="product_type" class="form-control form-control-sm select2" required>
                            <option value="">-- Select --</option>
                            <?php
                            DataHandlers::DropDownList($productType, 'value', 'label', @$edit->category)
                                ?>
                        </select>
                        <div class="invalid-feedback">* This is a required field</div>
                    </div>
                </div>
                                  <div class="col-lg-3">
                        <div class="form-group mb-2">
                            <label for=""><span class="required">*</span> Category</label>
                            <select name="category" class="form-control select2" required>
                                <option value="">-- Select --</option>
                                <?php DataHandlers::DropDownList($categories, 'reference', 'name', @$edit->category) ?>
                            </select>
                            <div class="invalid-feedback">* This is a required field.</div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group mb-2">
                            <label for=""><span class="required">*</span>Sub Category</label>
                            <select name="subcategory" class="form-control select2" required ="1">
                                <option value="">-- Select --</option>
                                <?php DataHandlers::DropDownList($categories, 'reference', 'name', @$edit->category) ?>
                            </select>
                            <div class="invalid-feedback">* This is a required field.</div>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-2">
                        <label for="product_name"> <span class="required">*</span> Name/Description:</label>
                        <input name="product_name" type="text" required="required" class="form-control form-control-sm"
                            id="product_name" placeholder="Product Name/Description" autocomplete="off"
                            value="<?php echo @$edit->product_name ?>">
                        <div class="invalid-feedback">This is a required field.</div>
                    </div>
                </div>

                <div class="col-lg-2 col-4">
                    <div class="form-group mb-2">
                        <label for=""> <span class="required">*</span> Unit Price
                            <?php //echo $app->currency();  ?>
                            :
                        </label>
                        <input name="unit_price" type="text" autocomplete="off" required
                            class="form-control form-control-sm num" id="unit_price" placeholder="Unit Price"
                            onkeyup="computeMarkup(), itemComputation()" value="<?php echo @$edit->unit_price; ?>" />
                        <div class="invalid-feedback">* Required</div>
                    </div>
                </div>
                <div class="col-lg-2 col-4">
                    <div class="form-group mb-2">
                        <label for=""> <span class="required">*</span> Sale Price
                            <?php //echo $app->currency();  ?>
                            :
                        </label>
                        <input name="sale_price" type="text" autocomplete="off" required
                            class="form-control form-control-sm num" id="sale_price" placeholder="Sale Price"
                            onkeyup="itemComputation()" value="<?php echo @$edit->sale_price; ?>" />
                        <div class="invalid-feedback">Required</div>
                    </div>
                </div>
                <?php if (empty ($basic)): ?>
                    <div class="col-lg-2 col-4">
                        <div class="form-group mb-2">
                            <label for="quantity"> Stock Quantity:</label>
                            <input name="quantity" type="text" autocomplete="off" class="form-control form-control-sm num"
                                id="quantity" placeholder="Quantity" onkeyup="itemComputation()"
                                value="<?php echo @$edit->quantity ?>" <?php if (!empty ($edit)):
                                       echo 'readonly'; endif; ?>>
                        </div>
                    </div>
                    <div class="col-lg-2 col-4">
                        <div class="form-group mb-2">
                            <label for="quantity"> UOM:</label>
                            <input name="uom" type="text" autocomplete="off" class="form-control form-control-sm" id="uom"
                                placeholder="UOM" value="<?php echo @$edit->uom ?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-4">
                        <div class="form-group mb-2">
                            <label> Warning Level</label>
                            <input name="warning_level" class="form-control form-control-sm num" autocomplete="off"
                                id="warning_level" placeholder="Warning Level"
                                value="<?php echo @$edit->warning_level ?>" />
                        </div>
                    </div>
                    <div class="col-lg-2 col-4">
                        <div class="form-group">
                            <label for=""> Wholesale Price
                                <?php //echo $app->currency();  ?>:
                            </label>
                            <input name="wholesale_price" type="text" autocomplete="off"
                                class="form-control form-control-sm num" id="wholesale_price" placeholder="Wholesale Price"
                                value="<?php echo @$edit->wholesale_price; ?>" />
                        </div>
                    </div>
                    <div class="col-lg-2 col-4">
                        <div class="form-group mb-2">
                            <label for="">Markup %:</label>
                            <input type="text" autocomplete="off" class="form-control form-control-sm num" id="markup"
                                placeholder="Markup %" value="<?php echo @$price_markup; ?>" />
                        </div>
                    </div>
                    <div class="col-lg-2 col-4">
                        <div class="form-group mb-2">
                            <label>Markup Value
                                <?php //echo $app->currency();  ?>:
                            </label>
                            <input class="form-control form-control-sm" readonly placeholder="Markup Value"
                                id="markup_value">
                        </div>
                    </div>
                    <div class="col-lg-2 col-4">
                        <div class="form-group mb-2">
                            <label for="">Expiry Date</label>
                            <input name="expiry_date" type="text" autocomplete="off"
                                class="form-control form-control-sm datepicker" placeholder="Expiry Date"
                                value="<?php if (@$edit->expiry_date != "0000-00-00")
                                    echo @$edit->expiry_date ?>">
                            </div>
                        </div>
                        <div class="col-lg-2 col-4">
                            <div class="form-group mb-2">
                                <label for="product_amount">Cost Amount
                             
                            </label>
                            <input type="text" class="form-control form-control-sm num" id="product_amount"
                                placeholder="Product Amount"
                                value="<?php echo @$unit_price * @$edit->quantity; ?>" readonly />
                        </div>
                    </div>
                    <div class="col-lg-2 col-4">
                        <div class="form-group mb-2">
                            <label for="product_sale_amount">Sale Amount
                               
                            </label>
                            <input type="text" class="form-control form-control-sm num" id="product_sale_amount"
                                placeholder="Sale Amount" value="<?php echo @$edit->sale_price * @$edit->quantity; ?>"
                                readonly />
                        </div>
                    </div>
                    <div class="col-lg-2 col-4">
                        <div class="form-group mb-2">
                            <label for="product_sale_amount">Approx. Profit
                           
                            </label>
                            <input type="text" class="form-control form-control-sm num" id="product_profit"
                                placeholder="Sale Amount"
                                value="<?php echo (@$edit->sale_price * @$edit->quantity) - (@$edit->unit_price * @$edit->quantity); ?>"
                                readonly />
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="form-group mb-2">
                            <label>Storage/Warehouse</label>
                            <select name="product_storage" class="form-control form-control-sm select2"
                                onchange="productSubStorage(this.value, 'product_substorage')">
                                <option value="">-- Select --</option>
                                <?php DataHandlers::DropDownList($categories, 'reference', 'name', @$edit->product_storage) ?>
                            </select>
                            <div class="invalid-feedback">* This is a required field</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="form-group mb-2">
                            <label>Locations</label>
                            <select name="product_storage" class="form-control form-control-sm select2"
                                onchange="productSubStorage(this.value, 'product_substorage')">
                                <option value="">-- Select --</option>
                                <?php DataHandlers::DropDownList($categories, 'reference', 'name', @$edit->product_storage) ?>
                            </select>
                            <div class="invalid-feedback">* This is a required field</div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-6">
                        <div class="form-group mb-2">
                            <label for="">Manufacturer</label>
                            <input name="manufacturer" type="text" autocomplete="off" class="form-control form-control-sm"
                                placeholder="Manufacturer" value="<?php echo @$edit->manufacturer ?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-6">
                        <div class="form-group mb-2">
                            <label for="">Part Number</label>
                            <input name="part_number" type="text" autocomplete="off" class="form-control form-control-sm"
                                placeholder="Part Number" value="<?php echo @$edit->part_number ?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-6">
                        <div class="form-group mb-2">
                            <label for="">Serial Number</label>
                            <input name="serial_number" type="text" autocomplete="off" class="form-control form-control-sm"
                                placeholder="Serial Number" value="<?php echo @$edit->serial_number ?>">
                        </div>
                    </div>
                    <?php if (!empty ($edit) && empty ($basic) && empty ($access['adjust_product_qty'])): ?>
                        <div class="col-lg-4 ml-auto">
                            <div class="form-group">
                                <label>Adjust Quantity
                                    <a href="javascript:;" title="Click Plus or Minus to add or subtract entered value"
                                        data-toggle="tooltip"><i class="fal fa-info-circle"></i></a></label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm num" id="quantity-adjust"
                                        placeholder="Enter Quantity" autocomplete="off" />
                                    <div class="input-group-append">
                                        <button class="btn bg-gradient-primary btn-sm" title="Subtract Quantity"
                                            data-toggle="tooltip"
                                            onClick="adjProductQty('<?php echo base64_encode($id); ?>', 'subtract')"
                                            type="button">
                                            <i class="fal fa-minus m-0"></i>
                                        </button>
                                        <button class="btn bg-gradient-primary btn-sm" title="Add Quantity"
                                            data-toggle="tooltip"
                                            onClick="adjProductQty('<?php echo base64_encode($id); ?>', 'add')" type="button">
                                            <i class="fal fa-plus m-0"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="adjust-response" class="small text-danger"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-lg-12">
                        <div class="form-group mb-2">
                            <label>Description</label>
                            <textarea name="product_description" class="form-control form-control-sm text-editor" rows="4"
                                style="min-height: 4rem; max-height: 5.45rem" placeholder="Description"
                                autocomplete="off"><?php echo @$product_description; ?></textarea>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>