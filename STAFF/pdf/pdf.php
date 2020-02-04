<?php
    require "fpdf.php";
    
    $db = new PDO('mysql:host=localhost;dbname=dkut_clearance_system;','root','');
    //$reg = 'C025-02-0029/2015'; 

    class myPDF extends FPDF{
        function header(){
            $this->Image('logo.png',10,6);
            $this->SetFont('Arial','B',14);
            $this->Cell(276,5,'DEPARTMENTS CLEARANCE FORM',0,0,'C');
            $this->Ln();
            $this->SetFont('Times','',12);
            $this->Cell(276, 10, 'Student clearance form from all the necessary departments',0,0,'C');
            $this->Ln(40);
        }
        function footer(){
            $this->SetY(-26);
            $this->SetFont('Arial','',8);
            $this->Ln();
            $this->Cell(0,10,'Dedan Kimathi University Clearance System',0,0,'C');
            $this->Ln();
            $this->Cell(0,10,'Page',0,0,'C');
        }
        function headerTable(){
            $this->SetFont('Times','',12);
            $this->Cell(30,10,'student#',1,0,'C');
            $this->Cell(70,10,'Registration',1,0,'C');
            $this->Cell(70,10,'Email',1,0,'C');
            $this->Ln();
        }
        function viewUser($db){
            $this->SetFont('Times','',12);
            if (isset($_GET['reg'])){
                $reg = $_GET['reg'];
            }
             
            $stmt = $db->query("SELECT *FROM users where username='$reg'");
            while($data = $stmt->fetch(PDO::FETCH_OBJ)){
                $this->Cell(30,10,$data->id,1,0,'C');
                $this->Cell(70,10,$data->username,1,0,'L');
                $this->Cell(70,10,$data->email,1,0,'L');
                $this->Ln(20);
            }
        }

        function additioalinfo0(){
            // $this->Image('logo.png',10,6);
            $this->SetFont('Arial','B',14);
            $this->Cell(276,5,'APPROVED DEPERTMENTS',0,0,'L');
            $this->Ln();
            $this->SetFont('Times','',12);
            $this->Cell(276, 10, 'Student has officially been legally cleared th the following departments
            and there is no additional information that need to be provide under his area',0,0,'L');
            $this->Ln(20);
        }

        function viewDepartmentsheader(){
            $this->SetFont('Times','',12);
            $this->Cell(30,10,'COD',1,0,'C');
            $this->Cell(40,10,'librarian',1,0,'C');
            $this->Cell(40,10,'Housekeeper',1,0,'C');
            $this->Cell(50,10,'Sports Officer',1,0,'C');
            $this->Cell(40,10,'Registrar',1,0,'C');
            $this->Cell(40,10,'Finance',1,0,'C');
            $this->Ln();
        }
        function viewDepartments(){
            $this->SetFont('Times','',12);
            $this->Cell(30,10,'Cleared',1,0,'C');
            $this->Cell(40,10,'Cleared',1,0,'C');
            $this->Cell(40,10,'Cleared',1,0,'C');
            $this->Cell(50,10,'Cleared',1,0,'C');
            $this->Cell(40,10,'Cleared',1,0,'C');
            $this->Cell(40,10,'Cleared',1,0,'C');
            $this->Ln(20);
        }

        function additioalinfo2(){
            $this->SetFont('Arial','B',14);
            $this->Cell(276,5,'Seal',0,0,'C');
            $this->getY();
            $this->Image('cleared.png',110,130);
            $this->Ln();
            $this->SetFont('Times','',12);
            $this->Ln(20);
        }
    }  

    $pdf = new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('L','A4',0);
    $pdf->headerTable();
    $pdf->viewUser($db);
    $pdf->additioalinfo0();
    $pdf->viewDepartmentsheader();
    $pdf->viewDepartments();
    $pdf->additioalinfo2();
    $pdf->output();

?>