<?php
include("config.php");
/*
  |--------------------------------------------------------------------------
  | Upload Media
  |--------------------------------------------------------------------------
 */
if (isset($_FILES['upload_media'])) {
    /* Upload Settings Starts */
    ini_set("memory_limit", "99M");
    ini_set('post_max_size', '20M');
    ini_set('max_execution_time', 600);

    define('IMAGE_LARGE_DIR', './images/large/');
    define('IMAGE_LARGE_WIDTH', 800);
    define('IMAGE_LARGE_HEIGHT', 800);

    define('IMAGE_SMALL_DIR', './images/small/');
    define('IMAGE_SMALL_SIZE_WIDTH', 200);
    define('IMAGE_SMALL_SIZE_HEIGHT', 200);
    /* Upload Settings Ends */

    /* Validations Starts */
    $output['status'] = FALSE;
    $allowedImageType = array("image/gif", "image/jpeg", "image/pjpeg", "image/png", "image/x-png");
    if ($_FILES['upload_media']["error"] > 0) {
        $output['error'] = "Error in File";
    } elseif (!in_array($_FILES['upload_media']["type"], $allowedImageType)) {
        $output['error'] = "You can only upload JPG, PNG and GIF file";
    } elseif (round($_FILES['upload_media']["size"] / 1024) > 4096) {
        $output['error'] = "You can upload file size up to 4 MB";
    } else {
    /* Validations Ends */
     
        /* create directory with 777 permission if not exist Starts */
        $obj->createDir(IMAGE_LARGE_DIR);
        $obj->createDir(IMAGE_SMALL_DIR);
        /* create directory with 777 permission if not exist Ends */

        /* Upload Settings Starts */
        $file = pathinfo($_FILES['upload_media']['name']);
        $fileType = $file["extension"];
        $desiredExt = 'jpg';
        $fileNameNew = rand(333, 999) . time() . ".$desiredExt";
        $path[1] = IMAGE_LARGE_DIR . $fileNameNew;
        $path[2] = IMAGE_SMALL_DIR . $fileNameNew;
        /* Upload Settings Ends */

        /* Upload Starts */
        if ($obj->createThumb($_FILES['upload_media']['tmp_name'], $path[1], $fileType, IMAGE_LARGE_WIDTH, IMAGE_LARGE_HEIGHT)) {
            if ($obj->createThumb($path[1], $path[2], "$desiredExt", IMAGE_SMALL_SIZE_WIDTH, IMAGE_SMALL_SIZE_HEIGHT, IMAGE_SMALL_SIZE_WIDTH)) {
                $output['status'] = TRUE;
                $output['image_large'] = $path[1];
                $output['image_small'] = $path[2];
                $output['image_name_original'] = $file['filename'];
                $output['media_GUID'] = rand(1111, 9999) . time();
                /* Insert into DB */
                $obj->addEdit('media', array('media_GUID' => $output['media_GUID'], 'media_name' => $fileNameNew, 'media_name_original' => $file['filename'], 'media_type' => $_FILES['upload_media']["type"], 'created_date' => date('Y-m-d')));
            }
        }
        /* Upload Ends */
    }
    /* Return JSON Output */
    header('Content-type: application/json');
    exit(json_encode($output));
}

/*
  |--------------------------------------------------------------------------
  | Upload YouTube URL
  |--------------------------------------------------------------------------
 */
if (isset($_POST['youtube_id']) && $_POST['youtube_id'] != '') {
    /* Insert into DB */
    $obj->addEdit('media', array('media_GUID' => rand(1111, 9999) . time(), 'media_name' => $_POST['youtube_id'], 'media_name_original' => $_POST['youtube_id'], 'media_type' => 'YouTube', 'created_date' => date('Y-m-d')));
    $output['status'] = TRUE;
    $output['youtube_url'] = "http://www.youtube.com/embed/" . $_POST['youtube_id'];
    $output['image_small'] = "http://img.youtube.com/vi/" . $_POST['youtube_id'] . "/mqdefault.jpg";
    $output['media_name_original'] = '';
    $output['media_GUID'] = rand(1111, 9999) . time();
    /* Return JSON Output */
    header('Content-type: application/json');
    exit(json_encode($output));
}


/*
  |--------------------------------------------------------------------------
  | Rename Media
  |--------------------------------------------------------------------------
 */
if (isset($_POST['media_name_original']) && $_POST['media_name_original'] != '') {
    /* Update into DB */
    $obj->addEdit('media', array('media_name_original' => $_POST['media_name_original']), array('media_GUID' => $_POST['media_GUID']));
}

?>	