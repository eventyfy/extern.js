extern.js
=========

library for using  common symbols between php and javascript. Gives the illusion of common variables between the two languages.

Extern Library 1.0
Licence:MIT (available in the downloaded package)


NOTE:this library has only been used for development purposes and is yet to be used for a published web app.


The extern library enables the use of common variables between PHP and JavaScript. It allows the programer to think of these variables as "external" symbols which can be read and modified (php only) like odrinary variables.In reality, behind the scene, all that is happening is that these symbols are being stored on the hard drive of the server and both PHP and JavaSctipt(with AJAX calls) access the file containg the symbols and their values.


SCOPES:
all external "variables" are stored in a "scope" file which is basically an ini file which stores the external symbols as ini key value pair. The scope is used to group together related variables. 

SYMBOLS:
external symbols are simply variables stored inside the "scope".ini files.


Requirments:
PHP:
	PHP 5

JavaScript:
	Jquery
	multifetch.js (included in the package)


Common problems at the end of the document.

installation:
Place the package directory "extern" in your www directory. if you need to place the "extern" directory in some other location then you will need to:

1)PHP:
include the "extern.php" using proper directory location.
eg: include "dir1/subdir1/subdir2/subdir3/extern/extern.php";

2)JavaScript:
set the proper location of the extern directory using the "extern.prototype.path" property.
eg: extern.prototype.path="/dir1/subdir1/subdir2/subdir3/extern/";



The external symbols can only be created, modified and deleted in php. They are can only be READ in javascript.

Usage:

PHP:
1.include the file "extern.php"
	include "extern/extern.php";

2.Define an external symbol.
	$var1 = new extern("global","var1");
Where $var1 is the php variable holding the refrence to the extern symbol "var1" in the  "global" scope. If an extern symbol "var1" already exists in the "global" scope then a refrence will be created in $var1, otherwise if there isnt an extern symbol of the name "var1" in the "global" scope then a new symbol will be created with the default value of 0. 
if the scope name given does not exist then a new scope will be created.

2.Reading the value of an extern symbol.
	$var1->value();	//returns the value of the extern symbol "var1" being pointed by php variable $var1
3.Writing to an extern symbols
	$var1->value(10);// writes the value 10 in the exter symbol "var1" being pointed by php variable $var1




JavaScript:
1. include the js file "/extern/extern.js"


There are two ways you can access the extern symbols in JavaScript. syncs and async.

2. Sync Mode:
Sync mode is fairly straight forward and as the name suggests it uses sync ajax calls. Using this mode will freeze the broweser unless the ajax call has been completed.

2.1 To set the mode to synce set the property extern.prototype.mode to sync:
	extern.prototype.mode="sync";

2.2 Define an external symbol:
var myvar=new extern("global","var1");//where myvar is the JS variable which if pointing to the extern symbol "var1" in the scope "global"

2.3 Read the value of the extern symbol:
myvar.value();//this function will return the value of the extenal symbol being pointed by myvar.

2.4 Delete an external symbol:
  myvar.delete();

3.Async Mode.

In the Async mode the extern symbols will be read using async AJAX calls. this mode is the default mode.
When reading the values of extern symbols it is possible to provide a callback function which will be called if the value of a external symbol has been updated.

3.1 To set the mode to async set the property extern.prototype.mode to async:
	extern.prototype.mode="async"; //default

3.2 Define an external symbol:
	var myvar=new extern("global","var1",callback);
//where myvar is the JS variable pointing to the extern symbol "var1" in the "global" scope and callback is the callback function called if the value of the extern symbol has been updated.

3.3 Reading the updated value of an extern symbol.
The method "update()" is used to issue the AJAX request which reads the  extern symbol, if the value has been updated it will call the callback function.

	myvar.update();
	to read the actual updated value of the symbol use :
	myvar.value();



4. Example:
php:

<?php 
include "extern/extern.php";
$var1 = new extern("global","var1");
$var1->value(100);
echo $var1->value();
?>

JavaScript:
<script src="jquery-1.10.2.min.js"></script>
<script src="multifetch.js"></script>
<script src="/extern/extern.js"></script>


var myvar=new extern("global","var1",function(){
console.log("updated to:"+myvar.value());
});



setInterval(myvar.update(),100);





Common Problems:
1) Getting permission denied error when declaring extern symbols in php

you neeed to set the correct file access permission for the extern directory
for most installtions this should work on linux:
	sudo chown -R www-data:www-data /var/www/extern
	sudo chmod -R g+w folder /var/www/extern
