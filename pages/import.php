<?php

$success = '';
$error = '';

$function = rex_request('function', 'string');
$impname = rex_request('impname', 'string');
$exporttype = rex_post('exporttype', 'string');
$exportdl = rex_post('exportdl', 'boolean');
$EXPDIR = rex_post('EXPDIR', 'array');

@set_time_limit(0);

if ($impname != '') {
    $impname = basename($impname);

    if ($function == 'dbimport' && substr($impname, -4, 4) != '.sql') {
        $impname = '';
    } elseif ($function == 'fileimport' && substr($impname, -7, 7) != '.tar.gz') {
        $impname = '';
    } elseif (($function == 'delete' || $function == 'download') && substr($impname, -4, 4) != '.sql' && substr($impname, -7, 7) != '.tar.gz') {
        $impname = '';
    }
}

if ($function == 'download' && $impname && is_readable(rex_backup::getDir() . '/' . $impname)) {
    rex_response::sendFile(rex_backup::getDir() . '/' . $impname, substr($impname, -7, 7) != '.tar.gz' ? 'tar/gzip' : 'plain/test', 'attachment');
    exit;
}

$csrfToken = rex_csrf_token::factory('backup_import');

if ($function && !$csrfToken->isValid()) {
    $error = rex_i18n::msg('csrf_token_invalid');
} elseif ($function == 'dbimport') {
    if (isset($_FILES['FORM']) && $_FILES['FORM']['size']['importfile'] < 1 && $impname == '') {
        $error = rex_i18n::msg('backup_no_import_file_chosen_or_wrong_version') . '<br>';
    } else {
        if ($impname != '') {
            $file_temp = rex_backup::getDir() . '/' . $impname;
        } else {
            $file_temp = rex_backup::getDir() . '/temp.sql';
        }

        if ($impname != '' || @move_uploaded_file($_FILES['FORM']['tmp_name']['importfile'], $file_temp)) {
            $state = rex_backup::importDb($file_temp);
            if ($state['state']) {
                $success = $state['message'];
            } else {
                $error = $state['message'];
            }

            // temporäre Datei löschen
            if ($impname == '') {
                rex_file::delete($file_temp);
            }
        } else {
            $error = rex_i18n::msg('backup_file_could_not_be_uploaded') . ' ' . rex_i18n::msg('backup_you_have_no_write_permission_in', 'data/addons/backup/') . ' <br>';
        }
    }
} 
if ($success != '') {
    echo rex_view::success($success);
}
if ($error != '') {
    echo rex_view::error($error);
}

$content = '
    <fieldset>
        <input type="hidden" name="function" value="dbimport" />';

$formElements = [];
$n = [];
$n['label'] = '<label for="rex-form-importdbfile">' . rex_i18n::msg('kundenverwaltung_import_backup-file') . '</label>';
$n['field'] = '<input type="file" id="rex-form-importdbfile" name="FORM[importfile]" size="18" />';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/form.php');

$formElements = [];
$n = [];
$n['field'] = '<button class="btn btn-send rex-form-aligned" type="submit" value="' . rex_i18n::msg('kundenverwaltung_import_backup-file_button') . '"><i class="rex-icon rex-icon-import"></i> ' . rex_i18n::msg('kundenverwaltung_import_backup-file_button') . '</button>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$buttons = $fragment->parse('core/form/submit.php');

$content .= '</fieldset>';

$fragment = new rex_fragment();
$fragment->setVar('title', rex_i18n::msg('kundenverwaltung_import'), false);
$fragment->setVar('body', $content, false);
$fragment->setVar('buttons', $buttons, false);
$content = $fragment->parse('core/page/section.php');

$content = '
<form action="' . rex_url::currentBackendPage() . '" enctype="multipart/form-data" method="post" data-confirm="' . rex_i18n::msg('kundenverwaltung_import_backup-file_proceed') . '">
    ' . $csrfToken->getHiddenField() . '
    ' . $content . '
</form>';

echo $content;
