<!DOCTYPE html>
<html lang="en">
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

  

</script>


  <meta charset="UTF-8">
  <title>Document</title>
  <!--<link rel="stylesheet" href="../css/styles.css">-->
</head>
<body>
  <div id="page-content-wrapper">
 <div class="container" id="message">Click this button to load protools session text file -> <input type="file" name="file" id="inputfile"></div>
  
  <p><output id="list"></output></p>
  <div class="container"><output id="csv"></output></div>
  <div class="container unique-values" id="names"></div>
  <!--<div><p><a href="testfile2.csv">download</a></p></div>-->



</div>


<p>
  <?php 
    echo 'working';
    // PHP in 'yourPHPFile.php'
    // Santizing the string this way is a little safer than using $_POST['markers']

    // $outputFromPost = filter_input(INPUT_POST, 'output', FILTER_SANITIZE_STRING);
    echo ($outputFromPost);
    // Turn the sanitized JSON string into a PHP object
    $output = json_decode($outputFromPost);

    $myfile = fopen("testfile2.csv", "w");
    fwrite($myfile, $output);
    fwrite($myfile, "something");
    fclose($myfile);
    
  ?>
</p>

</body>
</html>






