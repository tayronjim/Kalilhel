<?php
	function connectdb(){
		$connectdb = new mysqli("localhost", "root", "root", "kalilhel");
		mysqli_set_charset( $connectdb, 'utf8' );
		return $connectdb;
	}
	function unconnectdb($connectdb){
		$connectdb->close();
	}
?>