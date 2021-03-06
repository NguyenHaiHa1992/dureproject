
<?php
$tmpFileIds = isset($sale->tmp_file_ids) ? $sale->tmp_file_ids : 0;

$documentsTmp = FileService::getFilesByIds(['ids' => $tmpFileIds]);
$documents = isset($documentsTmp['success']) && $documentsTmp['success'] && isset($documentsTmp['files'])
        ? $documentsTmp['files'] : array();

$TypeProductInfo =  "product_info";
$TypeOfPacking = 'of_pack';
$PackPlain = "pack_plain";
$PackCustomer  = "pack_customer";
?>

<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="color:#FAFAFA;border: none;font-size: x-large;font-weight: bold;text-align: center;display: block;padding: 10px;position: relative;background: #4d4d4f;text-transform: uppercase;">SALES</td>
        </tr>
    </tbody>
</table>

<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style=";border: none;font-size:15;font-weight: bold;padding: 10px;text-transform: uppercase;">
                Product Information 
            </td>
        </tr>
    </tbody>
</table>
<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="width: 30%"><b>Has a product sample been submitted to Product Development</b></td>
            <td style="width: 20%"><?= (isset($sale->product_sample_product) && $sale->product_sample_product != null) ? ($sale->product_sample_product ? "Yes" : "No") : "";?></td>
            <td style="width: 30%"><b>If so, has information (ie. nutritionals, product specs) been provided to product development</b></td>
            <td style="width: 20%"><?= isset($sale->product_infor_provide_product) ? Sale::getLabelByType($TypeProductInfo, $sale->product_infor_provide_product) : ""?></td>
        </tr>

        <tr>
            <td style="width: 30%"><b>Has a sample been submitted for a packaging test or has a pack test been performed?</b></td>
            <td style="width: 20%"><?= isset($sale->product_sample_submit_pack) ? Sale::getLabelByType($TypeProductInfo, $sale->product_sample_submit_pack): "";?></td>
            <td style="width: 30%"><b>If so, has a COA been submitted?</b></td>
            <td style="width: 20%"><?= isset($sale->product_coa_submit) ? Sale::getLabelByType($TypeProductInfo, $sale->product_coa_submit) : ""?></td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Product spec sheet provided to QA?</b></td>
            <td style="width: 20%"><?= isset($sale->product_spec_qa) ? Sale::getLabelByType($TypeProductInfo,$sale->product_spec_qa) : ""?></td>
            <td style="width: 30%"><b>Allergen status provided to QA?</b></td>
            <td style="width: 20%"><?= isset($sale->product_allergen_qa) ? Sale::getLabelByType($TypeProductInfo,$sale->product_allergen_qa) : ""?></td>
        </tr>
            
        <tr>
            <td style="width: 30%"><b>Is the product Kosher?</b></td>
            <td style="width: 20%"><?= isset($sale->product_product_kosher) ? Sale::getLabelByType($TypeProductInfo,$sale->product_product_kosher) : ""?></td>
            <td style="width: 30%"></td>
            <td style="width: 20%"></td>
        </tr>
    </tbody>
</table>
<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>    
        <tr>
            <td style=";border: none;font-size:15;font-weight: bold;padding: 10px;text-transform: uppercase;">
                Items and status:
            </td>
        </tr>
    </tbody>
</table>

<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="width: 30%"><b>Have product specifications been provided to QA?</b></td>
            <td style="width: 20%"><?= isset($sale->product_product_spec_provide_qa) ? Sale::getLabelByType($TypeProductInfo,$sale->product_product_spec_provide_qa) : ""?></td>
            <td style="width: 30%"><b>Physical specifications of product i.e, density, flowability etc.</b></td>
            <td style="width: 20%"><?= isset($sale->product_physical_spec) ? $sale->product_physical_spec : ""?></td>
        </tr>
            
        <tr>
            <td style="width: 30%"><b>Has an allergen status been provided? Identify allergens present in the product.</b></td>
            <td style="width: 20%"><?=isset($sale->product_allergen_status) ? $sale->product_allergen_status : ""?></td>
            <td style="width: 30%"><b>Is this product Kosher?</b></td>
            <td style="width: 20%"><?= isset($sale->product_product_kosher_input) ? $sale->product_product_kosher_input : ""?></td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>What type of packaging? Stick, pouch, jar, can, SUP, bulk etc.</b></td>
            <td style="width: 20%"><?=isset($sale->product_type_pack) ? $sale->product_type_pack : ""?></td>
            <td style="width: 30%"><b>Net weight per package</b></td>
            <td style="width: 20%"><?= isset($sale->product_net_weight) ? $sale->product_net_weight : ""?></td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Does this product have special claims? Non-GMO, vegan, allergen free, organic etc.</b></td>
            <td style="width: 20%"><?= isset($sale->product_product_spec_claim) ? $sale->product_product_spec_claim : ""?></td>
            <td style="width: 30%"></td>
            <td style="width: 20%"></td>
        </tr>
        
        <?php if($projectService  == "ser_pre_blend"):?>
        <tr>
            <td style="width: 30%"><b>Has a sample been provided for a packaging test?</b></td>
            <td style="width: 20%"><?= isset($sale->product_sample_provide_pack) ? $sale->product_sample_provide_pack : ""?></td>
            <td style="width: 30%"><b>If a sample is provided, has the COA been submitted, as applicable?</b></td>
            <td style="width: 20%"><?= isset($sale->product_sample_coa_submit) ? $sale->product_sample_coa_submit : ""?></td>
        </tr>
        <?php endif;?>
    
        <tr>
            <td style="width: 30%"><b>Any special handling instructions? ex. Dry clean before due to allergen etc.</b></td>
            <td style="width: 20%"><?= isset($sale->product_spec_hand_instruc) ? $sale->product_spec_hand_instruc : ""?></td>
            <td style="width: 30%"><b>Are there any special ingredients required?</b></td>
            <td style="width: 20%"><?= isset($sale->product_spec_ingredient) ? $sale->product_spec_ingredient : ""?></td>
        </tr>
    </tbody>
</table>
<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style=";border: none;font-size:15;font-weight: bold;padding: 10px;text-transform: uppercase;">
                Packaging details:
            </td>
        </tr>
    </tbody>
</table>
<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="width: 30%"><b>Which type of packaging?</b></td>
            <td style="width: 20%"><?= isset($sale->pack_type_pack) ? Sale::getLabelByType($TypeOfPacking, $sale->pack_type_pack) : ""?></td>
            <td style="width: 30%"><b>Is this plain or pre-printed? </b></td>
            <td style="width: 20%"><?= isset($sale->pack_plan_print) ? Sale::getLabelByType($PackPlain,$sale->pack_plan_print) : ""?></td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Who is providing primary packaging? Customer or Dure.</b></td>
            <td style="width: 20%"><?= isset($sale->pack_provide_primary_pack) ? Sale::getLabelByType($PackCustomer, $sale->pack_provide_primary_pack) : ""?></td>
            <td style="width: 30%"><b>Who is providing inner packaging? Customer or Dure.</b></td>
            <td style="width: 20%"><?= isset($sale->pack_provide_inner_pack) ? Sale::getLabelByType($PackCustomer, $sale->pack_provide_inner_pack) : ""?></td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Who is providing the shippers? Customer or Dure.</b></td>
            <td style="width: 20%"><?= isset($sale->pack_provide_shipper) ? Sale::getLabelByType($PackCustomer,$sale->pack_provide_shipper) : ""?></td>
            <td style="width: 30%"><b>Is the Customer aware of our Shipping and Receiving Policy?</b></td>
            <td style="width: 20%"><?= (isset($sale->pack_customer_aware) && $sale->pack_customer_aware) ? ( $sale->pack_customer_aware ? "Yes" : "No") : ""?></td>
        </tr>
            
        <tr>
            <td style="width: 30%"><b>Are there any Special Shipping requirements?</b></td>
            <td style="width: 20%"><?= (isset($sale->pack_spec_ship) && $sale->pack_spec_ship) ? ($sale->pack_spec_ship ? "Yes" : "No") : ""?></td>
            <td style="width: 30%"><b>Has the Customer requested a specific pallet configuration or amount of shippers per pallet?</b></td>
            <td style="width: 20%"><?= (isset($sale->pack_customer_spec_pallet) && $sale->pack_customer_spec_pallet) ? ($sale->pack_customer_spec_pallet ? "Yes" : "No") : ""?></td>
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
            <td><?= isset($sale->note) ? $sale->note : "" ?></td>
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