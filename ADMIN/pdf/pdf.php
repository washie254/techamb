<?php
    require "fpdf.php";
    
    $db = new PDO('mysql:host=localhost;dbname=dkut_ambulance;','root','');
    
    
    class myPDF extends FPDF{
        function header(){
            $serial = 'Serial: 0010'.rand(123,999);
            $this->Image('logo.png',10,6);
            $this->SetFont('Arial','B',14);
            $this->Cell(276,5,'FORTUNE HEALTH SYSTEM',0,0,'C');
            $this->Ln();
            $this->SetFont('Times','',12);
            $this->Cell(276, 10, 'For better health care against Snakes',0,0,'C');
            $this->Ln();
            $this->Cell(276, 10, $serial,0,0,'C');
            $this->Ln(40);
        }
        function footer(){
            $this->SetY(-26);
            $this->SetFont('Arial','',8);
            $this->Ln();
            $this->Cell(0,10,'Fortune Halthcare System',0,0,'C');
            $this->Ln();
            $this->Cell(0,10,'Page',0,0,'C');
        }
        function headerTable(){
            $this->SetFont('Times','',12);
            $this->Cell(20,10,'ID',1,0,'C');
            $this->Cell(30,10,'Username',1,0,'C');
            $this->Cell(40,10,'First name',1,0,'C');
            $this->Cell(40,10,'Last name',1,0,'C');
            $this->Cell(70,10,'Email',1,0,'C');
            $this->Cell(30,10,'Tel',1,0,'C');
            $this->Ln();
        }
        function viewUser($db){
            $this->SetFont('Times','',12);
            $stmt = $db->query("SELECT *FROM users");
            while($data = $stmt->fetch(PDO::FETCH_OBJ)){
                $this->Cell(20,10,$data->id,1,0,'C');
                $this->Cell(30,10,$data->username,1,0,'L');
                $this->Cell(40,10,$data->fname,1,0,'L');
                $this->Cell(40,10,$data->lname,1,0,'L');
                $this->Cell(70,10,$data->email,1,0,'L');
                $this->Cell(30,10,$data->telno,1,0,'L');
                $this->Ln();
            }
        }

        function additioalinfo0(){
            // $this->Image('logo.png',10,6);
            $this->SetFont('Arial','B',14);
            $this->Cell(276,5,'Registered Users ',0,0,'L');
            $this->Ln();
            $this->SetFont('Times','',12);
            $this->Cell(276, 10, 'Follow the following are the registered users in the system ',0,0,'L');
            $this->Ln(10);
        }
        function additioalinfo1(){
            $this->Ln(10);
            $this->SetFont('Arial','B',14);
            $this->Cell(276,5,'Registered Staff Members ',0,0,'L');
            $this->Ln();
            $this->SetFont('Times','',12);
            $this->Cell(276, 10, 'Follow the following are the registered staff memers in the system ',0,0,'L');
            $this->Ln(10);
        }

        function headerTable0(){
            $this->SetFont('Times','',12);
            $this->Cell(20,10,'ID',1,0,'C');
            $this->Cell(30,10,'Username',1,0,'C');
            $this->Cell(60,10,'Email',1,0,'C');
            $this->Cell(40,10,'Acnt Status',1,0,'C');
            $this->Cell(40,10,'Operational Status',1,0,'C');
            $this->Cell(30,10,'Date Added',1,0,'C');
            $this->Ln();
        }
        function viewStaff($db){
            $this->SetFont('Times','',12);
            $stmt = $db->query("SELECT *FROM staff");
            while($data = $stmt->fetch(PDO::FETCH_OBJ)){
                $this->Cell(20,10,$data->id,1,0,'C');
                $this->Cell(30,10,$data->username,1,0,'L');
                $this->Cell(60,10,$data->email,1,0,'L');
                $this->Cell(40,10,$data->status,1,0,'L');
                $this->Cell(40,10,$data->operationalstatus,1,0,'L');
                $this->Cell(30,10,$data->dateadded,1,0,'L');
                $this->Ln();
            }
        }

        function additioalinfo2(){
            $this->Ln(10);
            $this->SetFont('Arial','B',14);
            $this->Cell(276,5,'Reported incidents ',0,0,'L');
            $this->Ln();
            $this->SetFont('Times','',12);
            $this->Cell(276, 10, 'Follow the following are the incidents reported on the platform ',0,0,'L');
            $this->Ln(10);
        }

        function headerTable1(){
            $this->SetFont('Times','',12);
            $this->Cell(20,10,'ID',1,0,'C');
            $this->Cell(30,10,'user',1,0,'C');
            $this->Cell(60,10,'title',1,0,'C');
            $this->Cell(40,10,'location',1,0,'C');
            $this->Cell(40,10,'date',1,0,'C');
            $this->Cell(40,10,'Coords',1,0,'C');
            $this->Cell(30,10,'status',1,0,'C');
            $this->Ln();
        }
        function viewIncidents($db){
            $this->SetFont('Times','',12);
            $stmt = $db->query("SELECT *FROM incidents");
            while($data = $stmt->fetch(PDO::FETCH_OBJ)){
                $this->Cell(20,10,$data->id,1,0,'C');
                $this->Cell(30,10,$data->user,1,0,'L');
                $this->Cell(60,10,$data->title,1,0,'L');
                $this->Cell(40,10,$data->town,1,0,'L');
                $this->Cell(40,10,$data->datetime,1,0,'L');
                $this->Cell(40,10,$data->latlng,1,0,'L');
                $this->Cell(30,10,$data->status,1,0,'L');
                $this->Ln();
            }
        }

    }  

    $pdf = new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('L','A4',0);
    $pdf->additioalinfo0();
    $pdf->headerTable();
    $pdf->viewUser($db);
    $pdf->additioalinfo1();
    $pdf->headerTable0();
    $pdf->viewStaff($db);
    $pdf->additioalinfo2();
    $pdf->headerTable1();
    $pdf->viewIncidents($db);

    $pdf->output();

?>