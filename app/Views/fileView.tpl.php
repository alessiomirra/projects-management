<?php
$uploadsDir = "/uploads/";

if ($file && file_exists($uploadsDir.$file->path)) {
    $fileType = pathinfo($file->path, PATHINFO_EXTENSION);
    $filename = $file->path;
    $filePath = $uploadsDir . $file->path;

    switch ($fileType) {
        case 'jpeg':
        case 'jpg':
            header('Content-Type: image/jpeg');
            @readfile($filePath);
            exit; 
        case 'pdf':
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . $filename . '"');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');
            @readfile($filePath);
            exit; 
        default:
            echo "File type is not supported";
            break;
    }
} else {
    echo "<p>The file doesn't exist</p>";
}
?>