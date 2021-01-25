<?php

//import.php

include 'vendor/autoload.php';
require 'connect.php';

if($_FILES["import_excel"]["name"] != '')
{
    $allowed_extension = array('xls', 'csv', 'xlsx');
    $file_array = explode(".", $_FILES["import_excel"]["name"]);
    $file_extension = end($file_array);

    if(in_array($file_extension, $allowed_extension))
    {
        $file_name = $_FILES["import_excel"]["name"];
        $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

        $spreadsheet = $reader->load($file_name);
        $data = $spreadsheet->getActiveSheet()->toArray();

        foreach($data as $row)
        {
            $costs = $row[0];
            $earnings = $row[1];
            $date = $row[2];

            $query = "INSERT INTO profit (costs, earnings, date) VALUES (?,?,?)";

            $statement = $conexiune->prepare($query);
            $statement->bind_param("dds",$costs,$earnings,$date);//Bind_param pentru ca data sa fie uploadata bine
            $statement->execute();
            $statement->close();
        }
        $message = '<div class="alert alert-success">Data Imported Successfully</div>';
    }
    else
    {
    $message = '<div class="alert alert-danger">Only .xls .csv or .xlsx file allowed</div>';
    }
}
else
{
 $message = '<div class="alert alert-danger">Please Select File</div>';
}

echo $message;

?>