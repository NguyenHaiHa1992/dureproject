<?php
//fixture relate
$fixtureRelated = $signage->getListRelatedFixture();
// store relate
$storeRelated = $signage->getListRelatedStore();
// store document
$tmpFileIds = $signage->tmp_file_ids;
$documentsTmp = FileService::getFilesByIds(['ids' => $tmpFileIds]);
$documents = isset($documentsTmp['success']) && $documentsTmp['success'] && isset($documentsTmp['files'])
        ? $documentsTmp['files'] : array();
?>
<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="signage_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="width: 30%"><b>Code</b></td>
            <td style="width: 70%"><?= $signage->code;?></td>
        </tr>
        <tr>
            <td><b>Category</b></td>
            <td><?= $signage->category->name;?></td>
        </tr>
        <tr>
            <td><b>Location</b></td>
            <td><?= $signage->location;?></td>
        </tr>
        <tr>
            <td><b>Size</b></td>
            <td><?= $signage->size;?></td>
        </tr>
        <tr>
            <td><b>Material</b></td>
            <td><?= $signage->material;?></td>
        </tr>
        <tr>
            <td><b>Vendor</b></td>
            <td><?= $signage->vendor;?></td>
        </tr>
        <tr>
            <td><b>Mounting</b></td>
            <td><?= $signage->getMountingLabel();?></td>
        </tr>
        <tr>
            <td><b>Changes Seasonally</b></td>
            <td><?= $signage->getChangesSeasonallyLabel();?></td>
        </tr>
        <tr>
            <td><b>Power Required</b></td>
            <td><?= $signage->getPowerRequiredLabel();?></td>
        </tr>
        <tr>
            <td><b>Language</b></td>
            <td><?= $signage->getLanguageLabel();?></td>
        </tr>
        <tr>
            <td><b>Description</b></td>
            <td><?= $signage->description;?></td>
        </tr>
    </tbody>
</table>
<br/>

Signage fixtures
<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="store_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th>#</th>
            <th>Image</th>
            <th>Code</th>
            <th>Category</th>
            <th>Description</th>
        </tr>
        <?php
        $fixtureKey = 0;
        if($fixtureRelated):
        foreach($fixtureRelated as $fixtureItem):
            $fixtureKey++;
            $fixtureItemCode = isset($fixtureItem['code']) ? $fixtureItem['code'] : "";
            $fixtureItemCategory = isset($fixtureItem['category_name']) ? $fixtureItem['category_name'] : "";
            $fixtureItemDescription = isset($fixtureItem['description']) ? $fixtureItem['description'] : "";
        ?>
        <tr>
            <td><?= $fixtureKey ?></td>
            <td align="CENTER">
                <img src="<?= $fixtureItem['image_id_src'] ?>"/>
            </td>
            <td><?= $fixtureItemCode ?></td>
            <td><?= $fixtureItemCategory ?></td>
            <td><?= $fixtureItem['short_description'] ?></td>
        </tr>
        <?php
        endforeach;
        endif;
        ?>
    </tbody>
</table>
<br/>

Signage stores
<table style="font-family:Arial, Helvetica,san-serif;font-size:8pt;table-layout: auto" class="store_detail_table" border="1" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th>#</th>
            <th>Image</th>
            <th>Name</th>
            <th>Store Number</th>
            <th>Tier</th>
            <th>Area Manager</th>
            <th>Franchisee Name</th>
            <th>Store Address</th>
            <th>Country</th>
            <th>State/ Province</th>
            <th>City</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
        <?php
        $storeKey = 0;
        if($storeRelated):
        foreach($storeRelated as $item):
            $storeKey++;
            $itemName = isset($item['name']) ? $item['name'] : "";
            $itemTier = isset($item['tier_name']) ? $item['tier_name'] : "";
            $itemStoreAddress = isset($item['address1']) ? $item['address1'] : "";
            $itemFranchisee = isset($item['franchisee_name']) ? $item['franchisee_name'] : "";
            $itemCountry = isset($item['country']) ? $item['country'] : "";
            $itemEmail = isset($item['email']) ? $item['email'] : "";
            $itemPhone = isset($item['phone']) ? $item['phone'] : "";
        ?>
        <tr>
            <td><?= $storeKey ?></td>
            <td align="CENTER">
                <img src="<?= $item['image_id_src'] ?>"/>
            </td>
            <td><?= $itemName ?></td>
            <td><?= $item['store_number'] ?></td>
            <td><?= $itemTier ?></td>
            <td><?= $item['contact_name'] ?></td>
            <td><?= $itemFranchisee ?></td>
            <td><?= $itemStoreAddress ?></td>
            <td><?= $itemCountry ?></td>
            <td><?= $item['state_name'] ?></td>
            <td><?= $item['city'] ?></td>
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
            <td><?= $signage->note ?></td>
        </tr>
    </tbody>
</table>
<br/>

<img class="thumbnail" style="width: 100%" src="<?= isset($signage->image)?("/home/pmasset/public_html/".$signage->image->getUrl(false)):"";?>" />
<p style="text-align: center;"><i>Specification Image</i></p>
<br/>
<img class="thumbnail" style="width: 100%" src="<?= isset($signage->exampleImage)?("/home/pmasset/public_html/".$signage->exampleImage->getUrl(false)):"";?>" />
<p style="text-align: center;"><i>Example Image</i></p>
<style>
html,body *{
    font-family: Arial, Helvetica,san-serif !important;
    font-size: 10pt;
}
.signage_detail_table td{
    border: 1px solid #DFDFDF;
}
.thumbnail{
    padding: 5px;
    border: 1px solid #DFDFDF;
    border-radius: 3px;
}
</style>