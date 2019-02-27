<?php

$qry = rex_sql::factory();
$qry->setTable('rex_kunden', 'rex_kunden_rechnungen');
$qry->select('*');

if (rex_post('export', 'bool')) {

		// Kunden

		$sql = rex_sql::factory();
		$sql->setTable('rex_kunden');
		$sql->select("*");
		$kunden = $sql->getArray();
		$kundenArray = [];
		foreach($kunden as $kunde) {
			$kundenArray[$kunde["id"]] = $kunde["customernumber"];
		}

		// Rechnungen

		$sql->setTable('rex_kunden_rechnungen');
		$sql->select("*");
		$rechnungen = $sql->getArray();
		$rechnungenArray = [];
		foreach($rechnungen as $rechnung) {
			$rechnungenArray[$rechnung["id"]] = $rechnung["customernumber"];
		}

    // get all todos

    $qryArray = [];
    $firstLineKeys = false;
    foreach($qry->getArray() as $line) {
        if (empty($firstLineKeys)) {
            $firstLineKeys = array_keys($line);
            $firstLineKeys = array_flip($firstLineKeys);
        }

        // -----set values

        $line["kunden"] = $kundenArray[$line["customernumber"]];
        $line["rechnungen"] = $rechnungenArray[$line["customernumber"]];
        $line["prio"] = "Prio: " . $line["prio"];
        array_push($qryArray, array_merge($firstLineKeys, $line));
    }

    if (rex_post('type') === "json-with") {

        // JSON Export (mit Tabellenstruktur)

		try {
			$table_names = array("rex_kunden","rex_kunden_rechnungen");

			$fileContent = rex_yform_manager_table_api::exportTablesets($table_names);
			$filename = 'export_kundendaten_rechnungen_mit_datenbank-struktur'.date('Y-m-d_H-i-s').'.json';
			header('Content-Disposition: attachment; filename="' . $filename . '"; charset=utf-8');
			rex_response::sendContent($fileContent, 'application/octetstream');
			exit;

		} catch (Exception $e) {
			echo rex_view::warning($this->msg('kundenverwaltung_export_failed', '', $e->getMessage()));
		}

	}

    if (rex_post('type') === "json-without") {

		// JSON Export (ohne Tabellenstruktur)

        ob_end_clean();
		$filename = 'export_kundendaten_rechnungen_ohne_datenbank-struktur'.date('Y-m-d_H-i-s').'.json';
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="' . $filename . '.json"');
        echo json_encode($qryArray, JSON_UNESCAPED_UNICODE);
        exit;

    }

    if (rex_post('type') === "csv") {

        // CSV Export

        ob_end_clean();
		$filename = 'export_kundendaten_rechnungen_'.date('Y-m-d_H-i-s').'.json';
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

        foreach(encode_items($qryArray) as $line) {
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

	if (rex_post('type') === "sql") {
		
		// SQL Export
		
		try {
			$table_names = array("rex_kunden","rex_kunden_rechnungen");

			$fileName = 'export_kundendaten_rechnungen_'.date('Y-m-d_H-i-s').'.sql';
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

$content = '<div id="aufgaben">';
$content.= '<form action="' . rex_url::currentBackendPage() . '" data-pjax="false" method="post">';
$content.= '<fieldset>';
$content.= '<dl class="rex-form-group form-group">
    <dt>Dateityp wählen</dt>
        <dd>
            <dl class="rex-form-group form-group">
                <dd>
                    <div class="radio">
                        <input id="export-csv" type="radio" value="csv" name="type" checked/>
                        <label for="export-csv">' . $this->i18n('kundenverwaltung_dateityp_csv') . '</label>
                    </div>
                </dd>
            </dl>
            <dl class="rex-form-group form-group">
                <dd>
                    <div class="radio">
                        <input id="export-json-with" type="radio" value="json-with" name="type" />
                        <label for="export-json-with">' . $this->i18n('kundenverwaltung_dateityp_json-with') . '</label>
                    </div>
                </dd>
            </dl>
			<dl class="rex-form-group form-group">
                <dd>
                    <div class="radio">
                        <input id="export-json-without" type="radio" value="json-without" name="type" />
                        <label for="export-json-without">' . $this->i18n('kundenveraltung_dateityp_json-without') . '</label>
                    </div>
                </dd>
            </dl>
			<dl class="rex-form-group form-group">
                <dd>
                    <div class="radio">
                        <input id="export-sql" type="radio" value="sql" name="type" />
                        <label for="export-sql">' . $this->i18n('kundenverwaltung_dateityp_sql') . '</label>
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
    </dl>';
$content.= '</fieldset>';
$content.= '</form>';
$content.= '</div>';
$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $this->i18n('kundenverwaltung_export_title'));
$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');
?>
