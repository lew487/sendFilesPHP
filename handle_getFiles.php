<?php

$dir          = "upload/";
$return_array = array(); 
if(is_dir($dir)){

    if($dh = opendir($dir)){
        while(($file = readdir($dh)) != false){

            if($file == "." or $file == ".."){

            } else {
                
				$filename    = $dir . $file;
				$file_object = array(
					'name' => $file,
					'size' => filesize($filename),
					'time' => date("d F Y H:i:s", filemtime($filename))
				);
				$return_array[] = $file_object; // Add the file to the array
            }
        }
    }
	$actual_link = "http://$_SERVER[HTTP_HOST]" . "/" . $dir;

	
	$json = json_encode(array(
		'files' => $return_array,
		'address' => $actual_link
		)
	);

    echo $json;
}

?>