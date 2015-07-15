<?php
//upload.php
$output_dir = "../../uploads/";
$subdir = $_POST['subdir']."/";
$claveArchivo = $_POST["claveNombreFile"];
$tipoDocumento = $_POST["tipoDocumentoFile"];
// $archivoCargadoNombre = $_FILES["myfile"]["name"];
$archivo=$_FILES["myfile"]["name"];
$explode= explode(".", $archivo);
$extension=array_pop($explode);

if(isset($_FILES["myfile"]))
{
    $_FILES["myfile"]["name"]=$tipoDocumento."_".$claveArchivo.".".$extension;
    //Filter the file types , if you want.
    if ($_FILES["myfile"]["error"] > 0)
    {
      echo "Error: " . $_FILES["file"]["error"] . "<br>";
    }
    else
    {
        //move the uploaded file to uploads folder;
        move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$subdir. $_FILES["myfile"]["name"]);
 
     echo "Uploaded File :".$_FILES["myfile"]["name"];
    }
 
}
?>