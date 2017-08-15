<?php include("config.php"); ?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">  
        <title>PHP Media` Gallery Demo</title>
        <!-- CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">  
        <link rel='stylesheet' href='css/app.css' type='text/css' media='all' />
        <link rel='stylesheet' href='css/photobox.css' type='text/css'>
        <!-- Font -->
        <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' rel='stylesheet' type='text/css'>
        <!-- JavaScripts -->
        <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script type='text/javascript' src='js/jquery.photobox.js'></script>
        <script src="js/jquery.form.js"></script>
        <script src="js/app.js"></script>
    </head>
    <body>

        <div class="container">
            <h1>MEDIA GALLERY DEMO, V1.0</h1>
            <div class="row">
                <hr>
            </div>
            <!-- Photo Gallery Starts -->
            <div class="row gallery">
                <?php
                $result = $obj->getGalley();
                if (!empty($result)) {
                    foreach ($result AS $row) {
                        /* IF is Video */
                        if ($row['media_type'] == 'YouTube') {
                            $rel = 'video';
                            $href = "http://www.youtube.com/embed/" . $row['media_name'];
                            $src_bg = 'http://img.youtube.com/vi/' . $row['media_name'] . '/mqdefault.jpg';
                            $src = 'http://img.youtube.com/vi/' . $row['media_name'] . '/mqdefault.jpg';
                        } else {
                            /* IF is Image */
                            $rel = '';
                            $href = "images/large/" . $row['media_name'];
                            $src_bg = "images/small/" . $row['media_name'];
                            $src = "images/small/" . $row['media_name'];
                        }
                        ?>
                        <div class="col-xs-6 col-md-3 col-lg-2 col-sm-4 gallery-block" data-media_guid="<?php echo $row['media_GUID']; ?>">
                            <div class="gallery-block-inner">  
                                <a class="photobox_a <?php if ($rel != '') { ?> media-video<?php } ?>" href="<?php echo $href; ?>" rel="<?php echo $rel; ?>" <?php if ($rel != '') { ?> style="background-image:url('images/placeholder.png'), url('<?php echo $src_bg; ?>');"<?php } ?>>
                                    <img src="<?php echo $src; ?>" class="img-responsive">
                                </a>
                            </div>
                            <span class="media-name"><?php echo $row['media_name_original']; ?></span>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <p id="gallery-empty">It's Empty</p>
                    <?php
                }
                ?>
                <!-- ProgressBar Starts -->
                <div class="col-lg-2 col-md-3 col-xs-6 gallery-block" id="gallery-block-loader">
                    <div class="gallery-block-inner">    
                        <div id="progressbar">
                            <div class="bar percent"></div>        
                        </div>
                    </div>
                </div>
                <!-- ProgressBar Ends -->
            </div>
            <!-- Photo Gallery Ends -->



            <!-- Upload Media Starts -->
            <div class="row">
                <hr>
                <h3>ADD MORE MEDIA TO COLLECTION</h3>
                <div id="upload_button_group">
                    <a href="javascript:void(0)" class="button" id="upload_button">From My Computer</a>
                    <a href="javascript:void(0)" class="button button-blue" id="upload_button_URL">From YouTube URL</a>
                </div>
                <form id="upload_form" name="upload_form" method="post" action="media_upload.php" enctype="multipart/form-data">
                    <input type="file" id="upload_media" name="upload_media" accept="image/*" style="display:none">
                </form>
                <form id="upload_form_url" name="upload_form_url" method="post" action="media_upload.php"  style="display:none">
                    <input class="text-field" name="youtube_url" id="youtube_url" type="text" placeholder="Please enter YouTube URL">
                    <a href="javascript:void(0)" class="button" id="upload_button_URL_save">Save</a>
                    <a href="javascript:void(0)" class="button button-blue" id="upload_button_URL_cancel">Cancel</a>
                </form>
            </div>
            <!-- Upload Media Ends -->

            <br>
        </div>
    </body>
</html>