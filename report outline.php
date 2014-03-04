<script language='javascript'>
function buzz(word){
	document.getElementById("content").innerHTML=word;

}
function openPage(pageName)
{

	var page=pageName;
	var tabCount;

	
//	document.getElementById(page).style.background="#c3c3e5";
//	document.getElementsByClassName("active").innerHTML="";
		
	
	
	var newHTML=processRequest(pageName);

	if(newHTML==null){
	}
	else {
	
		document.getElementById("content").innerHTML=newHTML;
	}
	
			
	
	
}

function processRequest(url){
	var link=url;
	var response;	
	var httpObject=instantiateAjax();
	httpObject.open("GET",url,true);

	httpObject.onreadystatechange=function(){
		if(httpObject.readyState==4){
			response=httpObject.responseText;
		}
	}

	httpObject.send(null);
	return response;
	
}


function instantiateAjax(){
	var xhr;
	if(window.XMLHttpRequest){
		xhr=new XMLHttpRequest();
	}
	else if(window.ActiveXObject){
		xhr=new ActiveXObject("MicrosoftXMLHTTP");
	}

	return xhr;
}

</script>