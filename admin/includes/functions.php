<?php 

//autoload funkcija trazi objekte koji su instancirani od nepostojece klase (undeclared object) i vraca ih kao parametar th vraca naziv klase.
function __autoload($class) {
	$class = strtolower($class);
	$the_path = "includes/{$class}.php";

	if (file_exists($the_path)) {

		require_once($the_path);

	} else {

		die("<br> This file named $class.php was not found maan...");
	}
}

function redirect($location) {

	header("Location: {$location}");
}




 ?>