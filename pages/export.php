<?php

$_csrf_key = 'tableset_export';
$page = rex_request('page', 'string', '');

$tables = rex_sql::factory()->getTables();

$yform = new rex_yform();
$yform->setHiddenField('page', $page);
$yform->setObjectparams('real_field_names', true);
$yform->setObjectparams('form_name', $_csrf_key);
$yform->setObjectparams('submit_btn_label','Exportieren');
$form = $yform->getForm();

if ($yform->objparams['actions_executed']) {
    try {
		$table_names = array("rex_kunden","rex_kunden_rechnungen");
		$tablenames = implode('_', $table_names);
        if (strlen($tablenames) > 100) {
            $tables = substr($tablenames, 0, 100).'_etc_';
        }

		$fileName = 'kundendaten_rechnungen_'.date('Y-m-d_H-i-s').'.json';

        $fileContent = rex_yform_manager_table_api::exportTablesets($table_names);
		# $fileContent = rex_backup::exportDb($fileName, $tables);

		# print_r($tables);
		# print_r($fileContent);
		
        header('Content-Disposition: attachment; filename="' . $fileName . '"; charset=utf-8');
        rex_response::sendContent($fileContent, 'application/octetstream');
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
