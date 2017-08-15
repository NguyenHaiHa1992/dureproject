<?php
//signage relate
$signageRelated = $fixture->getListRelatedSignage();
// store relate
$storeRelated = $fixture->getListRelatedStore();
// store document
$tmpFileIds = $fixture->tmp_file_ids;
$documentsTmp = FileService::getFilesByIds(['ids' => $tmpFileIds]);
$documents = isset($documentsTmp['success']) && $documentsTmp['success'] && isset($documentsTmp['files'])
        ? $documentsTmp['files'] : array();
?>
<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="fixture_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="width: 30%"><b>Code</b></td>
            <td style="width: 70%"><?= $fixture->code;?></td>
        </tr>
        <tr>
            <td><b>Category</b></td>
            <td><?= $fixture->category->name;?></td>
        </tr>
        <tr>
            <td><b>Size</b></td>
            <td><?= $fixture->size;?></td>
        </tr>
        <tr>
            <td><b>Location</b></td>
            <td><?= $fixture->location;?></td>
        </tr>
        <tr>
            <td><b>Vendor</b></td>
            <td><?= $fixture->vendor;?></td>
        </tr>
        <tr>
            <td><b>Description</b></td>
            <td><?= $fixture->description;?></td>
        </tr>
    </tbody>
</table>
<br/>

Fixture signage
<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="store_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th>Code</th>
            <th>Category</th>
            <th>Description</th>
        </tr>
        <?php
        if($signageRelated):
        foreach($signageRelated as $item):
            $itemCode = isset($item['code']) ? $item['code'] : "";
            $itemCategory = isset($item['category_name']) ? $item['category_name'] : "";
            $itemDescription = isset($item['description']) ? $item['description'] : "";
        ?>
        <tr>
            <td><?= $itemCode ?></td>
            <td><?= $itemCategory ?></td>
            <td><?= $itemDescription ?></td>
        </tr>
        <?php
        endforeach;
        endif;
        ?>
    </tbody>
</table>
<br/>

Fixture stores
<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="store_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th>Name</th>
            <th>Tier</th>
            <th>Store address</th>
            <th>Franchisee Name</th>
            <th>Country</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
        <?php
        if($storeRelated):
        foreach($storeRelated as $item):
            $itemName = isset($item['name']) ? $item['name'] : "";
            $itemTier = isset($item['tier_name']) ? $item['tier_name'] : "";
            $itemStoreAddress = isset($item['address1']) ? $item['address1'] : "";
            $itemFranchisee = isset($item['franchisee_name']) ? $item['franchisee_name'] : "";
            $itemCountry = isset($item['country']) ? $item['country'] : "";
            $itemEmail = isset($item['email']) ? $item['email'] : "";
            $itemPhone = isset($item['phone']) ? $item['phone'] : "";
        ?>
        <tr>
            <td><?= $itemName ?></td>
            <td><?= $itemTier ?></td>
            <td><?= $itemStoreAddress ?></td>
            <td><?= $itemFranchisee ?></td>
            <td><?= $itemCountry ?></td>
            <td><?= $itemEmail ?></td>
            <td><?= $itemPhone ?></td>
        </tr>
        <?php
        endforeach;
        endif;
        ?>
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
            <td><?= $fixture->note ?></td>
        </tr>
    </tbody>
</table>
<br/>

<img class="thumbnail" style="width: 100%" src="<?= isset($fixture->image)?("/home/pmasset/public_html/".$fixture->image->getUrl(false)):"";?>" />
<p style="text-align: center;"><i>Fixture image</i></p>
<style>
html,body *{
    font-family: Arial, Helvetica,san-serif !important;
    font-size: 10pt;
}
.fixture_detail_table td{
    border: 1px solid #DFDFDF;
}
.thumbnail{
    padding: 5px;
    border: 1px solid #DFDFDF;
    border-radius: 3px;
}
</style>