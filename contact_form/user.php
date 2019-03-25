<?php
/* Created by hiran.
 * Date: 12/3/19
 * Time: 4:30 PM
 */
include_once "database.php";

class user extends database{

	var $id;
	var $name;
	var $email;
	var $phone;
	var $message;

	function __construct(){
		parent ::__construct();
	} 
}
?>