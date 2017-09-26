<?php
$tmpFileIds = isset($packProduct->tmp_file_ids) ? $packProduct->tmp_file_ids : 0;
$documentsTmp = FileService::getFilesByIds(['ids' => $tmpFileIds]);
$documents = isset($documentsTmp['success']) && $documentsTmp['success'] && isset($documentsTmp['files'])
        ? $documentsTmp['files'] : array();
// customer
$customer_id = isset($packProduct->customer_id) ? (int)$packProduct->customer_id : 0;
$customer = Customer::model()->findByPk($customer_id);
$customerName = $customer ? $customer->ship_address : "";
?>

<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="color:#FAFAFA;border: none;font-size: x-large;font-weight: bold;text-align: center;display: block;padding: 10px;position: relative;background: #4d4d4f;text-transform: uppercase;">
                PACKAGING TEST/ PRODUCT
            </td>
        </tr>
    </tbody>
</table>

<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style=";border: none;font-size:15;font-weight: bold;padding: 10px;text-transform: uppercase;">
                Who has performed the test :
            </td>
        </tr>
    </tbody>
</table>

<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="width: 30%"><b>Name</b></td>
            <td style="width: 20%"><?= $customerName?></td>
            <td style="width: 30%">Date</td>
            <td style="width: 20%"><?= isset($packProduct->date) ? date("d-M-Y" , $packProduct->date) : ""?></td>
        </tr>
    </tbody>
</table>

<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style=";border: none;font-size:15;font-weight: bold;padding: 10px;text-transform: uppercase;">
                Packaging test and results:
            </td>
        </tr>
    </tbody>
</table>

<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="width: 30%"><b>Packaging test and results:</b></td>
            <td style="width: 20%"><?= isset($packProduct->begin_sample_weight)? $packProduct->begin_sample_weight :""?></td>
            <td style="width: 30%">Packaging used</td>
            <td style="width: 20%"><?= isset($packProduct->pack_use) ? $packProduct->pack_use : ""?></td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Net weight</b></td>
            <td style="width: 20%"><?= isset($packProduct->net_weight)? $packProduct->net_weight :""?></td>
            <td style="width: 30%">Density</td>
            <td style="width: 20%"><?= isset($packProduct->density) ? $packProduct->density : ""?></td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Length of packaging</b></td>
            <td style="width: 20%"><?= isset($packProduct->length_pack)? $packProduct->length_pack :""?></td>
            <td style="width: 30%">Long heat temperature</td>
            <td style="width: 20%"><?= isset($packProduct->long_heart_temp) ? $packProduct->long_heart_temp : ""?></td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Cross heat temperature</b></td>
            <td style="width: 20%"><?= isset($packProduct->cross_heart_temp)? $packProduct->cross_heart_temp :""?></td>
            <td style="width: 30%">Dose Volume</td>
            <td style="width: 20%"><?= isset($packProduct->dose_volume) ? $packProduct->dose_volume : ""?></td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Rev Dose</b></td>
            <td style="width: 20%"><?= isset($packProduct->rev_dose)? $packProduct->rev_dose :""?></td>
            <td style="width: 30%">Auger Speed</td>
            <td style="width: 20%"><?= isset($packProduct->auger_speed) ? $packProduct->auger_speed : ""?></td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Packages per minute</b></td>
            <td style="width: 20%"><?= isset($packProduct->pack_per_minute)? $packProduct->pack_per_minute :""?></td>
            <td style="width: 30%">Amount left in system</td>
            <td style="width: 20%"><?= isset($packProduct->amount_left) ? $packProduct->amount_left : ""?></td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Carton used</b></td>
            <td style="width: 20%"><?= isset($packProduct->carton_use)? $packProduct->carton_use :""?></td>
            <td style="width: 30%">Amount per carton</td>
            <td style="width: 20%"><?= isset($packProduct->amoutn_per_carton) ? $packProduct->amoutn_per_carton : ""?></td>
        </tr>
        
         <tr>
            <td style="width: 30%"><b>Weight of carton (including carton)</b></td>
            <td style="width: 20%"><?= isset($packProduct->weight_carton)? $packProduct->weight_carton :""?></td>            
        </tr>
        
    </tbody>
</table>

<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style=";border: none;font-size:15;font-weight: bold;padding: 10px;text-transform: uppercase;">
                Production Approval:
            </td>
        </tr>
    </tbody>
</table>

<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="width: 30%"><b>Plant Manager</b></td>
            <td style="width: 20%"><?= isset($packProduct->plant_manager)? $packProduct->plant_manager :""?></td>
            <td style="width: 30%">Date</td>
            <td style="width: 20%"><?= isset($packProduct->plant_manager_date) ? date("d-M-Y" , $packProduct->plant_manager_date) : ""?></td>
        </tr>
        
        <tr>
            <td style="width: 30%"><b>Packaging configuration ie. Packages per carton etc.</b></td>
            <td style="width: 20%"><?= isset($packProduct->pack_per_carton)? $packProduct->pack_per_carton :""?></td>
            <td style="width: 30%">Has the Customer requested a specific pallet configuration or amount of shippers per pallet?</td>
            <td style="width: 20%"><?= isset($packProduct->customer_request_spec) ? $packProduct->customer_request_spec : ""?></td>
        </tr>

        <tr>
            <td style="width: 30%"><b>Package net weight</b></td>
            <td style="width: 20%"><?= isset($packProduct->pack_net_weight)? $packProduct->pack_net_weight :""?></td>
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
            $thumbnail = isset($document['thumbnail']) ? $document['thumbnail'] : "";
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
            <td><?= isset($packProduct->note) ? $packProduct->note : ""?></td>
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