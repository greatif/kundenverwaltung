<?php
/**
 * @author kontakt[at]greatif[dot]de
 * @package redaxo5
 * @license MIT
 */
/** @var rex_addon $this */
// install Kundenverwaltung database

$content = rex_file::get(rex_path::addon('kundenverwaltung', 'dump/yform_table_kunden.json'));
rex_yform_manager_table_api::importTablesets($content);

$content = rex_file::get(rex_path::addon('kundenverwaltung', 'dump/yform_table_kunden_rechnungen.json'));
rex_yform_manager_table_api::importTablesets($content);

rex_delete_cache();
