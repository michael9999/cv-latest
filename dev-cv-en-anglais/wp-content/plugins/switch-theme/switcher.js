var switch_theme = function(){

	var act_theme = readCookie('acttheme');

	if(act_theme == ''){
		setCookie('acttheme','old',1);
	}
	else if(act_theme == 'new'){
		setCookie('acttheme','old',1);
	}
	else if(act_theme == 'old'){
		setCookie('acttheme','new',1);
	}

	
	window.location.href = 'http://www.example.com';
	
};


var setCookie = function(cookieName,cookieValue,nDays) {
 var today = new Date();
 var expire = new Date();
 if (nDays==null || nDays==0) nDays=1;
 expire.setTime(today.getTime() + 3600000*24*nDays);
 document.cookie = cookieName+"="+escape(cookieValue)+ ";path=/;expires="+expire.toGMTString();
};

var readCookie = function(cookieName) {
 var re = new RegExp('[; ]'+cookieName+'=([^\\s;]*)');
 var sMatch = (' '+document.cookie).match(re);
 if (cookieName && sMatch) return unescape(sMatch[1]);
 return '';
};


$j=jQuery.noConflict();
$j(document).ready(function(){

	var act_theme = readCookie('acttheme');

	if(act_theme == ''){
		$j('#switcherPanel a').html("Revert to Old Theme");
	}
	else if(act_theme == 'new'){
		$j('#switcherPanel a').html("Revert to Old Theme");
	}
	else if(act_theme == 'old'){
		$j('#switcherPanel a').html("Revert to New Theme");
	}

});

