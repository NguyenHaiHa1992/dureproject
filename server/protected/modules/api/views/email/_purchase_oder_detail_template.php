<style>
#order_info table, #order_info td, #order_info th,
#order_detail table, #order_detail td, #order_detail th  {
    border: 1px solid #DFDFDF;
    padding: 5px;
}
</style>

<table id="order_info" style="width: 100%; border-collapse:collapse;" border="1" cellpadding="5" cellspacing="0">
	<thead>
		<tr>
			<th colspan="2" bgcolor="#DFDFDF"><b>ORDER INFORMATION</b></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>ORDER CODE</td>
			<td><?php echo $purchase_order->po_code;?></td>
		</tr>
		<tr>
			<td>Order date</td>
			<td><?php echo date('d/m/Y', $purchase_order->order_date);?></td>
		</tr>
		<tr>
			<td>Delivery date</td>
			<td><?php echo date('d/m/Y', $purchase_order->delivery_date);?></td>
		</tr>
		<tr>
			<td>Entered date</td>
			<td><?php echo date('d/m/Y', $purchase_order->entered_date);?></td>
		</tr>
		<tr>
			<td>Shipping address</td>
			<td><?php echo $purchase_order->shipping_address;?></td>
		</tr>
	</tbody>
</table>
<br />
<table id="order_detail" style="width: 100%; border-collapse:collapse;" border="1" cellpadding="5" cellspacing="0">
	<thead>
		<tr>
			<th colspan="11" bgcolor="#DFDFDF"><b>ORDER DETAILS</b></th>
		</tr>
		<tr>
			<th align="left"><b>No</b></th>
			<th align="left"><b>PART CODE</b></th>
			<th align="left"><b>DESCRIPTION</b></th>
			<th align="left"><b>REVISION</b></th>
			<th align="left"><b>DRAWING</b></th>
			<th align="left"><b>DELIVERY DATE</b></th>
			<th align="left"><b>QTY</b></th>
			<th align="right"><b>PRICE</b></th>
			<th align="right"><b>TOTAL</b></th>
			<th align="right"><b>DISCOUNT</b></th>
			<th align="right"><b>FINAL TOTAL</b></th>
		</tr>
	</thead>
	<tbody>
		<?php $sub_total = 0;?>
		<?php $i=0; foreach($list_po_detail as $detail): $i++;?>
		<?php if(isset($detail->part)):?>
		<?php $price = ($detail->revised_price != 0)?$detail->revised_price: $detail->price;?>
		<?php $delivery_date = ($detail->revised_date != 0)?$detail->revised_date: $detail->delivery_date;?>
		<tr>
			<td><?php echo $i;?></td>
			<td><?php echo $detail->part->part_code;?></td>
			<td>
				<?php echo $detail->part->description;?>
				<br/>
				<?php echo isset($detail->part->material)?($detail->part->material->material_code." - ".$detail->part->material->category->name):"";?>
			</td>
			<td><?php echo $detail->part->revision;?></td>
			<td><?php if(isset($detail->part->drawing_file)):?><a href="<?php echo FileService::getAbsoluteUrl($detail->part->drawing_file_id);?>" target=_blank>File</a><?php endif;?></td>
			<td><?php echo date('d/m/Y', $delivery_date);?></td>
			<td><?php echo $detail->quantity;?></td>
			<td align="right">$ <?php echo number_format($price,2,".",",");?></td>
			<td align="right"><b><?php echo number_format($price * $detail->quantity,2,".",",");?></b></td>
			<td align="right"><?php echo number_format($detail->discount,2,".",",");?>%</td>
			<?php $detail_price = $price * $detail->quantity * (100 - $detail->discount)/100 ;?>
			<td align="right">$ <?php echo number_format($detail_price,2,".",",");?></td>
			<?php $sub_total = $sub_total + $detail_price;?>
		</tr>
		<?php endif;?>
		<?php endforeach;?>

		<tr>
			<td colspan="11" align="left"><b>Other Items</b></td>
		</tr>
		<tr>
			<td align="left"><b>No</b></td>
			<td align="left" colspan="5"><b>ITEM NAME</b></td>
			<td align="left"><b>QTY</b></td>
			<td align="right"><b>PRICE</b></td>
			<td align="right" colspan="3"><b>TOTAL</b></td>
		</tr>
		<?php $j = 0; foreach($list_po_items as $po_item): $j++;?>
		<tr>
			<td><?php echo $j;?></td>
			<td colspan="5"><?php echo $po_item->item_name;?></td>
			<td><?php echo $po_item->quantity;?></td>
			<td align="right">$ <?php echo number_format($po_item->price,2,".",",");?></td>
			<?php $item_price = number_format($po_item->price * $po_item->quantity,2,".",",");?>
			<td align="right" colspan="3"><b><?php echo $item_price;?></b></td>
			<?php $sub_total = $sub_total + $item_price;?>
		</tr>
		<?php endforeach;?>

		<tr>
			<td colspan="11" align="left" bgcolor="#F3F3F3">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="10" align="left"><b>Taxable amount</b></td>
			<td align="right"><b>$ <?php echo number_format($sub_total,2,".",",");?></b></td>
		</tr>
		<tr>
			<td colspan="9" align="left"><b>Tax total</b></td>
			<td align="right"><?php echo number_format($purchase_order->tax, 2,".",",");?> %</td>
			<?php $tax = $purchase_order->tax; $total = $sub_total + $sub_total * $tax /100; ?>
			<td align="right"><b>$ <?php echo number_format($sub_total * $tax / 100,2,".",",");?></b></td>
		</tr>
		<tr>
			<td colspan="10" align="center"><b>Final amount</b></td>
			<td align="right"><b>$ <?php echo number_format($total,2,".",",");?></b></td>
		</tr>
	</tbody>
</table>
<br />
<hr />
<b>Order Details:</b> <?php echo $purchase_order->note;?>