<?php
    require_once('../../../../wp-config.php');
    

	$json_obj = $_POST['d'];
	$site=get_site_url();
	
	 
	
	$filename = "../export/exportData.csv";

	$fp = fopen($filename , 'w');

	foreach ($json_obj as $fields) {
		fputcsv($fp, $fields);
	}

	fclose($fp);
	
	/*prompt to download
	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header("Content-Length: ". filesize("$filename").";");
	//header("Content-Disposition: attachment; filename=$filename");
	header('Content-Disposition: attachment; filename='.basename($filename));
	header("Content-Type: application/octet-stream; "); 
	header("Content-Transfer-Encoding: binary");

	readfile($filename);*/
	
	
	//Downloads a URL to a local temporary file using the WordPress HTTP Class.
	// yoursite_template_redirect();
	exit;
?> 