<?php
$quickex = Quickex::init();
$quickex->saveParams();
?>

<div class="wrap">
    <h2><?php echo get_admin_page_title() ?></h2>
    <?php
    $alert = $quickex->getAlert();
    if ($alert !== null) {
        ?>
        <div class="alert alert-success" role="alert">
            <strong><?= $alert['title'] ?></strong> <?= $alert['text'] ?>
        </div>
        <style>
            .alert {
                padding: .75rem 1.25rem;
                margin-bottom: 1rem;
                border: 1px solid transparent;
                border-radius: .25rem;
            }

            .alert-success {
                background-color: #dff0d8;
                border-color: #d0e9c6;
                color: #3c763d;
            }
        </style>
    <?php } ?>
    <form method="POST">
        <table class="form-table" role="presentation">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="quickex_api_key">API KEY</label>
                </th>
                <td>
                    <input name="quickex_api_key" type="text" value="<?= $quickex->apiKey ?>" class="regular-text ltr">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="quickex_main_url">Main url</label>
                </th>
                <td>
                    <input name="quickex_main_url" type="text" value="<?= $quickex->mainUrl ?>"
                           class="regular-text ltr">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="quickex_main_url">"Terms of Use" url</label>
                </th>
                <td>
                    <input name="quickex_terms_of_use_url" type="text" value="<?= $quickex->termsOfUseUrl ?>"
                           class="regular-text ltr">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="quickex_how_it_works_url">"How it works" url</label>
                </th>
                <td>
                    <input name="quickex_how_it_works_url" type="text" value="<?= $quickex->howItWorksUrl ?>"
                           class="regular-text ltr">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="quickex_main_url">"Privacy Policy" url</label>
                </th>
                <td>
                    <input name="quickex_privacy_policy_url" type="text" value="<?= $quickex->privacyPolicyUrl ?>"
                           class="regular-text ltr">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="default_email_category">Main color:</label>
                </th>
                <td>
                    <input name="quickex_theme_color" class="jscolor jscolor-active" type="text"
                           value="<?= $quickex->themeColor ?>" class="regular-text ltr">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="default_email_category">Button text color:</label>
                </th>
                <td>
                    <input name="quickex_theme_text_color" class="jscolor jscolor-active" type="text"
                           value="<?= $quickex->themeTextColor ?>" class="regular-text ltr">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="default_email_category">Show Header:</label>
                </th>
                <td>
                    <input name="quickex_show_header" type="checkbox"
                           value="1" <?= $quickex->showHeader ? "checked='checked'" : "" ?> class="regular-text ltr">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="default_email_category">Show Footer:</label>
                </th>
                <td>
                    <input name="quickex_show_footer" type="checkbox"
                           value="1" <?= $quickex->showFooter ? "checked='checked'" : "" ?> class="regular-text ltr">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="quickex_show_refund_address">Show Refund Address:</label>
                </th>
                <td>
                    <input name="quickex_show_refund_address" type="checkbox"
                           value="1" <?= $quickex->showRefundAddress ? "checked='checked'" : "" ?> class="regular-text ltr">
                </td>
            </tr>
            </tbody>
        </table>
        <?php
        settings_fields('option_group');     // скрытые защитные поля
        do_settings_sections('quickex'); // секции с настройками (опциями). У нас она всего одна 'section_id'
        submit_button();
        ?>
    </form>

    <table class="form-table" role="presentation">
        <tbody>
        <tr>
            <th scope="row">
                <label for="mailserver_login">Шорткод</label>
            </th>
            <td>
                <code>
                    [quickex {"from":"BTC","to":"XMR","amount":"0.1"}]
                </code>
            </td>
        </tr>
        </tbody>
    </table>
</div>