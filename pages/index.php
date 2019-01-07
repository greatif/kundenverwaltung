<?php
echo rex_view::title('<i class="rex-icon fa-pencil-square-o"></i> Kundenverwaltung');
$subpage = rex_be_controller::getCurrentPagePart(2);
rex_be_controller::includeCurrentPageSubPath();