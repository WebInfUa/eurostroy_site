/*
	Users groups access editor script
*/
$("#prog_process").click(function(){
	$(".alert-margin").show().html("Обработка файлов...");
	$.ajax({
		type: "POST",  
		url: "modules/tv_import/async.php",  
		responseType: "json",
		data: 
			"type=prog&action=process"
			, 
			success: function(html){ 
				var data=$.parseJSON(html);
				if(data.ready!=""){
					$(".alert-margin").html("Обработано файлов: <b>"+data.ready+"/"+data.all+"</b><br />Теперь вы можете <a href=\"/admin/?module=tv_import\"><b>обновить</b></a> страницу.");
				}
			}
	});
});
$(".check").click(function(){
	if($(this).is(":checked")){
		allow="1";
	} else {
		allow="0";
	} 
	result=$(this).parent().find(".result");
	$.ajax({
		type: "POST",  
		url: "modules/users_groups/async.php",  
		data: 
			"group="+$(this).attr("group")+
			"&module="+$(this).attr("module")+
			"&action="+$(this).attr("action")+
			"&allow="+allow
			, 
			success: function(html){ 
				result.fadeIn(200).delay(2000).fadeOut(200);
			}
	});
});