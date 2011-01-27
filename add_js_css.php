<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
	
		<style>
	.classs {
	position:relative;
	float:left;
}
.classs .text {
    background-color:#000000;color:#FFF;font-weight:bold; 
	position:absolute;
	top:1px; 
	left:1px;

}
	</style>

	
	<script>

	function showuser (name,x,y)
	{ 
		$("#taggedun").show();
		$("#taggedun").text(name);
		$("#taggedun").css('top',(y-30)+'px');
		$("#taggedun").css('left',x+'px');
			//alert(x);
	}
		function taghide ()
	{
	 var oldname=$("#taggedun").text();
	setTimeout(function () { if (oldname==$("#taggedun").text()) { $("#taggedun").text(''); } },2000);
	}
	</script>
	