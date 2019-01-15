<?php

$_csrf_key = 'rechnungsausgabe';
$page = rex_request('page', 'string', '');

	$rechnungen = rex_sql::factory()->getArray('SELECT id, billnumber, customernumber, date, articles, invoiceamount, status FROM rex_kunden_rechnungen ORDER BY id DESC');
	if (count($rechnungen)) {
        foreach ($rechnungen as $rechnung) {
			$rechnungsnummer = $rechnung['billnumber'];
			$rechnungsdatum = date('d.m.y', strtotime($rechnung['date']));
			$kundennummer = $rechnung['customernumber'];
			$kundendaten = rex_sql::factory()->getArray("SELECT * FROM rex_kunden WHERE customernumber = '$kundennummer'");
			foreach ($kundendaten as $kunde) {
				$kundenname = $kunde['salutation'].' '.$kunde['firstname'].' '.$kunde['name'];
			}
			$artikel = $rechnung['articles'];
			
$yform = new rex_yform();
$yform->setHiddenField('page', $page);
$yform->setObjectparams('real_field_names', true);
$yform->setObjectparams('form_name', $_csrf_key.'_'.$rechnungsnummer);
$yform->setObjectparams('submit_btn_label','Rechnung Nr. '. $rechnungsnummer);
$yform->setObjectparams('form_showformafterupdate', 0);
$form = $yform->getForm();

if ($yform->objparams['actions_executed']) {
			
    try {

	//PDF-Generierung
	$pdf = new FPDF();
		class PDF extends FPDF
		{
			// Page header
			function Header()
			{
				// Logo
				$this->Image(rex_path::media('greatif.png'),10,6,30);
				// Arial bold 15
				$this->SetFont('Arial','B',15);
				// Move to the right
				$this->Cell(80);
				// Title
				$this->Cell(30,10,'Firmenname',1,0,'C');
				// Line break
				$this->Ln(20);
			}
			// Page footer
			function Footer()
			{
				// Position at 1.5 cm from bottom
				$this->SetY(-15);
				// Arial italic 8
				$this->SetFont('Arial','I',8);
				// Page number
				$this->Cell(0,10,'Seite '.$this->PageNo().'/{nb}',0,0,'C');
			}
		}

		// Instanciation of inherited class
		$pdf = new PDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);
		$pdf->Cell(0,10,'Datum : '.$rechnungsdatum,0,1);
		$pdf->Cell(0,10,'Rechnung Nr. : '.$rechnungsnummer,0,1);
		$pdf->Cell(0,10,'Kunden Nr. : '.$kundennummer,0,1);
		$pdf->Cell(0,10,'Kunde : '.$kundenname,0,1);
		$pdf->Cell(0,10,'Artikel : '.$artikel,0,1);		
		
		// WICHTIG
		ob_end_clean();

		$pdf->Output();

		exit;

	} catch (Exception $e) {
		echo rex_view::warning($this->msg('table_export_failed', '', $e->getMessage()));
	}

}

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', 'Kunde: '.$kundenname.' - Rechnung vom '.$rechnungsdatum.' - Rechnungsbetrag: '.$rechnung['invoiceamount'].' - '.$rechnung['status']);
$fragment->setVar('body', $form, false);
$form = $fragment->parse('core/page/section.php');

echo $form;

}
}