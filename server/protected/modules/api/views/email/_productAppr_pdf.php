<?php
$tmpFileIds = isset($productAppr->tmp_file_ids) ? $productAppr->tmp_file_ids : 0;
$documentsTmp = FileService::getFilesByIds(['ids' => $tmpFileIds]);
$documents = isset($documentsTmp['success']) && $documentsTmp['success'] && isset($documentsTmp['files'])
        ? $documentsTmp['files'] : array();
?>

<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="color:#FAFAFA;border: none;font-size: x-large;font-weight: bold;text-align: center;display: block;padding: 10px;position: relative;background: #4d4d4f;text-transform: uppercase;">
                Approvals
            </td>
        </tr>
    </tbody>
</table>
<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="project_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="width: 30%"><b>Status</b></td>
            <td style="width: 20%"><?= (isset($productAppr->status) && $productAppr != null) ? ($productAppr->status ? "Product Approved" : "Product Not Approved") : ""?></td>
        </tr>
        <tr>
            <td style="width: 30%"><b>President</b></td>
            <td style="width: 20%"><?= isset($productAppr->president)? $productAppr->president :""?></td>
            <td style="width: 30%">Date</td>
            <td style="width: 20%"><?= isset($productAppr->president_date) ? date("d-M-Y" , $productAppr->president_date) : ""?></td>
        </tr>
        <tr>
            <td style="width: 30%"><b>QA Supervisor</b></td>
            <td style="width: 20%"><?= isset($productAppr->qa_supervisor) ? $productAppr->qa_supervisor : "";?></td>
            <td style="width: 30%">Date</td>
            <td style="width: 20%"><?= isset($productAppr->qa_supevisor_date) ? date("d-M-Y" ,$productAppr->qa_supevisor_date):""?></td>
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
            <td><?= isset($productAppr->note) ? $productAppr->note : ""?></td>
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