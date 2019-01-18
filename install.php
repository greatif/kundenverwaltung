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
    ->ensureColumn(new rex_sql_column('companyname', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('place', 'varchar(191)'))
    ->ensure();

rex_sql_table::get(rex::getTable('kunden_rechnungen'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('datestamp', 'datetime'))
    ->ensureColumn(new rex_sql_column('billnumber', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('ordernumber', 'int(11)', true))
    ->ensureColumn(new rex_sql_column('costumernumber', 'text'))
    ->ensureColumn(new rex_sql_column('date', 'date'))
    ->ensureColumn(new rex_sql_column('invoiceamount', 'decimal(5,2)', true))
    ->ensureColumn(new rex_sql_column('articles', 'text'))
    ->ensureColumn(new rex_sql_column('notes', 'text'))
    ->ensureColumn(new rex_sql_column('status', 'text'))
    ->ensureColumn(new rex_sql_column('paystatus', 'text'))
    ->ensure();

rex_sql_table::get(rex::getTable('yform_field'))
    ->ensurePrimaryIdColumn()
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
