<?php include ('header.php'); 
include ('inc/dbConnect.inc.php');
require_once "../localization.php";






$insertintotable = ("UPDATE orders SET order_view='1'");	
if (mysql_query($insertintotable)) { }






?>

		  <div class="warper container-fluid">
        	
            <div class="page-header"><h3><?php echo gettext("Orders");?><small>Information</small></h3></div>
			
			
			
			
			        <div class="panel panel-default">
                    <div class="panel-heading"><?php echo gettext("Orders");?></div>
                    <div class="panel-body">
                    
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="basic-datatable">
                            <thead>
                                <tr>
                                    <!--<th>Order Code</th>-->
									 <th><?php echo gettext("Order Code");?><br /><?php echo gettext("Recipient Name");?><br /><?php echo gettext("Phone Number");?></th>
									 <th><?php echo gettext("Product");?></th>
									  <th><?php echo gettext("Price");?></th>
									   <th><?php echo gettext("Total");?></th>
									    <th><?php echo gettext("Grand Total");?></th>
									   <th><?php echo gettext("Date Time");?></th>
									    <th><?php echo gettext("Status");?></th>
						
						
                                </tr>
                            </thead>
                            <tbody>
							
						









						
							<?php
	$sql = "SELECT *, sum(quantity) as quantity, GROUP_CONCAT(product_id SEPARATOR ',') as product_id from orders where random_rick = 'expire' group by generate_code order by order_id desc";
    $query = mysql_query($sql) or die(mysql_error());
    while ($result = mysql_fetch_array($query)) {
	    $order_id = $result['order_id'];
		$customer_id = $result['customer_id'];	
$product_id = $result['product_id'];
$quantity = $result['quantity'];
$date_time = $result['date_time'];	
$date = date("F d, Y",strtotime($date_time));
$time = date("H:i:s A",strtotime($date_time));
$generate_code = $result['generate_code'];
$order_status = $result['order_status'];			
?>	




 
 
 
 
 <tr class="odd gradeX">
 
 
 

 
 
 
 
<!--<td><span style="color:#ee3682;"><?php echo $generate_code; ?></span></td>	-->
<td>
										
										
										
										
<?php
	$sql1 = "SELECT * from customers where customer_id = '$customer_id'";
    $query1 = mysql_query($sql1) or die(mysql_error());
    while ($result1 = mysql_fetch_array($query1)) {
		$username = $result1['username'];	
$home_address = $result1['home_address'];			
$phone_number = $result1['phone_number'];			
		
?>								
							<span style="color:#ee3682;"><?php echo $generate_code; ?></span>	<br />		
							<?php echo $username; ?><br />	<?php echo $phone_number; ?>		
										
										
	<?php } ?>									
</td>
										
										
										
<td>	
<?php
	$sql1 = "SELECT * from products where product_id IN($product_id)";
    $query1 = mysql_query($sql1) or die(mysql_error());
    while ($result1 = mysql_fetch_array($query1)) {
		$product_name = $result1['product_name'] . "<br />";	
		$product_prices = $result1['product_prices'];				
?>	

 <?php echo $product_name; ?>

<?php } ?>	


</td>	


<td>


<?php
	$sql12 = "SELECT product_prices,product_id from products where product_id IN($product_id)";
	
    $query12 = mysql_query($sql12) or die(mysql_error());
    while ($result12 = mysql_fetch_array($query12)) {
$product_prices1 = $result12['product_prices'];		
$product_ids = $result12['product_id'];			
?>	

								
	<?php
	$sql1or = "SELECT sum(quantity) as quantity from orders where product_id = '$product_ids' and  generate_code = '$generate_code' group by product_id";
	
    $query1or = mysql_query($sql1or) or die(mysql_error());
    while ($result1or = mysql_fetch_array($query1or)) {
		$quantity = $result1or['quantity'];
?>


<center><?php echo number_format($product_prices1); ?>€ X <?php echo $quantity; ?><br /></center>

<?php } ?>	

<?php } ?>	



</td>							




<td>


<?php
	$sql12er = "SELECT product_prices,product_id from products where product_id IN($product_id)";
	
    $query1ss2 = mysql_query($sql12er) or die(mysql_error());
    while ($resultss12 = mysql_fetch_array($query1ss2)) {
$product_prices1er = $resultss12['product_prices'];		
$product_idss = $resultss12['product_id'];			
?>	

								
	<?php
	$sql1oraa = "SELECT sum(quantity) as quantity from orders where product_id = '$product_idss' and  generate_code = '$generate_code' group by product_id";
	
    $query1ssor = mysql_query($sql1oraa) or die(mysql_error());
    while ($result1ossr = mysql_fetch_array($query1ssor)) {
		$quantitys = $result1ossr['quantity'];
?>


<center><?php echo number_format($product_prices1er * $quantitys); ?>€<br /></center>

<?php } ?>	

<?php } ?>	



</td>	


<td>
										
										
	


								
	<?php
	$sql1oaaraa = "SELECT sum(quantity * p.product_prices) as product_prices  from orders ord inner JOIN products p 
ON ord.product_id=p.product_id where ord.product_id IN($product_id) and ord.generate_code = '$generate_code'";

    $querssy1ssor = mysql_query($sql1oaaraa) or die(mysql_error());
    while ($result1bbossr = mysql_fetch_array($querssy1ssor)) {
	$product_pricesdd = $result1bbossr['product_prices'];
?>
<?php } ?>	

<?php $my_totalling = $product_pricesdd + 2; ?>
Total: <span style="color:#ee3682;text-decoration: underline;"><?php echo number_format($product_pricesdd, 2, '.', ','); ?>€</span><br />
    <?php echo gettext("Delivery Charges: ");?><span style="color:#ee3682;text-decoration: underline;">2€</span><br />
Grand Total: <span style="color:#ee3682;text-decoration: underline;"><?php echo number_format($my_totalling, 2, '.', ','); ?>€</span>

										</td>
										<td><center><?php echo $date; ?><br /><?php echo $time; ?></center></td>
										<td>
										
										<?php if($order_status == 'Wait'){ ?>
										<span style="color:orange; font-weight:bold;"><?php echo $order_status; ?></span>
										<?php } ?>
										<?php if($order_status == 'Buy'){ ?>
										<span style="color:green; font-weight:bold;"><?php echo $order_status; ?></span>
										<?php } ?>
										<?php if($order_status == 'Deliveret'){ ?>
										<span style="color:black; font-weight:bold;"><?php echo $order_status; ?></span>
										<?php } ?>
										
										<br />
										
				<input type="hidden" id="generate_code_<?php echo $generate_code; ?>" name="generate_code_<?php echo $generate_code; ?>" value="<?php echo $generate_code; ?>">
				 <select class="form-control" name="order_status_<?php echo $generate_code; ?>" id="order_status_<?php echo $generate_code; ?>">
                                      	  <option value="0"><?php echo gettext("Change Order Status");?></option>
										  <option value="Wait"><?php echo gettext("Wait");?></option>
										  <option value="Buy"><?php echo gettext("Buy");?></option>
										  <option value="Deliveret"><?php echo gettext("Deliveret");?></option>
                                      
                   </select>						
										
										
										
										
										</td>
											 
                                        </tr>

	<?php } ?>
	

                            </tbody>
                        </table>

                    </div>
                </div>
				
				
            </div>

<?php include ('footer.php'); ?>




<?php
	$sqlgen = "SELECT *, sum(quantity) as quantity, GROUP_CONCAT(product_id SEPARATOR ',') as product_id from orders where random_rick = 'expire' group by generate_code order by order_id desc";
    $querygen = mysql_query($sqlgen) or die(mysql_error());
    while ($resultgen = mysql_fetch_array($querygen)) {
	$generate_code = $resultgen['generate_code'];	
?>	




<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#order_status_<?php echo $generate_code; ?>').change(function(){
		
		
		var generate_code=jQuery('#generate_code_<?php echo $generate_code; ?>').val();
		var order_status=jQuery('#order_status_<?php echo $generate_code; ?>').val();
		
		if(order_status=="0"){
			jQuery('#order_status_<?php echo $generate_code; ?>').attr('style','border:1px solid red;');
		}else{
		
		var userdata= "generate_code="+generate_code+"&order_status="+order_status;
			jQuery.ajax({
				type:"post",
				data:userdata,
				url:"update_status.php",
				cache:false,
				success:function(msg){

						alert("Successfully Updated.");
						window.location='orders.php';
						
				}
			});	
		
		}
		
	});
});
</script>


	<?php } ?>