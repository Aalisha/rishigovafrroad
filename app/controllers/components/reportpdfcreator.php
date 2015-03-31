<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reportpdfcreator
 *
 * @author Administrator
 */
App::import('fpdf');

class ReportpdfcreatorComponent extends FPDF {

    function Header() {

        global $title;

        $title = 'Report';


        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Calculate width of title and position
        $w = $this->GetStringWidth($title) + 6;
        $this->SetX((210 - $w) / 2);
        // Colors of frame, background and text
        $this->SetDrawColor(0, 80, 180);
        $this->SetFillColor(230, 230, 0);
        $this->SetTextColor(220, 50, 50);
        // Thickness of frame (1 mm)
        $this->SetLineWidth(1);
        // Title
        $this->Image(WWW_ROOT . 'img/logo.jpg', 10, 5, 30, 30);

        //$this->Image('images/fair/autumn13header.png', 10, 5, 190, 50);
        $this->Cell($w, 9, $title, 1, 1, 'C', true);
        // Line break
        $this->Ln(50);
    }

    function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Text color in gray
        $this->SetTextColor(128);
        // Page number
        $this->Cell(50, 10, 'Page ' . $this->PageNo(), 0, 0, 'L');
        $this->Cell(0, 10, 'Date ' . date('d-M-Y'), 0, 0, 'R');
    }

    function genrate_cbc_customerrechargepdf($columnsValues, $data, $allconstants) {

        $this->AddPage();
        $this->SetFont('Arial', 'B', 8);

        $c = 0;

        $this->SetFillColor(139, 137, 137);

        $length = count($columnsValues) - 1;

        foreach ($columnsValues as $val) {

            $x = $this->GetX();
            $y = $this->GetY();

            if ($c == 0) {

                $this->MultiCell(10, 12, $val, 1, '', 'C', true);
                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 10); //Move X to $x + width of last cell
            } else {
                if ($c == $length)
                    $this->MultiCell(20, 12, $val, 1, '', 'C', true);
                else
                    $this->MultiCell(20, 6, $val, 1, '', 'C', true);

                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 20); //Move X to $x + width of last cell
            }
            $c++;
        }

        $this->SetFont('Arial', '', 8);
        $i = 0;
        $this->Ln();

        foreach ($data as $val) {

            $x = $this->GetX();
            $y = $this->GetY();
            $this->MultiCell(10, 10, $i, 1, 'C');
            // $this->MultiCell(10, 10, $val['AccountRecharge']['nu_acct_rec_id'], 1,'C');

            $this->SetY($y);  //Reset the write point
            $this->SetX($x + 10); //Move X to $x + width of last cell

            $entryDate = !empty($val['AccountRecharge']['dt_entry_date']) ?
                    date('d-M-Y', strtotime($val['AccountRecharge']['dt_entry_date'])) : '';
            //$this->Cell(20, 6, $entryDate , 1);
            $this->MultiCell(20, 10, $entryDate, 1, 'L');
            $this->SetY($y);  //Reset the write point
            $this->SetX($x + 30); //Move X to $x + width of last cell
            $this->MultiCell(20, 10, wordwrap($val['AccountRecharge']['vc_ref_no'], 20, "<br>\n", true), 1, 'L');

            $this->SetY($y);  //Reset the write point
            $this->SetX($x + 50); //Move X to $x + width of last cell
            $paymentDate = !empty($val['AccountRecharge']['dt_payment_date']) ?
                    date('d-M-Y', strtotime($val['AccountRecharge']['dt_payment_date'])) :
                    'N/A';
            $this->MultiCell(20, 10, $paymentDate, 1, 'L');
            $this->SetY($y);  //Reset the write point
            $this->SetX($x + 70); //Move X to $x + width of last cell

            $this->MultiCell(20, 10, wordwrap(number_format($val['AccountRecharge']['nu_amount_un'], 2, '.', ','), 20, "<br>\n", true), 1, 'R');

            $this->SetY($y);  //Reset the write point
            $this->SetX($x + 90); //Move X to $x + width of last cell


            $this->MultiCell(20, 10, wordwrap(number_format($val['AccountRecharge']['nu_amount'], 2, '.', ','), 20, "<br>\n", true), 1, 'R');

            $this->SetY($y);  //Reset the write point
            $this->SetX($x + 110); //Move X to $x + width of last cell


            $this->MultiCell(20, 10, wordwrap(number_format($val['AccountRecharge']['nu_hand_charge'], 2, '.', ','), 20, "<br>\n", true), 1, 'R');

            if ($val['AccountRecharge']['vc_recharge_status'] == 'STSTY04' && !empty($val['AccountRecharge']['nu_amount']) && $val['AccountRecharge']['nu_amount'] > 100) {

                $novalue = wordwrap(number_format((($val['AccountRecharge']['nu_amount']) - 100), 2, '.', ','));
            } else {

                $novalue = 'N/A';
            }
            $this->SetY($y);  //Reset the write point
            $this->SetX($x + 130); //Move X to $x + width of last cell

            $this->MultiCell(20, 10, $novalue, 1, 'R');

            $this->SetY($y);  //Reset the write point
            $this->SetX($x + 150); //Move X to $x + width of last cell

            $this->MultiCell(20, 10, $allconstants[$val['AccountRecharge']['vc_recharge_status']], 1, 'L');

            $this->SetY($y);  //Reset the write point
            $this->SetX($x + 170); //Move X to $x + width of last cell


            if ($val['AccountRecharge']['vc_recharge_status'] == 'STSTY05') {

                $vc_remarks = $val['AccountRecharge']['vc_remarks'];
            } else {

                $vc_remarks = 'N/A';
            }

            $this->MultiCell(20, 10, $vc_remarks, 1, 'L');



            if ($y == 260) {
                
            }

            if ($i % 18 == 0 && $i > 0) {

                $this->AddPage();
            }
            //$this->Ln();
            $i++;
        }
    }

}

?>
