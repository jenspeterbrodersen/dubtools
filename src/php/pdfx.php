<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://www.w3schools.com/lib/w3data.js"></script>
<script src="/dubtools/js/warner1-strip.js"></script>
<script src="/dubtools/js/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Simple Sidebar - Start Bootstrap Template</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <!-- local CSS -->
    <link href="css/styles.css" rel="stylesheet">

</head>
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div w3-include-html="http://dubtools.com/dubtools/html/sidebar-menu.html"></div>

        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Warner PDF->XML test</h1>
                        <div class="container filebutton">
                            <label class="btn btn-default btn-file">Browse...<input type="file" id="inputfile" style="display: none;"></label>
                            <label class="btn btn-default btn-file" id="download" style="display:none"><a href="file.csv" id="link">Download</a></label>
                        </div>
                        <div class="container filename"><div id="list"></div></div>
                         <div class="container strip col-md-12"><div id="csv"></div></div>                    
                         
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Menu Toggle Script -->
    <script>
    // trigger html import
     w3IncludeHTML();

    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
    <!-- PHP script-->
    <?php
   # Simple PHP client for PDFX (http://pdfx.cs.man.ac.uk)
   # Author: Alex Constantin (aconstantin@cs.man.ac.uk)

   # LOCAL FILE
	$file_path = 'pdf1.pdf';
	$size = filesize ($file_path);
    $save_path = $file_path;
	
   # REMOTE FILE   	
#   $file_path = 'http://pdfx.cs.man.ac.uk/example.pdf';
#   $file_header = array_change_key_case(get_headers($file_path, TRUE));
#   $size = $file_header['content-length'];	
#   $dir = getcwd()."/articles/xml/"; # make sure this directory exists
#   $save_path = $dir.basename($file_path);

	$url="http://pdfx.cs.man.ac.uk";
    $pdf = fopen($file_path, 'r');
	$header = array('Content-Type: application/pdf', "Content-length: " . $size);
		
	$ch=curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 100);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_INFILE, $pdf);
	curl_setopt($ch, CURLOPT_INFILESIZE, $size);
	curl_setopt($ch, CURLOPT_VERBOSE, true);
	
	$fp = fopen($save_path . 'x.xml', "w");
	curl_setopt($ch, CURLOPT_FILE, $fp);
	
	if (! $res = curl_exec($ch))
		echo "Error: ".curl_error($ch);
	else {
		echo "Success";
	}
	curl_close($ch);
?>

</body>
</html>
