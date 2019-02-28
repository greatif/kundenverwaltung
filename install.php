<?php
/**
 * @author kontakt[at]greatif[dot]de
 * @package redaxo5
 * @license MIT
 */
/** @var rex_addon $this */
// install Kundenverwaltung database

rex_sql_table::get(rex::getTable('kunden'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('datestamp', 'datetime'))
    ->ensureColumn(new rex_sql_column('firstname', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('name', 'text'))
    ->ensureColumn(new rex_sql_column('salutation', 'text'))
    ->ensureColumn(new rex_sql_column('title', 'text'))
    ->ensureColumn(new rex_sql_column('street', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('postcode', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('city', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('country', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('phonenumber', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('email', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('customernumber', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('status', 'text'))
    ->ensureColumn(new rex_sql_column('remarks', 'text'))
    ->ensureColumn(new rex_sql_column('password', 'varchar(191)'))
    ->ensure();

rex_sql_table::get(rex::getTable('kunden_rechnungen'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('datestamp', 'datetime'))
    ->ensureColumn(new rex_sql_column('billnumber', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('ordernumber', 'int(11)', true))
    ->ensureColumn(new rex_sql_column('customernumber', 'text'))
    ->ensureColumn(new rex_sql_column('date', 'date'))
    ->ensureColumn(new rex_sql_column('performanceperiod', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('invoiceamount', 'decimal(5,2)', true))
    ->ensureColumn(new rex_sql_column('articles', 'text'))
    ->ensureColumn(new rex_sql_column('notes', 'text'))
    ->ensureColumn(new rex_sql_column('status', 'text'))
    ->ensure();

rex_sql_table::get(rex::getTable('yform_field'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('table_name', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('prio', 'int(11)'))
    ->ensureColumn(new rex_sql_column('type_id', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('type_name', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('db_type', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('list_hidden', 'tinyint(1)'))
    ->ensureColumn(new rex_sql_column('search', 'tinyint(1)'))
    ->ensureColumn(new rex_sql_column('name', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('label', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('not_required', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('options', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('multiple', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('default', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('size', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('only_empty', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('message', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('table', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('field', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('type', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('empty_option', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('types', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('fields', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('address', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('width', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('height', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('attributes', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('preview', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('category', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('values', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('format', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('show_value', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('html', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('notice', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('rules', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('script', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('hashname', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('password_hash', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('no_db', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('password_label', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('empty_value', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('max_size', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('position', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('regex', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('pattern', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('current_date', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('widget', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('query', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('year_start', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('year_end', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('nonce_key', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('nonce_referer', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('sizes', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('messages', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('rules_message', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('scale', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('choices', 'text'))
    ->ensureColumn(new rex_sql_column('precision', 'text'))
    ->ensureColumn(new rex_sql_column('unit', 'text'))
    ->ensureColumn(new rex_sql_column('placeholder', 'text'))
    ->alter();

// install data entries
$sql = rex_sql::factory();

if (sizeof($sql->getArray("SELECT id FROM " . rex::getTable('yform_table') . " WHERE table_name='rex_kunden'")) <= 0) {
    try {
        $sql = rex_sql::factory();
        rex_sql_util::importDump($this->getPath('dump/yform_table_kunden.sql'));
    } catch (rex_sql_exception $e) {
        rex_logger::logException($e);
        print rex_view::error($e->getMessage());
    }
}

if (sizeof($sql->getArray("SELECT id FROM " . rex::getTable('yform_table') . " WHERE table_name='rex_kunden_rechnungen'")) <= 0) {
    try {
        $sql = rex_sql::factory();
        rex_sql_util::importDump($this->getPath('dump/yform_table_kunden_rechnungen.sql'));
    } catch (rex_sql_exception $e) {
        rex_logger::logException($e);
        print rex_view::error($e->getMessage());
    }
}

if (sizeof($sql->getArray("SELECT id FROM " . rex::getTable('yform_field') . " WHERE table_name='rex_kunden'")) <= 0) {
    try {
        $sql = rex_sql::factory();
        rex_sql_util::importDump($this->getPath('dump/yform_field_kunden.sql'));
    } catch (rex_sql_exception $e) {
        rex_logger::logException($e);
        print rex_view::error($e->getMessage());
    }
}

if (sizeof($sql->getArray("SELECT id FROM " . rex::getTable('yform_field') . " WHERE table_name='rex_kunden_rechnungen'")) <= 0) {
    try {
        $sql = rex_sql::factory();
        rex_sql_util::importDump($this->getPath('dump/yform_field_kunden_rechnungen.sql'));
    } catch (rex_sql_exception $e) {
        rex_logger::logException($e);
        print rex_view::error($e->getMessage());
    }
}
