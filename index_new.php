<!DOCTYPE html>
<html lang="en">
<head>
<script src="/dubtools/js/main.js"></script>
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
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                   
                </li>
                <li>
                    <a href="index_new.php">Convert PT Spotting</a>
                </li>
                <li>
                    <a href="striptest.php">Striptest</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                      <img src="gfx/dubtools-logo.png" style="float:right">
                        <h1>Convert PT spotting</h1>
                        <div class="container filebutton">
                            <label class="btn btn-default btn-file">Browse...<input type="file" id="inputfile" style="display: none;"></label>
                            <label class="btn btn-default btn-file" id="download" style="display:none"><a href="file.csv" id="link">Download</a></label>
                        </div>
                        <div class="container filename"><div id="list"></div></div>
                         <div class="container csv col-md-6"><div id="csv"></div></div>                    
                         <div class="container names col-md-6 unique-values"><div id="names"></div></div>
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
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

    <!-- PHP script-->
    <?php 
    require_once "Classes/PHPExcel.php";

    $recieved = json_decode($_POST['json']);
    $myFile = array_pop($recieved);
    $myTotal = array_pop($recieved);
    $summary = array();

    // Split array by data type (spotting data or summary data)
    foreach ($recieved as $key => $value) {
        if ($value[0] == "summary") {
            $summary[] = $value;
            unset($recieved[$key]);
        }
    }

    $length = count($recieved);
    $lengthSummary = count($summary);

    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();

    // Set properties
    $objPHPExcel->getProperties()->setCreator("Dubtools script");

    // Format spotting sheet
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Spotting");

    $objPHPExcel->getActiveSheet()->getStyle("A1:A1000")->getFont()->setSize(14);
    $objPHPExcel->getActiveSheet()->getStyle("B1:B1000")->getFont()->setSize(14);
    $objPHPExcel->getActiveSheet()->getStyle("C1:C1000")->getFont()->setSize(14);

    $objPHPExcel->getActiveSheet()->getStyle("A1:C1")->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()
        ->getStyle('A1:C1')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('FF9fc9a0');

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);

    $objPHPExcel->getActiveSheet()->SetCellValue('A1', "CHARACTER");
    $objPHPExcel->getActiveSheet()->SetCellValue('B1', "TC-IN");
    $objPHPExcel->getActiveSheet()->SetCellValue('C1', "TC-OUT");

    // Write spotting data to XLSX file
    for ($i = 0; $i <= $length; $i++) {
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.($i+2), $recieved[$i][3]);
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.($i+2), $recieved[$i][1]);
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.($i+2), $recieved[$i][2]);
    }

    // Write summary data to XLSX file
    $objWorkSheet = $objPHPExcel->createSheet();  
    $objPHPExcel->setActiveSheetIndex(1);  
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', "CHARACTER");
    $objPHPExcel->getActiveSheet()->SetCellValue('B1', "DURATION (sec)");
    $objPHPExcel->getActiveSheet()->setTitle("Summary");
    $objPHPExcel->getActiveSheet()->getStyle("A1:A1000")->getFont()->setSize(14);
    $objPHPExcel->getActiveSheet()->getStyle("B1:B1000")->getFont()->setSize(14);
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);

    $objPHPExcel->getActiveSheet()->getStyle("A1:B1")->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()
        ->getStyle('A1:B1')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('FFa7bee5');

    for ($i = 0; $i <= $lengthSummary; $i++) {
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.($i+2), $summary[$i][1]);
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.($i+2), $summary[$i][2]);
    }

    $pos = $lengthSummary+3;

    $objPHPExcel->getActiveSheet()->SetCellValue('A'.($lengthSummary+3), "TOTAL");
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.($lengthSummary+3), $myTotal);
    $objPHPExcel->getActiveSheet()->getStyle("A".$pos.":B".$pos)->getFont()->setBold(true);


    $objPHPExcel->setActiveSheetIndex(0);  

    // Save Excel 2007 file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    $objWriter->save(str_replace(__FILE__,'pt/'.$myFile.'.xlsx',__FILE__));
    ?>
</body>
</html>


