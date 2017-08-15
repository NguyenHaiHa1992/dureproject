<?php
$getListSignage = $store->getListSignage();
include(Yii::getPathOfAlias('webroot').'/protected/models/StoreFixture.php');
include(Yii::getPathOfAlias('webroot').'/protected/models/StoreSignage.php');
$dataGetInfo = array(
    'sort_attribute' => "created_time",
    'sort_type' => "DESC",
    'store_id' => $store->id,
);
//state short
$state_short = $store->state ? $store->state->state_short : "";

$listSignageDetails = StoreSignageService::getAll($dataGetInfo);
$listSignage = isset($listSignageDetails['success']) && $listSignageDetails['success'] && isset($listSignageDetails['signages'])
        ? $listSignageDetails['signages'] : array();

// store fixture
$listFixtureDetails = StoreFixtureService::getAll($dataGetInfo);
$listFixture = isset($listFixtureDetails['success']) && $listFixtureDetails['success'] && isset($listFixtureDetails['fixtures'])
        ? $listFixtureDetails['fixtures'] : array();

// store document
$storeTmpFileIds = $store->tmp_file_ids;
$documentsTmp = FileService::getFilesByIds(['ids' => $storeTmpFileIds]);
$documents = isset($documentsTmp['success']) && $documentsTmp['success'] && isset($documentsTmp['files'])
        ? $documentsTmp['files'] : array();
?>
<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="store_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="width: 30%"><b>Name</b></td>
            <td style="width: 70%"><?= $store->name;?></td>
        </tr>
        <tr>
            <td><b>Contact Name</b></td>
            <td><?= $store->contact_name;?></td>
        </tr>
        <tr>
            <td><b>Store Number</b></td>
            <td><?= $store->store_number;?></td>
        </tr>
        <tr>
            <td><b>Franchisee Name</b></td>
            <td><?= $store->franchisee_name;?></td>
        </tr>
        <tr>
            <td><b>Tier</b></td>
            <td><?= $store->tier->name;?></td>
        </tr>
        <tr>
            <td><b>Email</b></td>
            <td><?= $store->email;?></td>
        </tr>
        <tr>
            <td><b>Phone</b></td>
            <td><?= $store->phone;?></td>
        </tr>
        <tr>
            <td><b>Address</b></td>
            <td><?= $store->address1;?></td>
        </tr>
        <tr>
            <td><b>City</b></td>
            <td><?= $store->city;?></td>
        </tr>
        <tr>
            <td><b>Zipcode</b></td>
            <td><?= $store->zipcode;?></td>
        </tr>
        <tr>
            <td><b>State</b></td>
            <td><?= $state_short;?></td>
        </tr>
        <tr>
            <td><b>Country</b></td>
            <td><?= $store->country;?></td>
        </tr>
    </tbody>
</table>
<br/>

Store signage
<table style="font-family:Arial, Helvetica,san-serif;font-size:10pt" class="store_detail_table" border="1" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th>#</th>
            <th>Specification Image</th>
            <th>Example Image</th>
            <th>Code</th>
            <th>Category</th>
            <th>Material</th>
            <th>Size</th>
            <th>Description</th>
        </tr>
        <?php
        $signageKey = 0;
        if($getListSignage):
        foreach($getListSignage as $signageItem):
            $signageKey++;
            $signageItemCode = "";
            $signageItemCodeDetail = isset($signageItem['code']) ? $signageItem['code'] : "";
            $signageItemCat = isset($signageItem['category_name']) ? $signageItem['category_name'] : "";
            $signageMaterial = isset($signageItem['material']) ? $signageItem['material'] : "";
            $signageSize = isset($signageItem['size']) ? $signageItem['size'] : "";
            $signageItemNote = "";
            foreach ($listSignage as $signageItemDetail) {
                if(isset($signageItem['signage_id']) && $signageItemDetail['id'] == $signageItem['signage_id']){
                    $signageItemCode = isset($signageItemDetail['code']) ? $signageItemDetail['code'] : "";
                    $signageItemNote = isset($signageItemDetail['note']) ? $signageItemDetail['note'] : "";
                }
            }
        ?>
        <tr>
            <td><?= $signageKey ?></td>
            <td align="CENTER">
                <img src="<?= $signageItem['signage_image_id'] ?>"/>
            </td>
            <td align="CENTER">
                <img src="<?= $signageItem['signage_example_image'] ?>"/>
            </td>
            <td><?= $signageItemCode ?></td>
            <td><?= $signageItemCat ?></td>
            <td><?= $signageMaterial ?></td>
            <td><?= $signageSize ?></td>
            <td><?= $signageItem['short_description'] ?></td>
        </tr>
        <?php
        endforeach;
        endif;
        ?>
    </tbody>
</table>
<br/>

Store fixtures
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
        if($listFixtureDetails):
        foreach($listFixture as $fixtureItem):
            $fixtureKey++;
            $fixtureItemCode = isset($fixtureItem['code']) ? $fixtureItem['code'] : "";
            $fixtureItemCodeDetail = isset($fixtureItem['store_fixture_code']) ? $fixtureItem['store_fixture_code'] : "";
            $fixtureItemCat = isset($fixtureItem['category_name']) ? $fixtureItem['category_name'] : "";
            $fixtureItemNote = isset($fixtureItem['store_fixture_note']) ? $fixtureItem['store_fixture_note'] : "";
        ?>
        <tr>
            <td><?= $fixtureKey ?></td>
            <td align="CENTER">
                <img src="<?= $fixtureItem['image_id_src'] ?>"/>
            </td>
            <td><?= $fixtureItemCode ?></td>
            <td><?= $fixtureItemCat ?></td>
            <td><?= $fixtureItem['short_description'] ?></td>
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
            <td><?= $store->note ?></td>
        </tr>
    </tbody>
</table>
<br/>

<img class="thumbnail" style="width: 100%" src="<?= isset($store->image)?("/home/pmasset/public_html/".$store->image->getUrl(false)):"";?>" />
<p style="text-align: center;"><i>Store image</i></p>
<br/>
<img class="thumbnail" style="width: 100%" src="<?= isset($store->layout)?("/home/pmasset/public_html/".$store->layout->getUrl(false)):"";?>" />
<p style="text-align: center;"><i>Store layout</i></p>
<style>
html,body *{
    font-family: Arial, Helvetica,san-serif !important;
    font-size: 10pt;
}
.store_detail_table td{
    border: 1px solid #DFDFDF;
}
.thumbnail{
    padding: 5px;
    border: 1px solid #DFDFDF;
    border-radius: 3px;
}
</style>