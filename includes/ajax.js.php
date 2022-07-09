<?php
/*
  $Id: ajax.js.php, v1.0 2008/04/04 19:50:14 insaini Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<script language="javascript" type="text/javascript"><!--
function getObject(name) { 
   var ns4 = (document.layers) ? true : false; 
   var w3c = (document.getElementById) ? true : false; 
   var ie4 = (document.all) ? true : false; 

   if (ns4) return eval('document.' + name); 
   if (w3c) return document.getElementById(name); 
   if (ie4) return eval('document.all.' + name); 
   return false; 
}

//Gets the browser specific XmlHttpRequest Object
function getXmlHttpRequestObject() {
	if (window.XMLHttpRequest) {
		return new XMLHttpRequest();
	} else if(window.ActiveXObject) {
		return new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		alert("Your browser does not support this feature.  Please upgrade or use a different browser. Older (pre-v2.8) versions of Order Editor do not have this restriction.");
	}
}

//Our XmlHttpRequest object to get the auto suggest
var request = getXmlHttpRequestObject();
/***************************************************
 GET STATES FUNCTIONS 
 ***************************************************/
function getStates(countryID, div_element) {
	if (request.readyState == 4 || request.readyState == 0) {
		// indicator make visible here..
		getObject("indicator").style.visibility = 'visible';
		var contentType = "application/x-www-form-urlencoded; charset=UTF-8";
		var fields = "action=getStates&country="+countryID;
					
		request.open("POST", 'create_account.php', true);
		//request.onreadystatechange = getStatesRequest;
		request.onreadystatechange = function() {
			getStatesRequest(request, div_element);
		};
		
		request.setRequestHeader("Content-Type", contentType);		
		request.send(fields);
	}
}										
//Called when the AJAX response is returned.
function getStatesRequest(request, div_element) {
	if (request.readyState == 4) {
		var obj_div = getObject(div_element);
		// make hidden
		getObject('indicator').style.visibility = 'hidden';
	  obj_div.innerHTML = request.responseText;
		
		for (i=0; i<obj_div.childNodes.length; i++){
			if (obj_div.childNodes[i].nodeName=="SELECT")
				obj_div.childNodes[i].focus();
		}
	}
}
//--></script>
