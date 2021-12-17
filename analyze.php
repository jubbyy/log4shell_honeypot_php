<?php
error_reporting(E_ALL ^ E_WARNING);
$files = glob("output/*");

function isjndi($inarray){
        $k = 0;
        foreach($inarray as $key=>$val){
                $hay = json_encode($val);
                if (strstr($hay,"ldap"))
                {
                        $k=$key;
                }
        }
        return $k;
}

function ldapextract($ldapurl){
        $re = '/{jndi:(ldap:\/\/.*)}/m';
        $re2 = '/{jndi:ldap:\/\/(.*):(\d+)\//m';
        preg_match_all($re, $ldapurl, $matches, PREG_SET_ORDER, 0);
        $url = $matches[0][1];
        preg_match_all($re2, $ldapurl, $matches, PREG_SET_ORDER, 0);
        $server = $matches[0][1];
        $port = $matches[0][2];
        $ld = ldap_connect($url);
        ldap_set_option($ld,LDAP_OPT_NETWORK_TIMEOUT,3);
        $lb = ldap_bind($ld);
        $badweb = "unknown";
        if ($lb){
                $ls=ldap_search($ld,"Exploit","uid=*");
                $le = ldap_get_entries($ld,$ls);
                if (is_array($le)){
                        $badweb = $le[0]["javacodebase"][0];
                }
        }
        return array($url, $server ,$port , $badweb);
}

echo "client,key,value,jndiurl,badldap,badport,badweb" . PHP_EOL;

foreach ($files as $name=>$file){
        $item = json_decode(file_get_contents($file),1);
        $k = isjndi($item);
        if ($k){
                list($url,$server,$port,$badweb) = ldapextract($item[$k]);
                $s = "$url,$server,$port,$badweb";
                echo $item["REMOTE_ADDR"] . ",". "$k" . "," . $item[$k] ."," . $s . PHP_EOL;
        }
#       var_dump($item);
}

?>
