<?PHP
if (rex_i18n::getLocale() != 'de_de') {
    $file = rex_file::get(rex_path::addon('kundenverwaltung', 'README.md'));
} else {
    $file = rex_file::get(rex_path::addon('kundenverwaltung', 'README_de_de.md'));
}
$body = '<div class="markdown-body">' . rex_markdown::factory()->parse($file) . '</div>';
$fragment = new rex_fragment();
$fragment->setVar('body', $body, false);
$content = '<div class="FoR-help">' . $fragment->parse('core/page/section.php') . '</div>';
echo '<div class="cke5-help-page">' . $content . '</div>';