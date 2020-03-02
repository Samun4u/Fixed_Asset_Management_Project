
<?php
require('head_c.php');
$_SESSION['menu']='product';
if(isset($_POST['quantity'])){
  $data=$_POST;
  $data['admin_id']=$_SESSION['adminID'];
  $data1=$obj->db->query('select max(invoice_no) as d from stock_out');
  $data['invoice_no']=(int)$data1->fetch(PDO::FETCH_ASSOC)['d']+1;

  $obj->insert('stock_out',$data);

}
$data=$obj->getData('product',1);

?>
 <?php
  require('leftMenu.php');
  ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<input type="hidden" id="inc" value="0">
<table class="table table-bordered" id="tbl">
	<thead>
		<tr>
			<th>Select product</th>
			<th><select class="form-control" onChange="get_data()" id="code">
				<option value="">Select product</option>
				 <?php while ($d=$data->fetch(PDO::FETCH_ASSOC)) { ?>
					<option value="<?php echo $d['id'] ?>"><?php echo $d['name'] ?></option>
					<?php } ?>
				</select></th>
				<th colspan="4"></th>
			</tr>
			<tr>
				<th>SL</th>
				<th>Name</th>
				<th>Price</th>
				<th>QTY</th>
				<th>Total</th>
				<th></th>
			</tr>
		</thead>
		<tbody id="body">
	</tbody>
	<tfoot>
		<tr>
			<th class="text-right" colspan="4">Sub-Total</th>
			<th id="sub"></th>
			<th></th>
		</tr>
		<tr>
			<th class="text-right" colspan="4">Discount</th>
			<th id="dis">
				<input type="text" onkeyup="dis_calculate()" id="d" value="0" class="form-control">
			</th>
			<th></th>
		</tr>
		<tr>
			<th class="text-right" colspan="4">Total</th>
			<th id="to"></th>
			<th></th>
		</tr>
	</tfoot>
</table>


<script type="text/javascript" src="jquery-3.4.1.min.js"></script>
<script>
	function get_data(){
		var i=(parseInt($('#inc').val()))+1
		$('#inc').val(i)
			// i+=1
			var p_id=$('#code').val()
			if(p_id!=''){
			$.ajax({
				url: "get_product_info.php", 
				type: 'POST',  
				dataType: "json",
				data: { 
					productID: p_id 
				}, 
				success: function(data){
					var msg='Are you sure?'
					var ht='<tr id="r_'+i+'">'
					ht+='<td>'+i+'</td>'
					ht+='<td><input type="text" class="form-control" value="'+data.name+'"></td>'
					ht+='<td><input onkeyup="calculate('+i+')" id="p_'+i+'" readonly value="'+data.price+'"  type="text" class="form-control" ></td>'
					ht+='<td><input onkeyup="calculate('+i+')" id="q_'+i+'" value="0" type="text" class="form-control" tabindex="'+i+'"></td>'
					ht+='<td><input id="t_'+i+'" type="text" readonly value="0" class="form-control tt"></td>'
					ht+='<td><a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="remove('+i+')">-</a></td>'
					ht+='</tr>';
					$('#body').append(ht)
				}
			});
}
			
		}

function remove(id){
	$('#r_'+id).remove()
	var tt=0;
	$('.tt').each(function(){
		tt+=parseFloat($(this).val())
	})
	$('#sub').html(tt)
	var d=parseFloat($('#d').val())
	var discounted=(tt*d)/100
	$('#to').html(tt-discounted)
	var ii=0
	$('table tr td:first-child').each(function() {
		$(this).html(++ii)
	});
	$('#inc').val(ii)
}
function calculate(id) {
	var price=parseFloat($('#p_'+id).val())
	var qty=parseFloat($('#q_'+id).val())
	var total=price*qty
	$('#t_'+id).val(total)
	var tt=0;
	$('.tt').each(function(){
		tt+=parseFloat($(this).val())
	})
	$('#sub').html(tt)
	var d=parseFloat($('#d').val())
	var discounted=(tt*d)/100
	$('#to').html(tt-discounted)
}
function dis_calculate () {
	var tt=parseFloat($('#sub').html())

	var d=parseFloat($('#d').val())
	var discounted=(tt*d)/100
	$('#to').html(tt-discounted)
}
</script>