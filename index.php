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
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
        padding-top: 70px;
        padding-bottom: 70px;
        /* Styling for full screen background image */
        background: url('images/background.jpg') no-repeat center center fixed;
   		background-color: black;
    	-webkit-background-size: cover;
  		-moz-background-size: cover;
    	background-size: cover;
    	-o-background-size: cover;
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
                <h1>FLICKLER</h1>
                <p class="lead">Easy way to save and reference Flickr content!</p>
    		</div>
            <!-- Search bar form -->
			 <form id="search" class="navbar-form text-center" role="search" action="" method="post">
    			<div class="input-group input-group-lg">
    				<input type="text" class="form-control" placeholder="Search for..." name="query">
      				<span class="input-group-btn">
       					<button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
     				</span>
   				</div><!-- /input-group -->
   			</form><!-- /Search bar form --><br />

        </div>
        <!-- /.row -->

        <div class="row">
            <div id="images">
                <!-- images will be printed here -->
            </div>
        </div>

    </div>
    <br /><br />
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

    <!-- Functions such as showing pictures, saving them and lightbox -->
    <script type="text/javascript">
    $("#search").on("submit", function(event) {
        event.preventDefault();
        var query = $("input[name=query]").val();
        $.post("https://flickr.com/services/rest/?method=flickr.photos.search&api_key=98b9aa2f9cb784bbaefef7801f34785a&text=" + query + "&per_page=52&format=json&nojsoncallback=1")
        .done(function(data) {
            $("#images").html("");
            for (var i = 0; i < data.photos.photo.length; i++) {
                var current = data.photos.photo[i];
                $("#images").append("<div class='col-lg-3 col-md-4 col-xs-6 thumb'>" +
                    "<div class='thumbnail'>" +
                        "<a data-title='" + current.title + "' data-toggle='lightbox' href='http://farm" + current.farm + ".static.flickr.com/" + current.server + "/" + current.id + "_" + current.secret + "_c.jpg'><img class='img-responsive thumbnail' src='http://farm" + current.farm + ".static.flickr.com/" + current.server + "/" + current.id + "_" + current.secret + "_q.jpg'></a>" +
                        "<div class='caption'>" +
                            "<form class='save-image navbar-form text-center' action=' method='POST'>" +
                            "<input type='hidden' name='farm' value='" + current.farm + "''>" +
                            "<input type='hidden' name='server' value='" + current.server + "''>" +
                            "<input type='hidden' name='id' value='" + current.id + "''>" +
                            "<input type='hidden' name='secret' value='" + current.secret + "''>" +
                            "<div class='input-group'>" +
                                "<input type='text' class='form-control' placeholder='Reference' name='reference'>" +
                                "<span class='input-group-btn'>" +
                                    "<button class='btn btn-default' type='submit'><span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span></button>" +
                                "</span>" +
                            "</div><!-- /input-group -->" +
                            "</form></p>" +
                        "</div>" +
                    "</div>" +
                    "</div>"
                );
            }

            $(".save-image").on("submit", function(event) {
                event.preventDefault();
                var form = $(this);
                $.post("save-image.php", $(this).serialize())
                .done(function(data) {
                    form.hide();
                    form.after("<h5><center><span class='label label-success'>Success</span></center></h5>");
                });
            });
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