<script type="text/javascript" src="jquery-3.4.1.min.js"></script>
<script>
// $(document).ready(function(){
	// var i=0
	
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
						// var msg='Are you sure?'
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
// })

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