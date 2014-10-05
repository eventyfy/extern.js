<?php


$scope=$_GET['scope'];
$symbol=$_GET['symbol'];

if(file_exists(realpath(dirname(__FILE__))."/scopes/".$scope.".ini")){

$arr=parse_ini_file(realpath(dirname(__FILE__))."/scopes/".$scope.".ini");
echo $arr[$symbol];

}

else{

echo "undefined";

}


?>
