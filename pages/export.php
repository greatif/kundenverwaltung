<?php

$_csrf_key = 'tableset_export';
$page = rex_request('page', 'string', '');

$yform = new rex_yform();
$yform->setHiddenField('page', $page);
$yform->setObjectparams('real_field_names', true);
$yform->setObjectparams('form_name', $_csrf_key);
$yform->setObjectparams('submit_btn_label','Exportieren');
$form = $yform->getForm();

if ($yform->objparams['actions_executed']) {
    try {
		$table_names = array("rex_kunden","rex_kunden_rechnungen");

		# Export Tabellenstrukturen - .JSON
		# $fileName = 'backup_kundendaten_rechnungen_'.date('Y-m-d_H-i-s').'.json';
		# $fileContent = rex_yform_manager_table_api::exportTablesets($table_names);
		# header('Content-Disposition: attachment; filename="' . $fileName . '"; charset=utf-8');
		# rex_response::sendContent($fileContent, 'application/octetstream');
		
		# Export Tabellenstrukturen und Inhalt - .SQL
		$fileName = 'backup_kundendaten_rechnungen_'.date('Y-m-d_H-i-s').'.sql';
		$fileContent = rex_backup::exportDb($fileName, $table_names);
		$header = 'plain/text';
		rex_response::sendFile($fileName, $header, 'attachment');
		
		# print_r($fileContent);

		exit;

	} catch (Exception $e) {
		echo rex_view::warning($this->msg('table_export_failed', '', $e->getMessage()));
	}
}

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', 'Kundendaten und Rechnungen exportieren');
$fragment->setVar('body', $form, false);
$form = $fragment->parse('core/page/section.php');

echo $form;
