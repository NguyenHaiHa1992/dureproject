<?php
$tmpFileIds = $project->tmp_file_ids;
$documentsTmp = FileService::getFilesByIds(['ids' => $tmpFileIds]);
$documents = isset($documentsTmp['success']) && $documentsTmp['success'] && isset($documentsTmp['files'])
        ? $documentsTmp['files'] : array();

// customer
$customer = Customer::model()->findByPk($project->customer_id);
$customerName = $customer ? $customer->ship_address : "";
?>

<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="color:#FAFAFA;border: none;font-size: x-large;font-weight: bold;text-align: center;display: block;padding: 10px;position: relative;background: #4d4d4f;text-transform: uppercase;">
            Project Details
            </td>
        </tr>
    </tbody>
</table>
<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="width: 30%"><b>Date </b></td>
            <td style="width: 20%"><?= date("d-m-Y",$project->date);?></td>
            <td style="width: 30%"><b>Primary Contact</b></td>
            <td style="width: 20%"><?= $project->primary_contact;?></td>
        </tr>
        <tr>
            <td><b>Company</b></td>
            <td><?= $customerName;?></td>
            <td><b>Project#</b></td>
            <td><?= $project->project_number;?></td>
        </tr>
        <tr>
            <td><b>Brand/Product</b></td>
            <td><?=$project->project_name?></td>
            <td><b>Volumn</b></td>
            <td><?= $project->volume;?></td>
        </tr>
        <tr>
            <td><b>Price Point</b></td>
            <td><?= $project->price_point;?></td>
            <td><b>Life Style</b></td>
            <td><?= $project->life_style == 'type_other' ? $project->other_type_product : Project::getLabelByType($project->life_style);?></td>
        </tr>
        <tr>
            <td><b>Services Required</b></td>
            <td><?= $project->service == 'type_other' ? $project->other_service : Project::getLabelByType($project->service);?></td>
            <td><b>Product Match</b></td>
            <td><?= $project->product_match ? "Yes" : "No";?></td>
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
            <td><?= $project->note ?></td>
        </tr>
    </tbody>
</table>
<br/>
