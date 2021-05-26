

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <form id="load_file" method="post" action="index.php"  enctype="multipart/form-data">
                <div class="col-12 form-group">
                    <input type="file" name="select-file" class="form-control-file">
                    <input type="submit" class="btn btn-primary" value="Enviar">
                </div>
            </form>
    </div>
   

</body>
</html>

<?php

include 'classes\PhpSpreadsheet\vendor\autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

use PhpOffice\PhpSpreadsheet\Spreadsheet;

function checkempty($arquivo){
    if($arquivo != ''){
        return true;
    }
}

$nome = $_FILES["select-file"]["name"];

$nome_tmp = $_FILES["select-file"]["tmp_name"];

if(checkempty($nome)){
    verifyextension($nome, $nome_tmp);
}


function verifyextension($namearquivo,$nomearquivotmp){

        $file_array = explode(".", $namearquivo);

        $name_noextension = $file_array[0];

        $file_extension = end($file_array);

        echo $name_noextension;
        echo $file_extension;

        $local = "C:\Users\User\Downloads/".$namearquivo;

    switch ($file_extension){
        case 'xls':
            movefile($nomearquivotmp,$local);

            xlstoarray($name_noextension);

            break;
        case 'xlsx': 
            movefile($nomearquivotmp,$local);

            xlsxtoarray($name_noextension);

            break;
        case 'csv': 
            movefile($nomearquivotmp,$local);

            csvtoarray($name_noextension);
    }
}

function movefile($arquivo, $local )
{
    move_uploaded_file($arquivo,$local);
}


function xlstoarray($nome){

    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xls');

    $spreadsheet = $reader->load("C:\Users\User\Downloads/".$nome.".xls");
    
    $worksheet = $spreadsheet->getActiveSheet();
    
    $rows = [];
    
    foreach ($worksheet->getRowIterator() AS $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE); 
        $cells = [];
        foreach ($cellIterator as $cell) {
            $cells[] = $cell->getValue();
           
        }
        $rows[] = $cells;
    }
    print_r($rows);
}
function xlsxtoarray($nome){

    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');

    $spreadsheet = $reader->load("C:\Users\User\Downloads/".$nome.".xlsx");
    
    $worksheet = $spreadsheet->getActiveSheet();
    
    $rows = [];
    
    foreach ($worksheet->getRowIterator() AS $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE); 
        $cells = [];
        foreach ($cellIterator as $cell) {
            $cells[] = $cell->getValue();
           
        }
        $rows[] = $cells;
    }
    print_r($rows);
}
function csvtoarray($nome){

    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Csv');

    $spreadsheet = $reader->load("C:\Users\User\Downloads/".$nome.".csv");
    
    $worksheet = $spreadsheet->getActiveSheet();
    
    $rows = [];
    
    foreach ($worksheet->getRowIterator() AS $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE); 
        $cells = [];
        foreach ($cellIterator as $cell) {
            $cells[] = $cell->getValue();
           
        }
        $rows[] = $cells;
    }
    print_r($rows);
}




?>