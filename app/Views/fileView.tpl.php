<?php 
    $uploadsDir = "/uploads/";

    if ($file): 
?>

    <?php 

        $fileType = pathinfo($file->path, PATHINFO_EXTENSION);
        $filePath = $uploadsDir.$file->path;
        
        switch ($fileType) {
            case 'jpeg':
            case 'jpg':
                header('Content-Type: image/jpeg');
                readfile($filePath);
                break;
            case 'pdf':
                header('Content-Type: application/pdf');
                readfile($filePath);
                break;
            default:
                echo "File type is not supported";
                break;
        }
        

    ?>

<?php else: ?>

    <p>The file doesn't exist</p>

<?php endif; ?>


<!--
<img src="<= //$uploadsDir.$file->path ?>" alt="#">
-->