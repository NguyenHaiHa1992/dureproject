<?php
if(!$productDev) {
    return "";
}

$tmpFileIds = $productDev->tmp_file_ids;
$documentsTmp = FileService::getFilesByIds(['ids' => $tmpFileIds]);
$documents = isset($documentsTmp['success']) && $documentsTmp['success'] && isset($documentsTmp['files'])
        ? $documentsTmp['files'] : array();
?>
<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="width: 30%"><b>Specification sheet/nutritionals for product matching</b></td>
            <td style="width: 70%"><?= $productDev->spec_for_product?></td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Has the Customer submitted a product formula?</b></td>
            <td style="width: 70%"><?= $productDev->customer_submit_product ? "Yes" : "No";?></td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Has the Customer provided a control sample?</b></td>
            <td style="width: 70%"><?= $productDev->customer_provide_control ? "Yes" : "No";?></td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Physical specifications of product i.e, density, flowability etc.</b></td>
            <td style="width: 70%"><?= $productDev->physical_spec_product ?></td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>What allergens does this product contain?</b></td>
            <td style="width: 70%"><?= $productDev->allergent_product ?></td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Does this Customer require any special claims? Non-GMO, vegan, allergen free, organic etc.</b></td>
            <td style="width: 70%"><?= $productDev->customer_require_spec ? "Yes" : "No" ?></td>
        </tr>
        
        <?php if($productDev->customer_require_spec) : ?>
            <tr>
                <td></td>
                <td style="width: 70%"><?= $productDev->customer_require_spec_other?></td>
            </tr>
        <?php endif;?>
        
        <tr>
            <td style="width: 30%"><b>Any special handling instructions? ex. Dry clean before due to allergen etc.</b></td>
            <td style="width: 70%"><?= $productDev->spec_handing_instruction ? "Yes" : "No" ?></td>
        </tr>
        
        <?php if($productDev->spec_handing_instruction) : ?>
            <tr>
                <td></td>
                <td style="width: 70%"><?= $productDev->spec_handing_instruction_other?></td>
            </tr>
        <?php endif;?>
            
        <tr>
            <td style="width: 30%"><b>Are there any special ingredients required?</b></td>
            <td style="width: 70%"><?= $productDev->spec_ingredients_require ? "Yes" : "No" ?></td>
        </tr>
        
        <?php if($productDev->spec_ingredients_require) : ?>
            <tr>
                <td></td>
                <td style="width: 70%"><?= $productDev->spec_ingredients_require_other?></td>
            </tr>
        <?php endif;?>
            
        <tr>
            <td style="width: 30%"><b>Approved Customer Formula Code</b></td>
            <td style="width: 70%"><?= $productDev->approve_customer_formula_code ? "Yes" : "No" ?></td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Are there any known Risks or hazards associated with the ingredients (including adulteration)</b></td>
            <td style="width: 70%"><?= $productDev->risk_or_hazard_ingredient ? "Yes" : "No" ?></td>
        </tr>
        
        <?php if($productDev->risk_or_hazard_ingredient) : ?>
            <tr>
                <td></td>
                <td style="width: 70%"><?= $productDev->risk_or_hazard_ingredient_other?></td>
            </tr>
        <?php endif;?>
        
            
        <tr>
            <td style="width: 30%"><b>Is additional testing required?</b></td>
            <td style="width: 70%"><?= $productDev->additional_test_require ? "Yes" : "No" ?></td>
        </tr>
        
        <?php if($productDev->additional_test_require) : ?>
            <tr>
                <td></td>
                <td style="width: 70%"><?= $productDev->additional_test_require_other?></td>
            </tr>
        <?php endif;?>
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
            <td><?= $productDev->note ?></td>
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