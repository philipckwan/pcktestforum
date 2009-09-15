 <?php

function getStockSite($stockLink){
   
   if ($fp = fopen($stockLink, 'r')) {
      $content = '';
        
      while ($line = fread($fp, 1024)) {
         $content .= $line;
	 //echo $line;
      }
   }

   return $content;  
}

function processStockSite($wurl){
    
    $wrss = getStockSite($wurl);
    $name  = '-';
    $text  = '';
    
    if (strlen($wrss)>100){
        // Get company name
        $spos = strpos($wrss,'<title>')+7;
        $epos = strpos($wrss,':',$spos);
        if ($epos>$spos){
            $name = substr($wrss,$spos,$epos-$spos);
        } 
        
        // Get text
        $spos = strpos($wrss,'Last Trade:',$spos)+3;
        $spos = strpos($wrss,'<span',$spos)+5;
	$spos = strpos($wrss,'>',$spos)+1;
        $epos = strpos($wrss,'<',$spos);
        if ($epos>$spos){
           $text = substr($wrss,$spos,$epos-$spos);
        } else {
           $text = '-';
        }

    }
    
    $result['name']  = $name;
    $result['text']  = $text;
    
    return $result;
    
}

function getStockQuote($symbol){
	$url = "http://finance.yahoo.com/q?s=$symbol";
	return processStockSite($url);
}

?>