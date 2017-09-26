<?php
$tmpFileIds = isset($qa->tmp_file_ids) ? $qa->tmp_file_ids : 0;
$documentsTmp = FileService::getFilesByIds(['ids' => $tmpFileIds]);
$documents = isset($documentsTmp['success']) && $documentsTmp['success'] && isset($documentsTmp['files'])
        ? $documentsTmp['files'] : array();
?>

<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="color:#FAFAFA;border: none;font-size: x-large;font-weight: bold;text-align: center;display: block;padding: 10px;position: relative;background: #4d4d4f;text-transform: uppercase;">
                Q/A
            </td>
        </tr>
    </tbody>
</table>

<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="width: 30%"><b>Is there any special micro testing required.</b></td>
            <td style="width: 20%">
                <?=(isset($qa->spec_micro_test) && $qa->spec_micro_test != null) ? ($qa->spec_micro_test ? "Yes" : "No") . ($qa->spec_micro_test ? "<br/>".$qa->spec_micro_test_other : "") : ""?>
            </td>
            <td style="width: 30%"><b>Do you have any specified sampling requirements? Is so, provide details</b></td>
            <td style="width: 20%">
                <?= (isset($qa->spec_sample) && $qa->spec_sample != null) ? ($qa->spec_sample ? "Yes" : "No") . ($qa->spec_sample ? "<br/>".$qa->spec_sample_other : "") : ""?>
            </td>
        </tr>
                    
        <tr>
            <td style="width: 30%"><b>Does the Customer require a COA? If so, provide contact information</b></td>
            <td style="width: 20%">
                <?= (isset($qa->customer_require_coa) && $qa->customer_require_coa != null) ? ($qa->customer_require_coa ? "Yes" : "No") . ($qa->customer_require_coa ? "<br/>".$qa->customer_require_coa_other : "") : ""?>
            </td>
            <td style="width: 30%"><b>Has the Customer specified specific sensory testing requirements? Ie. Mixing instructions, density etc.</b></td>
            <td style="width: 20%">
                <?= (isset($qa->customer_spec_sensor) && $qa->customer_spec_sensor != null) ? ($qa->customer_spec_sensor ? "Yes" : "No") . ($qa->customer_spec_sensor ? "<br/>".$qa->customer_spec_sensor_other : "") : ""
                        ?>
            </td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Have the appropriate COAs been submitted?</b></td>
            <td style="width: 20%"><?= (isset($qa->appr_coa_submit) && $qa->appr_coa_submit != null) ? ($qa->appr_coa_submit ? "Yes" : "No") : ""?></td>
            <td style="width: 30%"><b>Does the Customer require a pre-shipment sample?</b></td>
            <td style="width: 20%"><?= (isset($qa->customer_require_preship) && $qa->customer_require_preship != null) ? ($qa->customer_require_preship ? "Yes" : "No") : ""?></td>
        </tr> 
        
        <tr>
            <td style="width: 30%"><b>Product spec sheet reviewed?</b></td>
            <td style="width: 20%">
                <?= (isset($qa->product_spec_sheet) && $qa->product_spec_sheet != null) ? ($qa->product_spec_sheet ? "Yes" : "No") . ($qa->product_spec_sheet ? "<br/>".$qa->product_spec_sheet_other : "") : "" ?>
            </td>
            
            <td style="width: 30%"><b>Allergen status reviewed?</b></td>
            <td style="width: 20%">
                <?= (isset($qa->allergen_status) && $qa->allergen_status != null) ? ($qa->allergen_status ? "Yes" : "No") . ($qa->allergen_status ? "<br/>".$qa->allergen_status_other : "") : ""
                 ?>
            </td>
        </tr>
            
        <?php if($projectService == "ser_pre_blend"):?>    
        <tr>
            <td style="width: 30%"><b>Allergen status reviewed?</b></td>
            <td style="width: 20%"><?= (isset($qa->customer_provide_confirm) && $qa->customer_provide_confirm != null) ? ($qa->customer_provide_confirm ? "Yes" : "No") :"" ?></td>
            <td style="width: 30%"><b>Has the Customer supplied a letter regarding stability testing?</b></td>
            <td style="width: 20%"><?= (isset($qa->customer_supply_letter) && $qa->customer_supply_letter != null) ? ($qa->customer_supply_letter ? "Yes" : "No") : "" ?></td>
        </tr>
        <?php endif;?>
        
        <tr>
            <td style="width: 30%"><b>Physical specifications of product i.e, density, flowability etc.</b></td>
            <td style="width: 20%"><?= isset($qa->physical_spec_product) ? $qa->physical_spec_product : ""?></td>
            <td style="width: 30%"><b>What is the net weight of each package?</b></td>
            <td style="width: 20%"><?= isset($qa->package_net_weight) ? $qa->package_net_weight : ""?></td>
        </tr>    
            
        <tr>
            <td style="width: 30%"><b>Has the Customer specified net weight limits? If so, provide details</b></td>
            <td style="width: 20%">
                <?= (isset($qa->customer_spec_net_weight) && $qa->customer_spec_net_weight != null) ? ($qa->customer_spec_net_weight ? "Yes" : "No") . ($qa->customer_spec_net_weight ? "<br/>".$qa->customer_spec_net_weight_other : "") : ""?>
            </td>
            <td style="width: 30%"><b>Has the Customer provided labelling requirements for primary packaging?</b></td>
            <td style="width: 20%">
                <?= (isset($qa->customer_provide_label) && $qa->customer_provide_label != null) ? ($qa->customer_provide_label ? "Yes" : "No") . ($qa->customer_provide_label ? "<br/>".$qa->customer_provide_label_other : "") : ""
                 ?>
            </td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Does this product have a UPC / SCC codes? If so, please provide.</b></td>
            <td style="width: 20%">
                <?= (isset($qa->is_upc_scc_code) && $qa->is_upc_scc_code != null) ? ($qa->is_upc_scc_code ? "Yes" : "No") . ($qa->is_upc_scc_code ? "<br/>".$qa->is_upc_scc_code_other : "") : ""
                 ?>
            </td>
            <td style="width: 30%"><b>Has the Customer provided labelling requirements for primary packaging?</b></td>
            <td style="width: 20%">
                <?= (isset($qa->customer_provide_label_primary_pack) && $qa->customer_provide_label_primary_pack != null) ? ($qa->customer_provide_label_primary_pack ? "Yes" : "No") . ($qa->customer_provide_label_primary_pack ? "<br/>".$qa->customer_provide_label_primary_pack_other : "")  : ""
                 ?>
            </td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Has the Customer provided labelling requirements for inner packaging?</b></td>
            <td style="width: 20%">
                <?= (isset($qa->customer_provide_label_inner_pack) && $qa->customer_provide_label_inner_pack != null )? ($qa->customer_provide_label_inner_pack ? "Yes" : "No") . ($qa->customer_provide_label_inner_pack ? "<br/>".$qa->customer_provide_label_inner_pack_other : "") : ""
                 ?>
            </td>
            <td style="width: 30%"><b>Has the Customer provided labelling requirements for shippers?</b></td>
            <td style="width: 20%">
                <?= (isset($qa->customer_provide_label_shipper) && $qa->customer_provide_label_shipper != null) ? ($qa->customer_provide_label_shipper ? "Yes" : "No") . ($qa->customer_provide_label_shipper ? "<br/>".$qa->customer_provide_label_shipper_other : "") : ""
                 ?>
            </td>
        </tr>
            
        <tr>
            <td style="width: 30%"><b>Does this product have special claims? Non-GMO, vegan, allergen free, organic, Kosher etc.</b></td>
            <td style="width: 20%">
                <?= (isset($qa->product_have_spec_claim) && $qa->product_have_spec_claim != null) ? ($qa->product_have_spec_claim ? "Yes" : "No") . ($qa->product_have_spec_claim ? "<br/>".$qa->product_have_spec_claim_other : "")  : ""
                 ?>
            </td>
            <td style="width: 30%"><b>Any special handling instructions? ex. Dry clean before due to allergen etc.</b></td>
            <td style="width: 20%">
                <?= (isset($qa->spec_hand_instruc) && $qa->spec_hand_instruc != null) ? ($qa->spec_hand_instruc ? "Yes" : "No") . ($qa->spec_hand_instruc ? "<br/>".$qa->spec_hand_instruc_other : "") : ""
                 ?>
            </td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Has the Customer requested special shipping requirrements?</b></td>
            <td style="width: 20%">
                <?= (isset($qa->customer_request_spec_ship) && $qa->customer_request_spec_ship != null) ? ($qa->customer_request_spec_ship ? "Yes" : "No") . ($qa->customer_request_spec_ship ? "<br/>".$qa->customer_request_spec_ship_other : "")  : ""
                 ?>
            </td>
            <td style="width: 30%"><b>Does this product have a NPN#?</b></td>
            <td style="width: 20%">
                <?= (isset($qa->product_have_npn) && $qa->product_have_npn != null) ? ($qa->product_have_npn ? "Yes" : "No") . ($qa->product_have_npn ? "<br/>".$qa->product_have_npn_other : "") : ""
                 ?>
            </td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Is this product NSF certified for sports?</b></td>
            <td style="width: 20%"><?= (isset($qa->product_nsf_for_sport) && $qa->product_nsf_for_sport != null) ? ($qa->product_nsf_for_sport ? "Yes" : "No") :"" ?></td>
            <td style="width: 30%"></td>
            <td style="width: 20%"></td>
        </tr>
    </tbody>
</table>
<br/>


Photos and documents
<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="store_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th>Thumbnail</th>
            <th>Name</th>
            <?php
            if(Yii::app()->user->checkAccess('Super Admin')){
                echo '<th>Restricted</th>';
            }
            ?>
            <th>Category</th>
            <th>Size</th>
        </tr>
        <?php
        if($documents):
        foreach($documents as $document):
            $documentName = isset($document['filename']) && isset($document['extension']) 
                            ? $document['filename'].".".$document['extension'] : "";
            $documentRestricted = isset($document['restricted_label']) 
                            ? $document['restricted_label'] : "";
            $documentCategory = isset($document['cat_name']) ? $document['cat_name'] : "";
            $documentSize = isset($document['filesize_label']) ? $document['filesize_label'] : "";
            $thumbnail = isset($document['thumbnail']) ? $document['thumbnail'] : "";
        ?>
        <tr>
            <td><img src="<?=DOMAIN_NAME . '/' .$thumbnail?>" height="40px;" /></td>
            <td><?= $documentName ?></td>
            <?php
            if(Yii::app()->user->checkAccess('Super Admin')){
                echo "<td>$documentRestricted</td>";
            }
            ?>
            <td><?= $documentCategory ?></td>
            <td><?= $documentSize ?></td>
        </tr>
        <?php
        endforeach;
        endif;
        ?>
    </tbody>
</table>
<br/>

Notes
<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="store_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td><?= isset($qa->note) ? $qa->note : "" ?></td>
        </tr>
    </tbody>
</table>
<br/>

<style>
html,body *{
    font-family: Arial, Helvetica,san-serif !important;
    font-size: 10pt;
}
.project_detail_table td{
    border: 1px solid #DFDFDF;
}
.thumbnail{
    padding: 5px;
    border: 1px solid #DFDFDF;
    border-radius: 3px;
}
</style>