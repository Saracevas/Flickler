<?php

   class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('db/Flickler.db');
      }
   }
   $db = new MyDB();
   if(!$db){
      echo "No pictures saved!";
   }
   
   $sql =<<<EOF
       CREATE TABLE IF NOT EXISTS savedImages
      (ID       INTEGER PRIMARY KEY  NOT NULL,
      Farm      INTEGER              NOT NULL,
      Server    INTEGER              NOT NULL,
      PhotoID   INTEGER              NOT NULL,
      Secret    VARCHAR(60)          NOT NULL,
      Reference VARCHAR(60)
      );
EOF;
    $sql2 =<<<EOF
      SELECT * FROM savedImages;
EOF;
    $create = $db->exec($sql);
    $ret = $db->query($sql2);
   
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Flickler</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>

    body {
        padding-top: 70px;
        padding-bottom: 70px;
        background: url('images/background.jpg') no-repeat center center fixed;
   		background-color: black;
    	-webkit-background-size: cover;
  		-moz-background-size: cover;
    	background-size: cover;
    	-o-background-size: cover;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Home</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="saved.php">Saved Pictures</a>
                    </li>
                    <li>
                        <a href="export.php">Export XML</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>Saved Pictures</h1>
                <p>To copy or see the whole reference, click on the image!</p>
    		</div>

        <?php
        if (is_null($ret)):
           echo "No saved pictures!";
        else:
        while($row = $ret->fetchArray(SQLITE3_ASSOC)): ?>
            <div class="col-lg-3 col-md-4 col-xs-6">
                <div class="thumbnail">
                    <a data-toggle="lightbox" data-title="<?=$row['Reference']?>" href="http://farm<?=$row['Farm']?>.static.flickr.com/<?=$row['Server']?>/<?=$row['PhotoID']?>_<?=$row['Secret']?>_c.jpg"><img src="http://farm<?=$row['Farm']?>.static.flickr.com/<?=$row['Server']?>/<?=$row['PhotoID']?>_<?=$row['Secret']?>_q.jpg"></a>
                    <div class="caption">
                        <form class="update-image navbar-form text-center" action="" method="POST">
                            <input type="hidden" name="id" value="<?=$row['ID']?>">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="<?=$row['Reference']?>" name="reference">
                                <span class="input-group-btn"><button class="btn btn-default" type="submit" name="save"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button></span>
                            </div>
                        </form>
                        <form class="delete-image text-center" action="" method="POST">
                            <input type="hidden" name="id" value="<?=$row['ID']?>">
                            <button class="btn btn-default" style="width:50%;" type="submit" name="delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                        </form>
                    </div>
                </div>
            </div>
        
            <?php endwhile; endif; ?>


        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->
    <footer class="footer">
    <div class="navbar navbar-default navbar-fixed-bottom">
      <div class="container">
        <p class="navbar-text">&copy; Sylvester Saracevas - 2015</p>
      </div>
    </div>
    </footer>

    <!-- jQuery Version 1.11.1 and other imports -->
    <script src="js/jquery.js"></script>
    <script src="dist/ekko-lightbox.js"></script>

    <!-- Lightbox and other functions -->
    <script type="text/javascript">

    $(".delete-image").on("submit", function(event) {
        event.preventDefault();
        var form = $(this);
        $.post("delete-image.php", $(this).serialize())
        .done(function(data) {
            form.hide();
            form.after("<h5><center><span class='label label-success'>Success</span></center></h5>");
        });
    });

    $(".update-image").on("submit", function(event) {
        event.preventDefault();
        var form = $(this);
        $.post("update-image.php", $(this).serialize())
        .done(function(data) {
            form.hide();
            form.after("<h5><center><span class='label label-success'>Success</span></center></h5>");
        });
    });

     $(document).ready(function ($) {
            // delegate calls to data-toggle="lightbox"
            $(document).delegate('[data-toggle="lightbox"]', 'click', function(event) {
                event.preventDefault();
                return $(this).ekkoLightbox();
            });
        });
    </script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>