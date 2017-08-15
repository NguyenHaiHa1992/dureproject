<div id="main_content">
	<table>
		<tr>
			<td><b>CERTIFICATE OF CONFORMANCE</b></td>
		</tr>
	</table>
	<table>
		<tr>
			<td>PART #/MAT</td>
			<td><?php echo $part_code;?></td>
			<td>REV</td>
			<td>D</td>
			<td>DESCRIPTION</td>
			<td><?php echo $part_description;?></td>
		</tr>
	</table>
	<table>
		<tr>
			<td>P.O.</td>
			<td><?php echo $purchase_order_code;?></td>
			<td>QTY ORD.</td>
			<td><?php echo $checkout_quantity;?></td>
			<td>QTY SHIPPED</td>
			<td><?php echo $heatnumber->quantity;?></td>
			<td>ITEM</td>
			<td>-</td>
		</tr>
	</table>
	<table>
		<tr>
			<td>PERSON RESPONSIBLE FOR QUALITY ASSURANCE</td>
			<td>JOE MANSOUR</td>
		</tr>
	</table>
	<table>
		<tr>
			<td>SIGNATURE</td>
			<td> </td>
		</tr>
	</table>
	<table>
		<tr>
			<td>HEAT NUMBER(S) FOR PARTS</td>
			<td> <?php echo $heatnumber->heatnumber;?> </td>
		</tr>
	</table>
	<table>
		<tr>
			<td>OTHER INFORMATION:</td>
		</tr>
	</table>
	<table>
		<tr>
			<td><b>BRASS PARTS ARE MANUFACTURED FROM ASTM B16 BRASS</b></td>
		</tr>
	</table>
	<table>
		<tr>
			<td><b>IT IS HEREBY CERTIFIED THAT THE PRODUCTS STATED ABOVE HAVE BEEN PROCESSED AND DIMENSIONALLY INSPECTED AND ARE IN ACCORDANCE WITH THE SPECIFIED PRINT AND/OR PURCHASE ORDER REQUIREMENTS. DOCUMENTS ARE MAINTAINED ON FILE AND ARE AVAILABLE FOR YOUR REVIEW.</b></td>
		</tr>
	</table>
</div>
<style type="text/css">
	#main_content{
		width: 80%;
		margin: 0 auto;
		border-top: 1px solid #333;
		font-family: 'Arial';
		font-size: 13px;
	}
	table{
	    border: none;
	    border-collapse: collapse;
	    width: 100%;
	}
	td{
		padding: 5px;
	    border: 1px solid #333;
	    border-top: none;
	}
	td b{
	    text-align: center;
	    display: block;
	}
</style>