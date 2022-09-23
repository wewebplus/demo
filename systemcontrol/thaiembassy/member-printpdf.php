<?php
require_once('../assets/lib/phpclass/tcpdf_min/config/tcpdf_config.php');
require_once('../assets/lib/phpclass/tcpdf_min/tcpdf.php');
//header("Content-type:application/pdf");

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	private $LogoImg = LOGO_IMAGE;
	private $HeadFont = FONT;
	private $HeadText = HEADTEXT;
	private $HeadTextCompany = HEADTEXTCOMPANY;
	private $HeadTextAddress01 = ADDRESSLine1;
	private $HeadTextAddress02 = ADDRESSLine2;
	private $HeadTextAddress03 = ADDRESSLine3;
	private $HeadTextNo = NO;
	private $HeadTextDate = DATE;

	//Page header
	public function Header() {
		$this->Image($this->LogoImg, 5, 16, 20, 0, '', '', '', false, 300, '', false, false, 0);
		$this->SetFont($this->HeadFont, 'B', 20);
		$this->Cell(0, 0, $this->HeadText, 0, false, 'C', 0, '', 0, false);
		$this->SetFont($this->HeadFont, 'B', 16);
		$this->SetXY(25,15);
		$this->Cell(0, 0, $this->HeadTextCompany, 0, false, 'L', 0, '', 0, false);
		$this->SetFont($this->HeadFont, '', 14);
		$this->SetXY(25,20);
		$this->Cell(0, 0, $this->HeadTextAddress01, 0, false, 'L', 0, '', 0, false);
		$this->SetXY(25,25);
		$this->Cell(0, 0, $this->HeadTextAddress02, 0, false, 'L', 0, '', 0, false);
		$this->SetXY(25,30);
		$this->Cell(0, 0, $this->HeadTextAddress03, 0, false, 'L', 0, '', 0, false);
	}
	// Page footer
	public function Footer() {	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($Data01);
$pdf->SetTitle($Data01);
$pdf->SetSubject($Data01);
$pdf->SetKeywords('TCPDF, PDF');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(5,5,5);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);

// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetAutoPageBreak(TRUE, 15);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}
// ---------------------------------------------------------

// set font
//$fontname = TCPDF_FONTS::addTTFfont('../lib/tcpdf_min/fonts/tahoma.ttf', 'TrueTypeUnicode', '', 96);

// use the font
//$pdf->SetFont($fontname, '', 14, '', false);
//$pdf->SetFont('cordiaupc', '', 12);
$styleRect = array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => '0', 'color' => array(172, 3, 46));
$styleLine = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 1, 'color' => array(172, 3, 46));
$styleLineBorder = array('width' => 10, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(172,3,46));
$styleLinehead = array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(172,3,46));

$pdf->SetFont($setpdffont, '', 11);
// add a page
$pdf->AddPage('P','A4');

$pdf->Line(0,0,$pdf->getPageWidth(),0, $styleLineBorder);
$pdf->Line($pdf->getPageWidth(),0,$pdf->getPageWidth(),$pdf->getPageHeight(), $styleLineBorder);
$pdf->Line(0,$pdf->getPageHeight(),$pdf->getPageWidth(),$pdf->getPageHeight(), $styleLineBorder);
$pdf->Line(0,0,0,$pdf->getPageHeight(), $styleLineBorder);

$pdf->SetTextColor(0,0,0);
$pdf->Image($Picture, 150, 45, 50, 0, '', '', '', false, 300, '', false, false, 0);
$pdf->SetXY(110,35);

$pdf->ln(5);
$pdf->writeHTML($html, true, false, true, false);
//$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

//Close and output PDF document
$pdf->Output($fpdfsave, 'F');
?>
