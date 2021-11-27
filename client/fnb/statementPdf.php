<?php
include_once '../../database/dbConn.php';
session_start();

require('print/fpdf.php');


$id      =  $_SESSION['ID'];
$access  = $_SESSION['userLevel'] ;
$level   =  $_SESSION['status'];
$bankN  = $_SESSION['bank'];
$acc_Num  =  $_SESSION['acc'];
$IDNUM = $_SESSION['idNum'];


$type = $_GET['type'];


if ($type == "PdfD")
{

                              $datePrint = date('Y-m-d ');
                              $time = date('h:i');

                              $conn = $conn;


                              class myPDF extends FPDF
                              {
                                  function header()
                                  {
                                        $this->Image('img/ubs.png',10,6);
                                        $this->SetFont('Arial','B',14);
                                        $this->Cell(276,30,'Client Statement',0,0,'C');
                                        $this->Ln();
                                  }
                                  function footer()
                                  {
                                          $this->SetY(-15);
                                          $this->SetFont('Arial','',8);
                                          $this->Cell(0,10,'Page'.$this->PageNo().'/{nb}',0,0,'C');


                                  }
                                  function headerTable($conn,$id)
                                  {
                                        $sql = "SELECT*  FROM client WHERE cli_ID = '$id';";
                                        $result = mysqli_query($conn,$sql);
                                        $row = mysqli_fetch_assoc($result);

                                        $this->SetFont('Times','B',14);
                                        $this->Cell(276,25,"Bank Statement",0,0,'C');
                                        $this->SetFont('Times','',14);

                                        $this->Ln();
                                        $this->SetFont('Times','B',12);
                                        $this->Cell(35,10,'Transaction Date',1,0,'C');
                                        $this->Cell(185,10,'Transaction Type',1,0,'C');
                                        $this->Cell(50,10,'Amount',1,0,'C');

                                        

                                        $this->Ln();

                                  }
                                function viewTable($conn,$sql)
                                {

                                        $this->SetFont('Times','',12);
                                        
                                         $sDate = $_GET['sDate'];
                                         $eDate = $_GET['eDate'];
        							     $IDNUM = $_SESSION['idNum'];
        							     $foundC = false;
        							     
        							   
										        
										        $sql = "SELECT* from transaction t , account a ,client c where t.acc_Number = a.acc_Number AND a.cli_ID = c.cli_ID 
													                                AND c.cli_IDNo = '$IDNUM' AND t.trans_Date >= DATE('$sDate') AND t.trans_Date <= DATE('$eDate') ORDER BY t.acc_Number ASC ";
											    
											  
											       
											    
												
													                                 
                                        $result = mysqli_query($conn,$sql);
                                        
                                        $check = mysqli_num_rows($result);
                                            
                                        while ($row = mysqli_fetch_assoc($result))
                                        {
                                                
                                                $temp = $row['acc_Number'];
                                                                                             

                                                if(substr($temp,0,4) == "6262")
                                                {
                                                    $fnb = $temp;
                                                     $foundF = true;
                                                    
                                                }
                                                else if(substr($temp,0,4) == "1818")
                                                {
                                                     $capitec = $temp;
                                                     $foundC = true;
                                                }

    

                                        }
                                        
                                                
                                                
                                                
                                                if($foundF)
                                                {
                                                    
                                                    
                                                            $this->SetFont('Times','B',16);
                                                            $this->Cell(270,10,"Account Number : ".$fnb,1,0,'C');
                                                            $this->Ln();
                                                            if(substr($fnb,0,4) == "6262")
                                                            {
                                                                
                                                                                $sql = "SELECT* FROM transaction  where acc_Number = '$fnb' 
                                                                                AND trans_Date >= DATE('$sDate') AND trans_Date <= DATE('$eDate') ORDER BY trans_Date ASC ";
                                                                                $result = mysqli_query($conn,$sql);
                                                                                
                                                                                
                                    
                                                                                
                                                                                 while ($row = mysqli_fetch_assoc($result))
                                                                                {
                                                                            
                                                                            
                                                                            $this->SetFont('Times','B',12);
                                                                            $this->Cell(35,10,$row['trans_Date'],1,0,'C');
                                                                            $this->Cell(185,10,$row['trans_Type'],1,0,'C');
                                                                            $this->Cell(50,10,"R".$row['trans_Amount'],1,0,'C');
                            
                                                                            
                            
                                                                            $this->Ln();
                                                                         
                                                                            
                            
                            
                                                                             }
                                                                             
                                                                             
                                                                             
                                                                              $sql = "SELECT* FROM account  where acc_Number = '$fnb' ";
                                                                                $result = mysqli_query($conn,$sql);
                                                                             $row = mysqli_fetch_assoc($result);
                                                                             
                                                                             $fnbBal = $row['acc_Balance'];
                                                                
                                                                
                                                                
                                                            }
                                                            
                                                            
                                                    
                                                    
                        
                                                    
                                                    
                                                    
                                                }
                                        
                                        
                                         
                                                if($foundC)
                                                {
                                                    
                                                            $this->SetFont('Times','B',16);
                                                            $this->Cell(270,10,"Account Number : ".$capitec,1,0,'C');
                                                            $this->Ln();
                                                            
                                                            if(substr($capitec,0,4) == "1818")
                                                            {
                                                                
                                                                 
                                                                 
                                                            
                                                                  $sql = "SELECT* FROM transaction  where acc_Number = '$capitec' 
                                                                  AND trans_Date >= DATE('$sDate') AND trans_Date <= DATE('$eDate') ORDER BY trans_Date ASC ";
                                                                  $result = mysqli_query($conn,$sql);
                                                                             while ($row = mysqli_fetch_assoc($result))
                                                                            {
                                                                        
                                                                        
                                                                                        $this->SetFont('Times','B',12);
                                                                                        $this->Cell(35,10,$row['trans_Date'],1,0,'C');
                                                                                        $this->Cell(185,10,$row['trans_Type'],1,0,'C');
                                                                                        $this->Cell(50,10,"R".$row['trans_Amount'],1,0,'C');
                                        
                                                                                       
                                        
                                                                                        $this->Ln();
                                                                     
                                                                        
                        
                        
                                                                         }
                                                             
                                                             
                                                                    $sql = "SELECT* FROM account  where acc_Number = '$capitec' ";
                                                                                $result = mysqli_query($conn,$sql);
                                                                             $row = mysqli_fetch_assoc($result);
                                                                             
                                                                             $capitecBal = $row['acc_Balance'];
                                                             
                                                             
                                                                
                                                             }

                                                    
                                                    
                                                    
                                                    
                                                }
                                               
                                               
                                               
                                               
                                                $this->SetFont('Times','B',16);
                                                 $this->Cell(270,10,"                                    ============================================",0,0,'C');
                                                $this->Ln();
                                                if($foundF)
                                                {
                                                     $this->Cell(270,10,"Account Number ".$fnb,0,0,'C');
                                                     $this->Ln();
                                                     $this->Cell(270,10,"BALANCE : R".$fnbBal,0,0,'C');
                                                     $this->Ln();
                                                }
                                                
                                                
                                                if($foundC)
                                                {
                                                     $this->Cell(270,10,"Account Number ".$capitec,0,0,'C');
                                                     $this->Ln();
                                                     $this->Cell(270,10,"BALANCE : R".$capitecBal,0,0,'C');
                                                     $this->Ln();
                                                }
                                                $this->Cell(270,10,"                                    =============================================",0,0,'C');
                                                $this->Ln();
                                                
                                               
                                                
                                                
                                                
                                               
                                       
                                     
                                        
                                        
                                        
                                        
                                        

                                }

                              }
                              $id      =  $_SESSION['ID'];
                              $pdf = new myPDF();
                              $pdf->AliasNbPages();
                              $pdf->AddPage('L','A4',0);
                              $pdf->headerTable($conn,$id);
                              $pdf->viewTable($conn,$sql);

                              $sql = "SELECT*  FROM client WHERE cli_ID = '$id';";
                              $result = mysqli_query($conn,$sql);
                              $row = mysqli_fetch_assoc($result);
                              $clientName = $row['cli_Name'];
                              $pdf->SetFont('Times','',12);
                              $pdf->Text(250, 195, 'Date Printed');
                              $pdf->SetFont('Times','',10);
                              $pdf->Text(250, 200, $datePrint.' '.$time);
                              $pdf->SetFont('Times','',12);
                              $pdf->Text(16, 195, 'Client details');
                              $pdf->SetFont('Times','',10);
                              $pdf->Text(16, 200,$row['cli_Name'].' '.$row['cli_Surname']);
                              ob_end_clean();
                              $pdf->Output('D',$clientName.'.'.'pdf');

                              echo "<script>location.replace('index.php');</script>";





}
elseif ($type == "PdfN")
{
  $datePrint = date('Y-m-d ');
  $time = date('h:i');

  $conn = $conn;


  class myPDF extends FPDF
  {
      function header()
      {
            $this->Image('img/ubs.png',10,6);
            $this->SetFont('Arial','B',14);
            $this->Cell(276,30,'Client Statement',0,0,'C');
            $this->Ln();
      }
      function footer()
      {
              $this->SetY(-15);
              $this->SetFont('Arial','',8);
              $this->Cell(0,10,'Page'.$this->PageNo().'/{nb}',0,0,'C');


      }
      function headerTable($conn,$id)
      {
            $sql = "SELECT*  FROM client WHERE cli_ID = '$id';";
            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($result);

            $this->SetFont('Times','B',14);
            $this->Cell(276,25,"Bank Statement",0,0,'C');
            $this->SetFont('Times','',14);

            $this->Ln();
            $this->SetFont('Times','B',12);
            $this->Cell(35,10,'Transaction Date',1,0,'C');
            $this->Cell(185,10,'Transaction Type',1,0,'C');
            $this->Cell(50,10,'Amount',1,0,'C');

            

            $this->Ln();

      }
    function viewTable($conn,$sql)
    {

            $this->SetFont('Times','',12);
           
            $IDNUM = $_SESSION['idNum']; 
            
            
			$sql = "SELECT* from transaction t , account a ,client c where t.acc_Number = a.acc_Number AND a.cli_ID = c.cli_ID 
			       AND c.cli_IDNo = '$IDNUM' ";

            $result = mysqli_query($conn,$sql);

            
             while ($row = mysqli_fetch_assoc($result))
                                        {
                                                
                                                $temp = $row['acc_Number'];
                                                                                             

                                                if(substr($temp,0,4) == "6262")
                                                {
                                                    $fnb = $temp;
                                                     $foundF = true;
                                                    
                                                }
                                                else
                                                {
                                                     $capitec = $temp;
                                                     $foundC = true;
                                                }

    

                                        }
                                        
                                                
                                                
                                                
                                                if($foundF)
                                                {
                                                    
                                                    
                                                                             $this->SetFont('Times','B',16);
                                                            $this->Cell(270,10,"Account Number : ".$fnb,1,0,'C');
                                                            $this->Ln();
                                                            if(substr($fnb,0,4) == "6262")
                                                            {
                                                                
                                                                                $sql = "SELECT* FROM transaction  where acc_Number = '$fnb' ";
                                                                                $result = mysqli_query($conn,$sql);
                                                                                
                                                                                 while ($row = mysqli_fetch_assoc($result))
                                                                                {
                                                                            
                                                                            
                                                                            $this->SetFont('Times','B',12);
                                                                            $this->Cell(35,10,$row['trans_Date'],1,0,'C');
                                                                            $this->Cell(185,10,$row['trans_Type'],1,0,'C');
                                                                            $this->Cell(50,10,"R".$row['trans_Amount'],1,0,'C');
                            
                                                                            
                            
                                                                            $this->Ln();
                                                                         
                                                                            
                            
                            
                                                                             }
                                                                             
                                                                             
                                                                             $sql = "SELECT* FROM account  where acc_Number = '$fnb' ";
                                                                                $result = mysqli_query($conn,$sql);
                                                                             $row = mysqli_fetch_assoc($result);
                                                                             
                                                                             $fnbBal = $row['acc_Balance'];
                                                                
                                                                
                                                                
                                                            }
                                                            
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                }
                                        
                                        
                                         
                                                if($foundC)
                                                {
                                                    
                                                    
                                                            $this->SetFont('Times','B',16);
                                                            $this->Cell(270,10,"Account Number : ".$capitec,1,0,'C');
                                                            $this->Ln();
                                                            if(substr($capitec,0,4) == "1818")
                                                            {
                                                                
                                                                 
                                                                 
                                                                  $sql = "SELECT* FROM transaction  where acc_Number = '$capitec' ";
                                                                $result = mysqli_query($conn,$sql);
                                                                
                                                                             while ($row = mysqli_fetch_assoc($result))
                                                                            {
                                                                        
                                                                        
                                                                                        $this->SetFont('Times','B',12);
                                                                                        $this->Cell(35,10,$row['trans_Date'],1,0,'C');
                                                                                        $this->Cell(185,10,$row['trans_Type'],1,0,'C');
                                                                                        $this->Cell(50,10,"R".$row['trans_Amount'],1,0,'C');
                                        
                                                                                       
                                        
                                                                                        $this->Ln();
                                                                     
                                                                        
                        
                        
                                                                         }
                                                             
                                                             
                                                             $sql = "SELECT* FROM account  where acc_Number = '$capitec' ";
                                                                                $result = mysqli_query($conn,$sql);
                                                                             $row = mysqli_fetch_assoc($result);
                                                                             
                                                                             $capitecBal = $row['acc_Balance'];
                                                                
                                                             }

                                                    
                                                    
                                                    
                                                    
                                                }
                                                
                                                
                                                $this->SetFont('Times','B',16);
                                                 $this->Cell(270,10,"                                    ============================================",0,0,'C');
                                                $this->Ln();
                                                if($foundF)
                                                {
                                                     $this->Cell(270,10,"Account Number ".$fnb,0,0,'C');
                                                     $this->Ln();
                                                     $this->Cell(270,10,"BALANCE : R".$fnbBal,0,0,'C');
                                                     $this->Ln();
                                                }
                                                
                                                
                                                if($foundC)
                                                {
                                                     $this->Cell(270,10,"Account Number ".$capitec,0,0,'C');
                                                     $this->Ln();
                                                     $this->Cell(270,10,"BALANCE : R".$capitecBal,0,0,'C');
                                                     $this->Ln();
                                                }
                                                $this->Cell(270,10,"                                    =============================================",0,0,'C');
                                                $this->Ln();
                                                
                                                



    }

  }
  $id      =  $_SESSION['ID'];
  $pdf = new myPDF();
  $pdf->AliasNbPages();
  $pdf->AddPage('L','A4',0);
  $pdf->headerTable($conn,$id);
  $pdf->viewTable($conn,$sql);



  $sql = "SELECT*  FROM client WHERE cli_ID = '$id';";
  $result = mysqli_query($conn,$sql);
  $row = mysqli_fetch_assoc($result);
  $clientName = $row['cli_Name'];
  $pdf->SetFont('Times','',12);
  $pdf->Text(250, 195, 'Date Printed');
  $pdf->SetFont('Times','',10);
  $pdf->Text(250, 200, $datePrint.' '.$time);
  $pdf->SetFont('Times','',12);
  $pdf->Text(16, 195, 'Client details');
  $pdf->SetFont('Times','',10);
  $pdf->Text(16, 200,$row['cli_Name'].' '.$row['cli_Surname']);
  ob_end_clean();
  $pdf->Output('D',$clientName.'.'.'pdf');

  echo "<script>location.replace('index.php');</script>";

}




?>
