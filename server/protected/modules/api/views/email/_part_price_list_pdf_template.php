<style>
#order_info table, #order_info td, #order_info th,
.part_pdf table, .part_pdf td, .part_pdf th  {
    border: 1px solid #DFDFDF;
    padding: 5px;
}
</style>
<table id="email_info" style="width: 100%; border-collapse:collapse;" border="0" cellpadding="5" cellspacing="0">
	<thead>
		<tr>
			<th colspan="2" bgcolor="#DFDFDF"> &nbsp; </th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="width: 50%">
				<img style="width: 200px" src="<?php echo Yii::app()->getBaseUrl(true);?>/data/images/logo.png"/>
				<div style="margin-left: 15px; font-size: 13px;"><b>Address:</b> 153 Sugar Maple Rd,</div>
				<div style="margin-left: 15px; font-size: 13px;">St George Brant,</div>
				<div style="margin-left: 15px; font-size: 13px;">ON Canada N0E 1N0</div>
				<br/>
				<div style="margin-left: 15px; font-size: 13px;"><b>Phone:</b> (519) 448-1311</div>
				<div style="margin-left: 15px; font-size: 13px;"><b>Email:</b> office@amprecision.ca</div>
			</td>
			<td style="width: 50%; vertical-align: bottom;">
				<table style="width: 100%; text-align: right;">
					<thead>
						<tr>
							<th style="width: 70%;"> </th>
							<th style="width: 70%;"> </th>
							<th style="width: 70%;"> </th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<?php if(isset($rfq_number)):?>
								<td>RFQ #:</td>
								<td><b><?php echo $rfq_number;?></b></td>
							<?php endif;?>
						<tr>
							<td>Part #:</td>
							<td><b><?php echo $part->part_code;?></b></td>
						</tr>
						<tr>
							<td>Sent:</td>
							<td><b><?php echo date('d/m/Y', time());?></b></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
<br />
<hr />
<table id="part_pdf" style="width: 100%; border-collapse:collapse;" border="1" cellpadding="5" cellspacing="0">
	<thead>
		<tr>
			<th colspan="2" bgcolor="#DFDFDF"><b>PART INFORMATION</b></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>PART CODE</td>
			<td><?php echo $part->part_code;?></td>
		</tr>
		<tr>
			<td>DESCRIPTION</td>
			<td><?php echo $part->description;?></td>
		</tr>
		<tr>
			<td>MATERIAL</td>
			<td><?php echo isset($part->material)?($part->material->material_code." - ".$part->material->category->name):"N/A";?></td>
		</tr>
		<tr>
			<td>REVISION</td>
			<td><?php echo $part->revision;?></td>
		</tr>
	</tbody>
</table>

<br />

<table class="order_detail_pdf" style="width: 100%; border-collapse:collapse;" border="1" cellpadding="5" cellspacing="0">
	<thead>
		<tr>
			<th colspan="3" bgcolor="#DFDFDF"><b>PART PRICE LIST</b></th>
		</tr>
		<tr>
			<th align="left"><b>No #</b></th>
			<th align="left"><b>UP TO</b></th>
			<th align="left"><b>($) PRICE</b></th>
		</tr>
	</thead>
	<tbody>
		<?php $sub_total = 0;?>
		<?php $i=0; foreach($list_price as $price): $i++;?>

		<tr>
			<td><?php echo $i;?></td>
			<td><?php echo $price['max'];?></td>
			<td>$ <?php echo $price['price'];?></td>
		</tr>

		<?php endforeach;?>
	</tbody>
</table>
<br />
<hr />
<p style="text-align: center; font-size: 12px;">AM Precision - Address: 153 Sugar Maple Rd, St George Brant, ON Canada N0E 1N0 - Phone: (519) 448-1311 - Email: office@amprecision.ca</p>

<?php if(isset($comment)):?>
	<br/><hr />
	<p style="text-align: left; font-size: 12px;"><?php echo $comment;?></p>
<?php endif;?>