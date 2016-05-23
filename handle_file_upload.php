<?php
$dir          ="upload/";
$actual_link = "http://$_SERVER[HTTP_HOST]" . "/" . $dir;
$fileName = $_FILES['afile']['name'];
$fileType = $_FILES['afile']['type'];
 



$message = 'Error uploading file';
switch( $_FILES['afile']['error'] ) {
		case UPLOAD_ERR_OK:
			$message = false;;
            break;
		case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
			$message .= ' - file too large';
            break;
        case UPLOAD_ERR_PARTIAL:
			$message .= ' - file upload was not completed.';
            break;
        case UPLOAD_ERR_NO_FILE:
                $message .= ' - zero-length file uploaded.';
                break;
            default:
                $message .= ' - internal error #'.$_FILES['afile']['error'];
                break;
        }
        if( !$message ) {
            if( !is_uploaded_file($_FILES['afile']['tmp_name']) ) {
                $message = 'Error uploading file - unknown error.';
            } else {
                // Let's see if we can move the file...
				while (file_exists($dir . $fileName)) $fileName="(1)".$fileName;
                if( !move_uploaded_file($_FILES['afile']['tmp_name'], $dir . $fileName) ) { // No error supporession so we can see the underlying error.
                    $message = 'Error uploading file - could not save upload (this will probably be a permissions problem in '.$dir.')';
                } else {
                    $message = 'File uploaded okay.';
                }
            }
        }

 $json = json_encode(array(
'name' => $fileName,
'type' => $fileType,
'dataUrl' => $actual_link.$fileName
));
echo $json;
?>