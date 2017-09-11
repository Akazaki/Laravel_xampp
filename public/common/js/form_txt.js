function cText(obj){
if(obj.value==obj.defaultValue){
obj.value="";
obj.style.color="#535353";
obj.style.fontWeight = "normal";
}
}

function sText(obj){
if(obj.value==""){
obj.value=obj.defaultValue;
obj.style.color="#acacac";
obj.style.fontWeight = "bold";
}
}


function dummyFocus(id){
	$('#' + id + '-dummy').hide();
	$('#' + id).show().focus();
}
function passwordBlur(id){
	if($('#' + id).val() == ''){
		$('#' + id + '-dummy').show();
		$('#' + id).hide();
	}
}