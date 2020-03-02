
<br>
Number One=<input type="text" id="n1"><br>
Number Two=<input type="text" id="n2"><br>
<span id="f">A</span> + <span id='t'>B</span> = <input type="text" id="j"><br>
<span id="data"></span><br><br>
<button type="button" id="bb">Submit</button>

<script type="text/javascript" src="../jquery-3.4.1.min.js"></script>

<script>
function loadDoc () {
	var a=document.getElementById('n1').value
	var b=document.getElementById('n2').value
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		document.getElementById('data').innerHTML=JSON.parse(this.responseText).status
		document.getElementById('j').value=JSON.parse(this.responseText).result
		document.getElementById('f').innerHTML=JSON.parse(this.responseText).n1
		document.getElementById('t').innerHTML=JSON.parse(this.responseText).n2
	}
	xhttp.open("POST", "get_data.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send('n1='+a+'&n2='+b);
}
$(document).ready(function() {
	$('#bb').click(function(){
		var a =$('#n1').val()
		var b =$('#n2').val()
		$.ajax({
			url: "get_data.php", 
			type: 'POST',  
			dataType: "json",
    		data: { 
    			n1: a,
    			n2:b 
    		}, 
			success: function(result){
				$('#f').html(result.n1)
				$('#t').html(result.n2)
				$('#data').html(result.status)
				$('#j').val(result.results)
			}});
	})
})
</script>
