<?php
$content = '<div id="kundenverwaltung-wrapper">';

if (rex_post('config-submit', 'boolean'))
{
    $this->setConfig(rex_post('config', [
        ['kundenverwaltung_rechnungssteller', 'string'],
        ['kundenverwaltung_strasse', 'string'],
        ['kundenverwaltung_plz-ort', 'string'],
		['kundenverwaltung_telefon', 'string'],
		['kundenverwaltung_email', 'string'],
		['kundenverwaltung_internet', 'string'],
		['kundenverwaltung_steuernummer', 'string'],
		['kundenverwaltung_kreditinstitut', 'string'],
		['kundenverwaltung_bankleitzahl', 'string'],
		['kundenverwaltung_kontonummer', 'string'],
		['kundenverwaltung_iban', 'string'],
		['kundenverwaltung_bic', 'string'],
		['kundenverwaltung_logo', 'string'],
		['kundenverwaltung_gewerbeart', 'string'],
		['kundenverwaltung_hinweise', 'string']
    ]));

    $content .= rex_view::info('Änderung gespeichert');
}

$content .= '

    <fieldset>

        <dl class="rex-form-group form-group">
			<dt><label for="' . $this->i18n("kundenverwaltung_rechnungssteller") . '">' . $this->i18n("kundenverwaltung_rechnungssteller") . '</label></dt>
				<dd>
					<input class="rex-form-text form-control" type="text" id="rex-form-kundenverwaltung_rechnungssteller" name="config[kundenverwaltung_rechnungssteller]" placeholder="Vorname Name / Firmenname" value="';
					$content .= $this->getConfig('kundenverwaltung_rechnungssteller');
					$content .= '" />
				</dd>
        </dl>
		
        <dl class="rex-form-group form-group">
			<dt><label for="' . $this->i18n("kundenverwaltung_strasse") . '">' . $this->i18n("kundenverwaltung_strasse") . '</label></dt>
				<dd>
					<input class="rex-form-text form-control" type="text" id="rex-form-kundenverwaltung_strasse" name="config[kundenverwaltung_strasse]" placeholder="Straße und Haus-Nr." value="';
					$content .= $this->getConfig('kundenverwaltung_strasse');
					$content .= '" />
				</dd>
        </dl>

        <dl class="rex-form-group form-group">
			<dt><label for="' . $this->i18n("kundenverwaltung_plz-ort") . '">' . $this->i18n("kundenverwaltung_plz-ort") . '</label></dt>
				<dd>
					<input class="rex-form-text form-control" type="text" id="rex-form-kundenverwaltung_plz-ort" name="config[kundenverwaltung_plz-ort]" placeholder="Postleitzahl und Ort" value="';
					$content .= $this->getConfig('kundenverwaltung_plz-ort');
					$content .= '" />
				</dd>
        </dl>

        <dl class="rex-form-group form-group">
			<dt><label for="' . $this->i18n("kundenverwaltung_telefon") . '">' . $this->i18n("kundenverwaltung_telefon") . '</label></dt>
				<dd>
					<input class="rex-form-text form-control" type="text" id="rex-form-kundenverwaltung_telefon" name="config[kundenverwaltung_telefon]" placeholder="Telefon-Nr." value="';
					$content .= $this->getConfig('kundenverwaltung_telefon');
					$content .= '" />
				</dd>
        </dl>

        <dl class="rex-form-group form-group">
			<dt><label for="' . $this->i18n("kundenverwaltung_email") . '">' . $this->i18n("kundenverwaltung_email") . '</label></dt>
				<dd>
					<input class="rex-form-text form-control" type="text" id="rex-form-kundenverwaltung_email" name="config[kundenverwaltung_email]" placeholder="E-Mail-Adresse" value="';
					$content .= $this->getConfig('kundenverwaltung_email');
					$content .= '" />
				</dd>
        </dl>
		
        <dl class="rex-form-group form-group">
			<dt><label for="' . $this->i18n("kundenverwaltung_internet") . '">' . $this->i18n("kundenverwaltung_internet") . '</label></dt>
				<dd>
					<input class="rex-form-text form-control" type="text" id="rex-form-kundenverwaltung_internet" name="config[kundenverwaltung_internet]" placeholder="Internet-Adresse" value="';
					$content .= $this->getConfig('kundenverwaltung_internet');
					$content .= '" />
				</dd>
        </dl>

        <dl class="rex-form-group form-group">
			<dt><label for="' . $this->i18n("kundenverwaltung_steuernummer") . '">' . $this->i18n("kundenverwaltung_steuernummer") . '</label></dt>
				<dd>
					<input class="rex-form-text form-control" type="text" id="rex-form-kundenverwaltung_steuernummer" name="config[kundenverwaltung_steuernummer]" placeholder="Steuer-Nr." value="';
					$content .= $this->getConfig('kundenverwaltung_steuernummer');
					$content .= '" />
				</dd>
        </dl>

        <dl class="rex-form-group form-group">
			<dt><label for="' . $this->i18n("kundenverwaltung_kreditinstitut") . '">' . $this->i18n("kundenverwaltung_kreditinstitut") . '</label></dt>
				<dd>
					<input class="rex-form-text form-control" type="text" id="rex-form-kundenverwaltung_kreditinstitut" name="config[kundenverwaltung_kreditinstitut]" placeholder="Kreditinstitut" value="';
					$content .= $this->getConfig('kundenverwaltung_kreditinstitut');
					$content .= '" />
				</dd>
        </dl>

        <dl class="rex-form-group form-group">
			<dt><label for="' . $this->i18n("kundenverwaltung_bankleitzahl") . '">' . $this->i18n("kundenverwaltung_bankleitzahl") . '</label></dt>
				<dd>
					<input class="rex-form-text form-control" type="text" id="rex-form-kundenverwaltung_bankleitzahl" name="config[kundenverwaltung_bankleitzahl]" placeholder="BLZ" value="';
					$content .= $this->getConfig('kundenverwaltung_bankleitzahl');
					$content .= '" />
				</dd>
        </dl>

        <dl class="rex-form-group form-group">
			<dt><label for="' . $this->i18n("kundenverwaltung_kontonummer") . '">' . $this->i18n("kundenverwaltung_kontonummer") . '</label></dt>
				<dd>
					<input class="rex-form-text form-control" type="text" id="rex-form-kundenverwaltung_kontonummer" name="config[kundenverwaltung_kontonummer]" placeholder="Konto-Nr." value="';
					$content .= $this->getConfig('kundenverwaltung_kontonummer');
					$content .= '" />
				</dd>
        </dl>

        <dl class="rex-form-group form-group">
			<dt><label for="' . $this->i18n("kundenverwaltung_iban") . '">' . $this->i18n("kundenverwaltung_iban") . '</label></dt>
				<dd>
					<input class="rex-form-text form-control" type="text" id="rex-form-kundenverwaltung_iban" name="config[kundenverwaltung_iban]" placeholder="IBAN" value="';
					$content .= $this->getConfig('kundenverwaltung_iban');
					$content .= '" />
				</dd>
        </dl>

        <dl class="rex-form-group form-group">
			<dt><label for="' . $this->i18n("kundenverwaltung_bic") . '">' . $this->i18n("kundenverwaltung_bic") . '</label></dt>
				<dd>
					<input class="rex-form-text form-control" type="text" id="rex-form-kundenverwaltung_bic" name="config[kundenverwaltung_bic]" placeholder="BIC" value="';
					$content .= $this->getConfig('kundenverwaltung_bic');
					$content .= '" />
				</dd>
        </dl>
		
        <dl class="rex-form-group form-group">
			<dt><label for="' . $this->i18n("kundenverwaltung_logo") . '">' . $this->i18n("kundenverwaltung_logo") . '</label></dt>
				<dd>			
					<div class="rex-form-container-field">
						<div class="rex-js-widget rex-js-widget-media">
							<div class="input-group">
								<input class="form-control" type="text" name="config[kundenverwaltung_logo]" value="' . $this->getConfig('kundenverwaltung_logo') . '" id="REX_MEDIA_1" readonly="readonly">
								<span class="input-group-btn">
									<a href="#" class="btn btn-popup" onclick="openREXMedia(1);return false;" title="Öffnen">
										<i class="rex-icon rex-icon-open-mediapool"></i>
									</a>
									<a href="#" class="btn btn-popup" onclick="addREXMedia(1);return false;" title="Neu">
										<i class="rex-icon rex-icon-add-media"></i>
									</a>
									<a href="#" class="btn btn-popup" onclick="deleteREXMedia(1);return false;" title="Entfernen">
										<i class="rex-icon rex-icon-delete-media"></i>
									</a>
									<a href="#" class="btn btn-popup" onclick="viewREXMedia(1);return false;" title="Ansehen">
										<i class="rex-icon rex-icon-view-media"></i>
									</a>
								</span>
							</div>
						</div>
					</div>
				</dd>
		</dl>';

$formElements = [];
$n = [];
$n['label'] = '<label for="' . $this->i18n("kundenverwaltung_gewerbeart") . '">' . $this->i18n('kundenverwaltung_gewerbeart') . '</label>';
$select = new rex_select();
$select->setId('kundenverwaltung_gewerbeart');
$select->setAttribute('class', 'form-control selectpicker');
$select->setName('config[kundenverwaltung_gewerbeart]');
$select->addOption('Kleingewerbe - umsatzsteuerbefreit', 'kleingewerbe');
$select->addOption('Gewerbe - umsatzsteuerpflichtig', 'gewerbe');
$select->setSelected($this->getConfig('kundenverwaltung_gewerbeart'));
$n['field'] = $select->get();
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/form.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="' . $this->i18n("kundenverwaltung_hinweise") . '">' . $this->i18n("kundenverwaltung_hinweise") . '</label>';
$n['field'] = '<textarea id="rex-form-kundenverwaltung_hinweise" name="config[kundenverwaltung_hinweise]" rows="8" style="width: 100%; resize: none;">' . $this->getConfig('kundenverwaltung_hinweise') . '</textarea>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/form.php');

    $content .= '</fieldset>    

</div>';


// Speichern // 

$formElements = [];
$n = [];
$n['field'] = '<button class="btn btn-save" type="submit" name="config-submit" value="1" title="' . $this->i18n('kundenverwaltung_save') . '">' . $this->i18n('kundenverwaltung_save') . '</button>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$buttons = $fragment->parse('core/form/submit.php');
$buttons = '
<fieldset class="rex-form-action">' . $buttons . '</fieldset>';


// Formular-Ausgabe //

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit');
$fragment->setVar('title', $this->i18n('kundenverwaltung_title'));
$fragment->setVar('body', $content, false);
$fragment->setVar('buttons', $buttons, false);
$output = $fragment->parse('core/page/section.php');

$output = '
<form action="' . rex_url::currentBackendPage() . '" method="post" id="kundenverwaltung_settings"><input type="hidden" name="formsubmit" value="1" />' . $output . '</form>';

echo $output;

?>


<script>
    var jSaveInfo = jQuery("#kundenverwaltung-wrapper .alert-info");

    window.setTimeout(function()
    {
        jSaveInfo.slideUp();
    }, 2000);
</script>
