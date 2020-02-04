<?php
    require "fpdf.php";
    
    $db = new PDO('mysql:host=localhost;dbname=africand_kentour;','africand_muchemi','Muchemi254');
    
    class myPDF extends FPDF{
        function header(){
            $this->Image('logo.png',10,6);
            $this->SetFont('Arial','B',14);
            $this->Cell(276,5,'KENTOUR',0,0,'C');
            $this->Ln();
            $this->SetFont('Times','',12);
            $this->Cell(276, 10, 'P.O BOX 254-7777',0,0,'C');
            $this->Ln();
            $this->SetFont('Times','',12);
            $this->Cell(276, 10, 'Nairobi, Kenya',0,0,'C');
            $this->Ln(40);
        }
        function footer(){
            $this->SetY(-26);
            $this->SetFont('Arial','',8);
            $this->Ln();
            $this->Cell(0,10,'Kentour Loan Applictions',0,0,'C');
            $this->Ln();
             $this->Cell(0,10,'ordered by status and balance)',0,0,'C');
            $this->Ln();
            $this->Cell(0,10,'Page',0,0,'C');
        }
        function headerTable(){
            $this->SetFont('Times','',12);
            $this->Cell(15,10,'id#',1,0,'C');
            $this->Cell(15,10,'Mem. #',1,0,'C');
            $this->Cell(30,10,'Member Name',1,0,'C');
            $this->Cell(30,10,'date applied',1,0,'C');
            $this->Cell(30,10,'Time',1,0,'C');
            $this->Cell(30,10,'Balance',1,0,'C');
            $this->Cell(70,10,'Purpose',1,0,'C');
            $this->Cell(40,10,'Status',1,0,'C');
            $this->Ln();
        }
        function viewUser($db){
            $stmt = $db->query("SELECT *FROM cashloans ORDER BY status, amount");
            while($data = $stmt->fetch(PDO::FETCH_OBJ)){
                $this->Cell(15,10,$data->id,1,0,'C');
                $this->Cell(15,10,$data->memberid,1,0,'C');
                $this->Cell(30,10,$data->membername,1,0,'C');
                $this->Cell(30,10,$data->dateapplied,1,0,'C');
                $this->Cell(30,10,$data->timeapplied,1,0,'C');
                $this->Cell(30,10,$data->amount,1,0,'C');
                $this->Cell(70,10,$data->purpose,1,0,'C');
                $this->Cell(40,10,$data->status,1,0,'C');
                $this->Ln();
            }
        }

     
    }  

    $pdf = new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('L','A4',0);
    $pdf->headerTable();
    $pdf->viewUser($db);
    $pdf->output();

?>