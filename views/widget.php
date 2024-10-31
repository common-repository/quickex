<?php

$from   = isset($from) ? strtoupper($from) : "BTC";
$to     = isset($to) ? strtoupper($to) : "ETH";
$amount = isset($amount) ? $amount : "0.2";

$quickex = Quickex::init();
$currencies   = $quickex->api->getСurrencies(true);
?>
<form class="q-widget" action="/exchange/step-2">
    <div class="q-header">
        Exchange cryptocurrency
    </div>
    <div class="q-body">
        <div class="q-from">
            <div class="exchange__error js-exchange-error js-exchange-error-from">
                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M4.99984 9.58332C2.46853 9.58332 0.416504 7.53129 0.416504 4.99999C0.416504 2.46868 2.46853 0.416656 4.99984 0.416656C7.53114 0.416656 9.58317 2.46868 9.58317 4.99999C9.58317 7.53129 7.53114 9.58332 4.99984 9.58332ZM4.99984 8.74999C7.07091 8.74999 8.74984 7.07106 8.74984 4.99999C8.74984 2.92892 7.07091 1.24999 4.99984 1.24999C2.92877 1.24999 1.24984 2.92892 1.24984 4.99999C1.24984 7.07106 2.92877 8.74999 4.99984 8.74999ZM3.62775 6.96127L4.99979 5.58924L6.37183 6.96127L6.96109 6.37202L5.58905 4.99998L6.96109 3.62794L6.37183 3.03869L4.99979 4.41072L3.62775 3.03869L3.0385 3.62794L4.41054 4.99998L3.0385 6.37202L3.62775 6.96127Z"
                          fill="#F44242"/>
                </svg>
                <span class="text">Minimum allowed is 0.1</span>
            </div>
            <label>You send</label>
            <input name="amount" id="amount-from" type="tel" placeholder="..."
                   class="target exchange__input js-onlyNumbers js-exchange-input js-exchange-from"
                   value="<?= $amount ?>">
            <select name="from" id="currency-from" class="target js-select-currency js-select-currency-1">

                <?php foreach ($currencies as $currency => $params) {
                    $selected = $currency == $from ? 'selected' : '';
                    echo "<option value='{$currency}' {$selected}>{$currency}</option>";
                } ?>
            </select>
        </div>
        <div class="reverse js-reverse">
            <svg width="21" height="18" viewBox="0 0 21 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M6.66672 2.60947V17H5.33338V2.60947L1.13812 6.80474L0.195312 5.86193L6.00005 0.0571899L11.8048 5.86193L10.862 6.80474L6.66672 2.60947Z"
                      fill="#212833"/>
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M14.3333 15.3905L14.3333 0.999999L15.6666 1L15.6666 15.3905L19.8619 11.1953L20.8047 12.1381L14.9999 17.9428L9.19521 12.1381L10.138 11.1953L14.3333 15.3905Z"
                      fill="#212833"/>
            </svg>
        </div>
        <div class="q-to">
            <div class="exchange__info">
                <span class="text">Expected exchange rate</span>
            </div>
            <label>You get</label>
            <input name="amount-to" id="amount-to" type="tel" placeholder="..."
                   class="target exchange__input js-onlyNumbers js-exchange-input js-exchange-to">
            <select name="to" id="currency-to" class="target js-select-currency js-select-currency-2">
                <option value="<?= $to ?>"><?= $to ?></option>
            </select>
        </div>
        <button type="submit" class="button exchange-button js-exchange-button">
            Exchange now
        </button>
    </div>
</form>