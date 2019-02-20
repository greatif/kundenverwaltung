<?php

$_csrf_key = 'rechnungsausgabe';
$page = rex_request('page', 'string', '');

	$rechnungssteller = rex_addon::get('kundenverwaltung')->getConfig('kundenverwaltung_rechnungssteller');
	if ($rechnungssteller == '') {$rechnungssteller = 'Name / Firma';}
	$strasse = rex_addon::get('kundenverwaltung')->getConfig('kundenverwaltung_strasse');
	if ($strasse == '') {$strasse = 'Musterstraße 1';}	
	$ort = rex_addon::get('kundenverwaltung')->getConfig('kundenverwaltung_plz-ort');
	if ($ort == '') {$ort = '12345 Musterstadt';}	

	$rechnungen = rex_sql::factory()->getArray('SELECT id, billnumber, ordernumber, customernumber, date, articles, invoiceamount, status FROM rex_kunden_rechnungen ORDER BY id DESC');
	if (count($rechnungen)) {
        foreach ($rechnungen as $rechnung) {
			$rechnungsnummer = $rechnung['billnumber'];
			$rechnungsdatum = date('d.m.Y', strtotime($rechnung['date']));
			$auftragsnummer = $rechnung['ordernumber'];
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
	$pdf = new FPDF('P','mm','A4');
	define('EURO', chr(128) );
		class PDF extends FPDF
		{
			// page header
			function Header()
			{
				$rechnungssteller = rex_addon::get('kundenverwaltung')->getConfig('kundenverwaltung_rechnungssteller');
				if ($rechnungssteller == '') {$rechnungssteller = 'BITTE DATEN EINGEBEN!';}
				$strasse = 'Straße';
				$strasse = rex_addon::get('kundenverwaltung')->getConfig('kundenverwaltung_strasse');
				if ($strasse == '') {$strasse = 'Musterstraße 1';}
				$ort = rex_addon::get('kundenverwaltung')->getConfig('kundenverwaltung_plz-ort');
				if ($ort == '') {$ort = '12345 Musterstadt';}
				$telefon = rex_addon::get('kundenverwaltung')->getConfig('kundenverwaltung_telefon');
				if ($telefon == '') {$telefon = '012 / 34 56 78';}
				$email = rex_addon::get('kundenverwaltung')->getConfig('kundenverwaltung_email');
				if ($email == '') {$email = 'kontakt@email.de';}
				$internet = rex_addon::get('kundenverwaltung')->getConfig('kundenverwaltung_internet');
				if ($internet == '') {$internet = 'http://';}
				$logo = rex_addon::get('kundenverwaltung')->getConfig('kundenverwaltung_logo');
				// Logo
				if ($logo != '') { $this->Image(rex_path::media($logo),145,6,25); }
				// Schrift
				$this->SetFont('Arial','B',11);
				// Move to the right
				$this->Cell(125,18,'',0,1);
				$this->Cell(125,6,'',0,0);
				// Title
				$this->Cell(50,6,iconv('UTF-8', 'windows-1252', $rechnungssteller),0,1,'');
				$this->SetFont('Arial','B',9);
				$this->Cell(125,6,'',0,0);
				$this->Cell(50,6,iconv('UTF-8', 'windows-1252', $strasse),0,1,'');
				$this->Ln(-2);
				$this->Cell(125,6,'',0,0);
				$this->Cell(50,6,iconv('UTF-8', 'windows-1252', $ort),0,1,'');
				$this->Ln(-1);
				$this->Cell(125,6,'',0,0);
				$this->Cell(15,6,iconv('UTF-8', 'windows-1252', 'Tel.:'),0,0,'');
				$this->Cell(25,6,iconv('UTF-8', 'windows-1252', $telefon),0,1,'');
				$this->Ln(-2);
				$this->Cell(125,6,'',0,0);
				$this->Cell(15,6,iconv('UTF-8', 'windows-1252', 'E-Mail:'),0,0,'');
				$this->Cell(25,6,iconv('UTF-8', 'windows-1252', $email),0,1,'');
				$this->Ln(-2);
				$this->Cell(125,6,'',0,0);
				$this->Cell(15,6,iconv('UTF-8', 'windows-1252', 'Internet:'),0,0,'');
				$this->Cell(25,6,iconv('UTF-8', 'windows-1252', $internet),0,1,'');
				$this->Ln(1);
			}
			// Page footer
			function Footer()
			{
				$steuernummer = rex_addon::get('kundenverwaltung')->getConfig('kundenverwaltung_steuernummer');
				if ($steuernummer == '') {$steuernummer = '0815-4711';}
				$kreditinstitut = rex_addon::get('kundenverwaltung')->getConfig('kundenverwaltung_kreditinstitut');
				if ($kreditinstitut == '') {$kreditinstitut = 'Muster Bank';}
				$bankleitzahl = rex_addon::get('kundenverwaltung')->getConfig('kundenverwaltung_bankleitzahl');
				if ($bankleitzahl == '') {$bankleitzahl = '1234567';}
				$kontonummer = rex_addon::get('kundenverwaltung')->getConfig('kundenverwaltung_kontonummer');
				if ($kontonummer == '') {$kontonummer = '1234567890';}
				$iban = rex_addon::get('kundenverwaltung')->getConfig('kundenverwaltung_iban');
				if ($iban == '') {$iban = 'DE 1234 5678 9012 34';}
				$bic = rex_addon::get('kundenverwaltung')->getConfig('kundenverwaltung_bic');
				if ($bic == '') {$bic = 'MB1234XXX';}
				// Position at 1.5 cm from bottom
				$this->SetY(-25);
				// Schrift
				$this->SetFont('Arial','',8);
				// Seitenzahl
				$this->Cell(0,6,iconv('UTF-8', 'windows-1252', 'Seite ').$this->PageNo().'/{nb}',0,1,'C');
				$this->SetFont('Arial','',7);
				$this->Cell(125,6,iconv('UTF-8', 'windows-1252', 'Bankverbindung:'),0,0,'');
				$this->Cell(25,6,iconv('UTF-8', 'windows-1252', 'Steuernummer: '.$steuernummer),0,1,'');
				$this->Ln(-3);				
				$this->Cell(125,6,iconv('UTF-8', 'windows-1252', $kreditinstitut),0,1,'');
				$this->Ln(-3);				
				$this->Cell(125,6,iconv('UTF-8', 'windows-1252', 'BLZ: '.$bankleitzahl.'   Konto-Nr.:'.$kontonummer),0,1,'');
				$this->Ln(-3);
				$this->Cell(125,6,iconv('UTF-8', 'windows-1252', 'IBAN: '.$iban.'   BIC: '.$bic),0,1,'');
			}
		}

		// Instanciation of inherited class
		$pdf = new PDF();
		$pdf->AliasNbPages();
		$pdf->SetLeftMargin(20);
		$pdf->AddPage();
		$pdf->SetFont('Arial','BU',7);
		$pdf->Cell(125,6,iconv('UTF-8', 'windows-1252', $rechnungssteller.' - '.$strasse.' - '.$ort),0,0);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(40,6,$rechnungsdatum,0,1,'');
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(125,6,iconv('UTF-8', 'windows-1252', $kundenname),0,1);
		$pdf->Cell(125,6,iconv('UTF-8', 'windows-1252', $kunde['street']),0,1);
		$pdf->Cell(125,6,iconv('UTF-8', 'windows-1252', $kunde['postcode'].' '.$kunde['city']),0,1);
		$pdf->Cell(125,6,iconv('UTF-8', 'windows-1252', $kunde['country']),0,1);
		$pdf->Ln(10);
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(35,6,iconv('UTF-8', 'windows-1252', 'Rechnung Nr. :'),0,0);
		$pdf->Cell(0,6,$rechnungsnummer,0,1);
		$pdf->Ln(-2);
		$pdf->Cell(35,6,iconv('UTF-8', 'windows-1252', 'Auftrag Nr. :'),0,0);
		$pdf->Cell(0,6,$auftragsnummer,0,1);
		$pdf->Ln(-2);
		$pdf->Cell(35,6,iconv('UTF-8', 'windows-1252', 'Kundennr. :'),0,0);
		$pdf->Cell(0,6,$kundennummer,0,1);
		$pdf->Ln(10);
		$pdf->SetFont('Arial','B',11);	
		$pdf->SetFillColor(225, 225, 225);
		$pdf->Cell(0,6,iconv('UTF-8', 'windows-1252', 'Leistungen / Artikel'),1,1,'',1);
		$pdf->SetFont('Arial','',11);
		$pdf->MultiCell(0,6,iconv('UTF-8', 'windows-1252', $artikel),1,1);
		$pdf->SetFont('Arial','B',11);	
		$pdf->SetFillColor(225, 225, 225);
		$pdf->Cell(0,6,iconv('UTF-8', 'windows-1252', 'Rechnungsbetrag'),'UBL',0,'',1);
		$pdf->Cell(0,6,iconv('UTF-8', 'windows-1252', '€ ').$rechnung['invoiceamount'],'UBR',1,'R',1);
		$pdf->Ln(10);
		$pdf->SetFont('Arial','',9);		
		$pdf->Cell(0,6,iconv('UTF-8', 'windows-1252', 'HINWEISE:'),0,1);
		$pdf->MultiCell(0,6,iconv('UTF-8', 'windows-1252', 'Bitte beachten Sie, dass für Artikel, die auf Ihren Vorgaben basierend produziert werden, kein Widerrufsrecht besteht.'),0,1);
		$pdf->MultiCell(0,6,iconv('UTF-8', 'windows-1252', 'Soweit nicht anders angegeben, entspricht das Liefer-/Leistungsdatum dem Rechnungsdatum.'),0,1);
		$pdf->MultiCell(0,6,iconv('UTF-8', 'windows-1252', 'Gemäß § 19 Abs. 1 UStG wird keine Umsatzsteuer ausgewiesen.'),0,1);
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,6,iconv('UTF-8', 'windows-1252', 'Wir bedanken uns für Ihren Auftrag!'),0,1);
		
		// WICHTIG
		ob_end_clean();

		$pdf->Output("I", "Rechnung_".$rechnungsnummer.".pdf");

		exit;

	} catch (Exception $e) {
		echo rex_view::warning($this->msg('table_export_failed', '', $e->getMessage()));
	}

}

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', 'Kunde: '.$kundenname.' - Rechnung vom '.$rechnungsdatum.' - Rechnungsbetrag: € '.$rechnung['invoiceamount'].' - '.$rechnung['status']);
$fragment->setVar('body', $form, false);
$form = $fragment->parse('core/page/section.php');

echo $form;

}
}
