$(".price").change(function(){
	id=$(this).attr("id");
	price=$(this).val();
	
	$.ajax({
		type: "POST",
		url: "modules/catalog_prod/async.php",
		data:
			"id="+id+
			"&price="+price
			,
			success: function(html){
				//alert(html);
				$("#st-"+id).show();
			}
	});
});