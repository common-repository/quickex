<?php
/**
 * @var string  $content
 * @var Quickex $quickex
 */
?>
<?php
if ($quickex->showHeader) {
    get_header();
} else {
    wp_head();
}
if (function_exists('wp_body_open')) {
    wp_body_open();
}
?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <?= $content ?>
        </main>
    </div>
<?php
if ($quickex->showFooter) {
    get_footer();
} else {
    wp_footer();
}
?>