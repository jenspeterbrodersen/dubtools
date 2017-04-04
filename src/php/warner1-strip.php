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
    require_once "Classes/PHPExcel.php";

    $recieved = json_decode($_POST['json'], true);
    $myFile = array_pop($recieved);
    $uniqNames = array();
    $length = count($recieved);

    echo '<pre>'; print_r($recieved[0][character]); echo '</pre>';



    // Put all names into new array 
    foreach ($recieved as $value) {
            $uniqNames[] = $value[character];
    }
    // echo '<pre>'; print_r($uniqNames); echo '</pre>';
    
    $uniqNames = array_unique($uniqNames);
    sort($uniqNames);
    $uniqNames = array_values($uniqNames);
    $lengthUniqueNames = count($uniqNames);

    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();

    // Set properties
    $objPHPExcel->getProperties()->setCreator("Dubtools script");

    // Format spotting sheet
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Stripped Script");

    $objPHPExcel->getActiveSheet()->getStyle("A1:A1000")->getFont()->setSize(14);
    $objPHPExcel->getActiveSheet()->getStyle("B1:B1000")->getFont()->setSize(14);

    $objPHPExcel->getActiveSheet()->getStyle("A1:K1")->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()
        ->getStyle('A1:Z1')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('FF9fc9a0');

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(60);

    $objPHPExcel->getActiveSheet()->SetCellValue('A1', "ORG CHARACTER");
    $objPHPExcel->getActiveSheet()->SetCellValue('B1', "ORG DIALOGUE");

    $objPHPExcel->getActiveSheet()->getStyle('B1:B'.$objPHPExcel->getActiveSheet()->getHighestRow())
    ->getAlignment()->setWrapText(true); 

    // Write spotting data to XLSX file
    for ($i = 0; $i <= $length; $i++) {
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.($i+2), $recieved[$i][character]);
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.($i+2), $recieved[$i][dialogue]);
    }

    // Write unique characters to new sheet 
    $objWorkSheet = $objPHPExcel->createSheet();  
    $objPHPExcel->setActiveSheetIndex(1);  
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', "UNIQUE CHARACTERNAMES IN EPISODE");
    $objPHPExcel->getActiveSheet()->setTitle("Unique Characternames");
    $objPHPExcel->getActiveSheet()->getStyle("A1:A1000")->getFont()->setSize(14);
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);

    $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()
        ->getStyle('A1')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('FFa7bee5');

    for ($i = 0; $i <= $lengthUniqueNames; $i++) {
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.($i+2), $uniqNames[$i]);
    }

    $objPHPExcel->setActiveSheetIndex(0);

    // Save Excel 2007 file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    $objWriter->save(str_replace(__FILE__,'strip/'.$myFile.'.xlsx',__FILE__));


   
    ?>

</body>
</html>
