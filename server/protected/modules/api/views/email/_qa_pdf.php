
<div class="col-md-12">
    <div class="box-header">
        <h3 class="box-title">Q/A</h3>
    </div>
</div>
<?php
if(!$qa) {
    return "";
}

$tmpFileIds = $qa->tmp_file_ids;
$documentsTmp = FileService::getFilesByIds(['ids' => $tmpFileIds]);
$documents = isset($documentsTmp['success']) && $documentsTmp['success'] && isset($documentsTmp['files'])
        ? $documentsTmp['files'] : array();
?>
<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="width: 30%"><b>Is there any special micro testing required.</b></td>
            <td style="width: 20%"><?= $qa->spec_micro_test ? "Yes" : "No"?></td>
            <?php if($qa->spec_micro_test):?>
            <td style="width: 30%"></td>
            <td style="width: 20%"><?= $qa->spec_micro_test_other?></td>
            <?php endif;?>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Do you have any specified sampling requirements? Is so, provide details</b></td>
            <td style="width: 20%"><?= $qa->spec_sample ? "Yes" : "No"?></td>
            <?php if($qa->spec_sample):?>
            <td style="width: 30%"></td>
            <td style="width: 20%"><?= $qa->spec_sample_other?></td>
            <?php endif;?>
        </tr>
            
        <tr>
            <td style="width: 30%"><b>Does the Customer require a COA? If so, provide contact information</b></td>
            <td style="width: 20%"><?= $qa->customer_require_coa ? "Yes" : "No"?></td>
            <?php if($qa->customer_require_coa):?>
            <td style="width: 30%"></td>
            <td style="width: 20%"><?= $qa->customer_require_coa_other?></td>
            <?php endif;?>
        </tr>
        
        
        <tr>
            <td style="width: 30%"><b>Has the Customer specified specific sensory testing requirements? Ie. Mixing instructions, density etc.</b></td>
            <td style="width: 20%"><?= $qa->customer_spec_sensor ? "Yes" : "No"?></td>
            <?php if($qa->customer_spec_sensor):?>
            <td style="width: 30%"></td>
            <td style="width: 20%"><?= $qa->customer_spec_sensor_other?></td>
            <?php endif;?>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Have the appropriate COAs been submitted?</b></td>
            <td style="width: 20%"><?= $qa->appr_coa_submit ? "Yes" : "No"?></td>
            <td style="width: 30%"><b>Does the Customer require a pre-shipment sample?</b></td>
            <td style="width: 20%"><?= $qa->customer_require_preship ? "Yes" : "No"?></td>
        </tr> 
        
        <tr>
            <td style="width: 30%"><b>Product spec sheet reviewed?</b></td>
            <td style="width: 20%"><?= $qa->product_spec_sheet ? "Yes" : "No"?></td>
            <?php if($qa->product_spec_sheet):?>
            <td style="width: 30%"></td>
            <td style="width: 20%"><?= $qa->product_spec_sheet_other?></td>
            <?php endif;?>
        </tr>
        
            
        <tr>
            <td style="width: 30%"><b>Allergen status reviewed?</b></td>
            <td style="width: 20%"><?= $qa->allergen_status ? "Yes" : "No" ?></td>
            <?php if ($qa->allergen_status): ?>
            <td style="width: 30%"></td>
            <td style="width: 20%"><?= $qa->allergen_status_other ?></td>
            <?php endif; ?>
        </tr>
          
        <?php if($projectService == "ser_pre_blend"):?>    
        <tr>
            <td style="width: 30%"><b>Allergen status reviewed?</b></td>
            <td style="width: 20%"><?= $qa->customer_provide_confirm ? "Yes" : "No" ?></td>
            <td style="width: 30%"><b>Has the Customer supplied a letter regarding stability testing?</b></td>
            <td style="width: 20%"><?= $qa->customer_supply_letter ? "Yes" : "No" ?></td>
        </tr>
        <?php endif;?>
        
        <tr>
            <td style="width: 30%"><b>Physical specifications of product i.e, density, flowability etc.</b></td>
            <td style="width: 20%"><?= $qa->physical_spec_product?></td>
            <td style="width: 30%"><b>What is the net weight of each package?</b></td>
            <td style="width: 20%"><?= $qa->package_net_weight?></td>
        </tr>    
            
        <tr>
            <td style="width: 30%"><b>Has the Customer specified net weight limits? If so, provide details</b></td>
            <td style="width: 20%"><?= $qa->customer_spec_net_weight ? "Yes" : "No" ?></td>
            <?php if($qa->customer_spec_net_weight) :?>
            <td style="width: 30%"></td>
            <td style="width: 20%"><?= $qa->package_net_weight_other ?></td>
            <?php endif;?>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Has the Customer provided labelling requirements for primary packaging?</b></td>
            <td style="width: 20%"><?= $qa->customer_provide_label ? "Yes" : "No" ?></td>
            <?php if($qa->customer_provide_label) :?>
            <td style="width: 30%"></td>
            <td style="width: 20%"><?= $qa->customer_provide_label_other ?></td>
            <?php endif;?>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Does this product have a UPC / SCC codes? If so, please provide.</b></td>
            <td style="width: 20%"><?= $qa->is_upc_scc_code ? "Yes" : "No" ?></td>
            <?php if($qa->is_upc_scc_code) :?>
            <td style="width: 30%"></td>
            <td style="width: 20%"><?= $qa->is_upc_scc_code_other ?></td>
            <?php endif;?>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Has the Customer provided labelling requirements for primary packaging?</b></td>
            <td style="width: 20%"><?= $qa->customer_provide_label_primary_pack ? "Yes" : "No" ?></td>
            <?php if($qa->customer_provide_label_primary_pack) :?>
            <td style="width: 30%"></td>
            <td style="width: 20%"><?= $qa->customer_provide_label_primary_pack_other ?></td>
            <?php endif;?>

        </tr>        
        
        <tr>
            <td style="width: 30%"><b>Has the Customer provided labelling requirements for inner packaging?</b></td>
            <td style="width: 20%"><?= $qa->customer_provide_label_inner_pack ? "Yes" : "No" ?></td>
            <?php if($qa->customer_provide_label_inner_pack) :?>
            <td style="width: 30%"></td>
            <td style="width: 20%"><?= $qa->customer_provide_label_inner_pack_other ?></td>
        <?php endif;?>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Has the Customer provided labelling requirements for shippers?</b></td>
            <td style="width: 20%"><?= $qa->customer_provide_label_shipper ? "Yes" : "No" ?></td>
            <?php if($qa->customer_provide_label_shipper) :?>
            <td style="width: 30%"></td>
            <td style="width: 20%"><?= $qa->customer_provide_label_shipper_other ?></td>
            <?php endif;?>
        </tr>
            
        <tr>
            <td style="width: 30%"><b>Does this product have special claims? Non-GMO, vegan, allergen free, organic, Kosher etc.</b></td>
            <td style="width: 20%"><?= $qa->product_have_spec_claim ? "Yes" : "No" ?></td>
            <?php if($qa->product_have_spec_claim) :?>
            <td style="width: 30%"></td>
            <td style="width: 20%"><?= $qa->product_have_spec_claim_other ?></td>
            <?php endif;?>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Any special handling instructions? ex. Dry clean before due to allergen etc.</b></td>
            <td style="width: 20%"><?= $qa->spec_hand_instruc ? "Yes" : "No" ?></td>
            <?php if($qa->spec_hand_instruc) :?>
            <td style="width: 30%"></td>
            <td style="width: 20%"><?= $qa->spec_hand_instruc_other ?></td>
         <?php endif;?>
        </tr>
            
        <tr>
            <td style="width: 30%"><b>Has the Customer requested special shipping requirrements?</b></td>
            <td style="width: 20%"><?= $qa->customer_request_spec_ship ? "Yes" : "No" ?></td>
            <?php if($qa->customer_request_spec_ship) :?>
            <td style="width: 30%"></td>
            <td style="width: 20%"><?= $qa->customer_request_spec_ship_other ?></td>
            <?php endif;?>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Does this product have a NPN#?</b></td>
            <td style="width: 20%"><?= $qa->product_have_npn ? "Yes" : "No" ?></td>
            <?php if($qa->product_have_npn) :?>
            <td style="width: 30%"></td>
            <td style="width: 20%"><?= $qa->product_have_npn_other ?></td>
            <?php endif;?>

        </tr>            
        <tr>
            <td style="width: 30%"><b>Is this product NSF certified for sports?</b></td>
            <td style="width: 20%"><?= $qa->product_nsf_for_sport ? "Yes" : "No" ?></td>
        </tr>
    </tbody>
</table>
<br/>


Photos and documents
<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="store_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
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
        ?>
        <tr>
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
            <td><?= $qa->note ?></td>
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