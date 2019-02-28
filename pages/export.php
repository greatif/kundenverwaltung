<?php

$qryKunden = rex_sql::factory();
$qryKunden->setTable('rex_kunden');
$qryKunden->select('*');

$qryRechnungen = rex_sql::factory();
$qryRechnungen->setTable('rex_kunden_rechnungen');
$qryRechnungen->select('*');

if (rex_post('export', 'bool')) {

    $qryKundenArray = [];
    $firstLineKeys = false;
    foreach($qryKunden->getArray() as $line) {
        if (empty($firstLineKeys)) {
            $firstLineKeys = array_keys($line);
            $firstLineKeys = array_flip($firstLineKeys);
        }

        array_push($qryKundenArray, array_merge($firstLineKeys, $line));
    }

    $qryRechnungenArray = [];
    $firstLineKeys = false;
    foreach($qryRechnungen->getArray() as $line) {
        if (empty($firstLineKeys)) {
            $firstLineKeys = array_keys($line);
            $firstLineKeys = array_flip($firstLineKeys);
        }

        array_push($qryRechnungenArray, array_merge($firstLineKeys, $line));
    }

    if (rex_post('type') === "kunden-csv") {

        // CSV Export (Kunddendaten)

        ob_end_clean();
		$filename = 'export_kunden_'.date('Y-m-d_H-i-s');
        header('Content-Type: application/excel');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
        $file = fopen('php://output', 'w');
        $firstLineKeys = false;
        function encode_items($array)
        {
            foreach($array as $key => $value) {
                if (is_array($value)) {
                    $array[$key] = encode_items($value);
                }
                else {
                    $array[$key] = mb_convert_encoding($value, 'Windows-1252', 'UTF-8');
                }
            }

            return $array;
        }

        foreach(encode_items($qryKundenArray) as $line) {
            if (empty($firstLineKeys)) {
                $firstLineKeys = array_keys($line);
                fputcsv($file, $firstLineKeys);
                $firstLineKeys = array_flip($firstLineKeys);
            }

            fputcsv($file, array_merge($firstLineKeys, $line));
        }

        fclose($file);
        exit;

    }

    if (rex_post('type') === "rechnungen-csv") {

        // CSV Export (Rechnungsdaten)

        ob_end_clean();
		$filename = 'export_rechnungen_'.date('Y-m-d_H-i-s');
        header('Content-Type: application/excel');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
        $file = fopen('php://output', 'w');
        $firstLineKeys = false;
        function encode_items($array)
        {
            foreach($array as $key => $value) {
                if (is_array($value)) {
                    $array[$key] = encode_items($value);
                }
                else {
                    $array[$key] = mb_convert_encoding($value, 'Windows-1252', 'UTF-8');
                }
            }

            return $array;
        }

        foreach(encode_items($qryRechnungenArray) as $line) {
            if (empty($firstLineKeys)) {
                $firstLineKeys = array_keys($line);
                fputcsv($file, $firstLineKeys);
                $firstLineKeys = array_flip($firstLineKeys);
            }

            fputcsv($file, array_merge($firstLineKeys, $line));
        }

        fclose($file);
        exit;

    }	

    if (rex_post('type') === "kunden-json") {

		// JSON Export (Kundendaten)

        ob_end_clean();
		$filename = 'export_kunden_'.date('Y-m-d_H-i-s');
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="' . $filename . '.json"');
        echo json_encode($qryKundenArray, JSON_UNESCAPED_UNICODE);
        exit;

    }

    if (rex_post('type') === "rechnungen-json") {

		// JSON Export (Rechnungsdaten)

        ob_end_clean();
		$filename = 'export_rechnungen_'.date('Y-m-d_H-i-s');
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="' . $filename . '.json"');
        echo json_encode($qryRechnungenArray, JSON_UNESCAPED_UNICODE);
        exit;

    }

    if (rex_post('type') === "db-struktur-json") {

        // JSON Export (YForm-Tabellenstruktur)

		try {
			$table_names = array("rex_kunden","rex_kunden_rechnungen");

			$fileContent = rex_yform_manager_table_api::exportTablesets($table_names);
			$filename = 'export_kunden_rechnungen_db-struktur_'.date('Y-m-d_H-i-s').'.json';
			header('Content-Disposition: attachment; filename="' . $filename . '"; charset=utf-8');
			rex_response::sendContent($fileContent, 'application/octetstream');
			exit;

		} catch (Exception $e) {
			echo rex_view::warning($this->msg('kundenverwaltung_export_failed', '', $e->getMessage()));
		}

	}

	if (rex_post('type') === "sql") {
		
		// SQL Export
		
		try {
			$table_names = array("rex_kunden","rex_kunden_rechnungen");

			$fileName = 'export_kunden_rechnungen_'.date('Y-m-d_H-i-s').'.sql';
			$fileContent = rex_backup::exportDb($fileName, $table_names);
			$header = 'plain/text';
			rex_response::sendFile($fileName, $header, 'attachment');
			rex_file::delete($fileName);

			exit;

		} catch (Exception $e) {
			echo rex_view::warning($this->msg('kundenverwaltung_export_failed', '', $e->getMessage()));
		}

	}

}

$content.= '
<form action="' . rex_url::currentBackendPage() . '" data-pjax="false" method="post">
	<fieldset>
		<dl class="rex-form-group form-group">
			<dt><label for="' . $this->i18n("kundenverwaltung_dateityp_wahl") . '">' . $this->i18n("kundenverwaltung_auswahl") . '</label></dt>
				<dd>
					<dl class="rex-form-group form-group">
						<dd>
						    <div class="radio">
								<input id="export-kunden-csv" type="radio" value="kunden-csv" name="type" checked/>
								<label for="export-kunden-csv">' . $this->i18n('kundenverwaltung_kunden_csv') . '</label>
							</div>
						</dd>
					</dl>
					<dl class="rex-form-group form-group">
						<dd>
						    <div class="radio">
								<input id="export-rechnungen-csv" type="radio" value="rechnungen-csv" name="type" />
								<label for="export-rechnungen-csv">' . $this->i18n('kundenverwaltung_rechnungen_csv') . '</label>
							</div>
						</dd>
					</dl>
					<dl class="rex-form-group form-group">
						<dd>
						    <div class="radio">
								<input id="export-kunden-json" type="radio" value="kunden-json" name="type" />
								<label for="export-kunden-json">' . $this->i18n('kundenverwaltung_kunden_json') . '</label>
							</div>
						</dd>
					</dl>					
					<dl class="rex-form-group form-group">
						<dd>
						    <div class="radio">
								<input id="export-rechnungen-json" type="radio" value="rechnungen-json" name="type" />
								<label for="export-rechnungen-json">' . $this->i18n('kundenverwaltung_rechnungen_json') . '</label>
							</div>
						</dd>
					</dl>
					<dl class="rex-form-group form-group">
						<dd>
						    <div class="radio">
								<input id="export-db-struktur-json" type="radio" value="db-struktur-json" name="type" />
								<label for="export-db-struktur-json">' . $this->i18n('kundenverwaltung_db-struktur_json') . '</label>
							</div>
						</dd>
					</dl>
					<dl class="rex-form-group form-group">
						<dd>
						    <div class="radio">
								<input id="export-sql" type="radio" value="sql" name="type" />
								<label for="export-sql">' . $this->i18n('kundenverwaltung_sql') . '</label>
							</div>
						</dd>
					</dl>
					<dl class="rex-form-group form-group">
						<dd>
							<br />
							<button class="btn btn-save rex-form" type="submit" name="export" value="export">' . $this->i18n('kundenverwaltung_export_save') . '</button>
						</dd>
					</dl>
				</dd>
		</dl>
	</fieldset>
</form>';

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $this->i18n('kundenverwaltung_export_title'));
$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');
?>
