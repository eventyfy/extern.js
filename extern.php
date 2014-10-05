
<?php

//realesed under MIT Licence included with the downloaded package.

/* for debugging...
ini_set('display_errors',1);
error_reporting(E_ALL);
*/

class extern {

private $symbol_name;
private $symbol_scope;


   function __construct($symbol_scope,$symbol_name) {

$this->symbol_name=$symbol_name;
$this->symbol_scope=$symbol_scope;


	if(!self::exists($symbol_scope,$symbol_name)){
		self::UpdateSymbol($symbol_scope,$symbol_name,0,1);		//write new symbol to file

	}
	
	
	
	
	


	
   } 
   function value($value=null){
$ret=0;
	if (!count(func_get_args()))
		$ret=self::ReadSymbol($this->symbol_scope,$this->symbol_name);
	else
		self::UpdateSymbol($this->symbol_scope,$this->symbol_name,$value);

	return $ret;
	}





static private function UpdateSymbol($scope,$symbol,$value=null,$new=null){


if(!self::exists($scope)){
//create new empty scope file
$flh=fopen(realpath(dirname(__FILE__))."/scopes/".$scope.".ini","w+");
fwrite($flh, "") 	;
fclose($flh);

}
if(self::exists($scope,$symbol) || $new ==1){  //neccesarry is the refrence has been changed...

	$arr=parse_ini_file(realpath(dirname(__FILE__))."/scopes/".$scope.".ini");

		if($new==2){
			unset($arr[$symbol]);
			
				}
		else {			
			$arr[$symbol]=$value;
				}




$flh=fopen(realpath(dirname(__FILE__))."/scopes/".$scope.".ini","w");
foreach($arr as $key => $value){
	fwrite($flh, $key."=".$value."\n") 	;
		}
	fclose($flh);
}

else {
	echo "Extern Library Error: Trying to write to a non existing symbol $symbol in the scope $scope";
	}
	

}

static private function ReadSymbol($scope,$symbol){
$ret="undefined";

if(self::exists($scope,$symbol)){

$arr=parse_ini_file(realpath(dirname(__FILE__))."/scopes/".$scope.".ini");
$ret=$arr[$symbol];
}


return $ret;


	}

static public function sizeOf($scope) {

$ret=-1;

if(self::exists($scope)){

$arr=parse_ini_file(realpath(dirname(__FILE__))."/scopes/".$scope.".ini");
$ret=sizeOf($arr);
}
return $ret;
}


static public function exists($scope,$symbol=null){
$ret=false;

if(!file_exists(realpath(dirname(__FILE__))."/scopes/".$scope.".ini")){
	return false;	
}


else if($symbol){

$arr=parse_ini_file(realpath(dirname(__FILE__))."/scopes/".$scope.".ini");


	return isset($arr[$symbol]);
}
else
{

return true;
}

}






 public function delete() {
	self::UpdateSymbol($this->symbol_scope,$this->symbol_name,null,2);

}






}







?>

