<?php
class settings {
    const asterisk_ip = '127.0.0.1';
    const asterisk_port = '5038';
    const asterisk_trunk = 'SIPNET';
    const asterisk_user = 'admin';
    const asterisk_pass = 'amp111';
    const asterisk_mysql_ip = 'localhost';
    const asterisk_mysql_user = 'root';
    const asterisk_mysql_pass = '123';
    const asterisk_mysql_base = 'asteriskcdrdb';
    const sms_login = 'rutu';
    const sms_pass = 'jjj';
    const mysql_ip = 'localhost';
    const mysql_user = 'root';
    const mysql_pass = '123';
    const mysql_base = 'telefonisk';
}

function dbConnect(){
	$con=mysqli_connect(settings::mysql_ip, settings::mysql_user, settings::mysql_pass, settings::mysql_base);
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	return ($con);
}

function cdr_dbConnect(){
	$con=mysqli_connect(settings::asterisk_mysql_ip, settings::asterisk_mysql_user, settings::asterisk_mysql_pass, settings::asterisk_mysql_base);
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	return ($con);
}