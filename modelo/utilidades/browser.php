<?php
 
class browser{
	function getBrowser($user_agent){
	 
	if(strpos($user_agent, 'MSIE') !== FALSE)
	   return 'Internet explorer';
	 elseif(strpos($user_agent, 'Edge') !== FALSE) //Microsoft Edge
	   return 'Microsoft Edge';
	 elseif(strpos($user_agent, 'Trident') !== FALSE) //IE 11
	    return 'Internet explorer';
	 elseif(strpos($user_agent, 'Opera Mini') !== FALSE)
	   return "Opera Mini";
	 elseif(strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== FALSE)
	   return "Opera";
	 elseif(strpos($user_agent, 'Firefox') !== FALSE)
	   return 'Mozilla Firefox';
	 elseif(strpos($user_agent, 'Chrome') !== FALSE)
	   return 'Google Chrome';
	 elseif(strpos($user_agent, 'Safari') !== FALSE)
	   return "Safari";
	 else
	   return 'No hemos podido detectar su navegador';
	}
}
?>