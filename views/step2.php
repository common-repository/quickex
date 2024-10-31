<?php
/**
 * @var integer $step
 * @var string  $from
 * @var string  $to
 * @var string  $amount
 * @var array   $info
 * @var string  $error
 *
 * @var string  $termsOfUseUrl
 * @var string  $privacyPolicyUrl
 * @var string  $howItWorksUrl
 * @var Quickex $quickex
 */
?>
<form class="q-widget" action="/exchange/create" method="post">
    <input type="hidden" name="from" value="<?= $from ?>"/>
    <input type="hidden" name="to" value="<?= $to ?>"/>
    <input type="hidden" name="amount" value="<?= $amount ?>"/>
    <div class="q-body">
        <?php if (isset($error)) { ?>
            <div class="exchange__error" style="font-size: 13px; top:70px; visibility: visible;">
                <?= $error ?>
            </div>
        <?php } ?>
        <small>Step <?= $step ?>/5</small>
        <span id="qtitle">Enter your destination address</span>

        <div class="fields">
            <div class="field">
                <div class="exchange__error js-exchange-error">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M4.99984 9.58332C2.46853 9.58332 0.416504 7.53129 0.416504 4.99999C0.416504 2.46868 2.46853 0.416656 4.99984 0.416656C7.53114 0.416656 9.58317 2.46868 9.58317 4.99999C9.58317 7.53129 7.53114 9.58332 4.99984 9.58332ZM4.99984 8.74999C7.07091 8.74999 8.74984 7.07106 8.74984 4.99999C8.74984 2.92892 7.07091 1.24999 4.99984 1.24999C2.92877 1.24999 1.24984 2.92892 1.24984 4.99999C1.24984 7.07106 2.92877 8.74999 4.99984 8.74999ZM3.62775 6.96127L4.99979 5.58924L6.37183 6.96127L6.96109 6.37202L5.58905 4.99998L6.96109 3.62794L6.37183 3.03869L4.99979 4.41072L3.62775 3.03869L3.0385 3.62794L4.41054 4.99998L3.0385 6.37202L3.62775 6.96127Z"
                              fill="#F44242"/>
                    </svg>
                    <span class="text">Invalid address</span>
                </div>
                <label>Your <?= $to ?> address</label>
                <div class="q-field-success hidden">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M11 22C4.92487 22 0 17.0751 0 11C0 4.92487 4.92487 0 11 0C17.0751 0 22 4.92487 22 11C22 17.0751 17.0751 22 11 22ZM11 20C15.9706 20 20 15.9706 20 11C20 6.02944 15.9706 2 11 2C6.02944 2 2 6.02944 2 11C2 15.9706 6.02944 20 11 20ZM14.2929 7.29289L9 12.5858L6.70711 10.2929L5.29289 11.7071L9 15.4142L15.7071 8.70711L14.2929 7.29289Z"
                              fill="#0BB526"/>
                    </svg>
                </div>
                <input name="destinationAddress" id="destination_address"
                       class="js-order-field"
                       placeholder="Your <?= $to ?> address"
                       data-currency="<?= $to ?>">
            </div>
            <?php if ($info[$to]['tagname']) { ?>
                <div class="field">
                    <div class="exchange__error js-exchange-error">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M4.99984 9.58332C2.46853 9.58332 0.416504 7.53129 0.416504 4.99999C0.416504 2.46868 2.46853 0.416656 4.99984 0.416656C7.53114 0.416656 9.58317 2.46868 9.58317 4.99999C9.58317 7.53129 7.53114 9.58332 4.99984 9.58332ZM4.99984 8.74999C7.07091 8.74999 8.74984 7.07106 8.74984 4.99999C8.74984 2.92892 7.07091 1.24999 4.99984 1.24999C2.92877 1.24999 1.24984 2.92892 1.24984 4.99999C1.24984 7.07106 2.92877 8.74999 4.99984 8.74999ZM3.62775 6.96127L4.99979 5.58924L6.37183 6.96127L6.96109 6.37202L5.58905 4.99998L6.96109 3.62794L6.37183 3.03869L4.99979 4.41072L3.62775 3.03869L3.0385 3.62794L4.41054 4.99998L3.0385 6.37202L3.62775 6.96127Z"
                                  fill="#F44242"/>
                        </svg>
                        <span class="text">Invalid address</span>
                    </div>
                    <label>Destination Tag</label>
                    <input name="destinationTag" id="destination_tag"
                           placeholder="Enter Your <?= $to ?> Destination Tag"
                           data-currency="<?= $to ?>">
                </div>
            <?php } ?>
            <?php if ($quickex->showRefundAddress) { ?>
                <div class="field">
                    <div class="exchange__error js-exchange-error">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M4.99984 9.58332C2.46853 9.58332 0.416504 7.53129 0.416504 4.99999C0.416504 2.46868 2.46853 0.416656 4.99984 0.416656C7.53114 0.416656 9.58317 2.46868 9.58317 4.99999C9.58317 7.53129 7.53114 9.58332 4.99984 9.58332ZM4.99984 8.74999C7.07091 8.74999 8.74984 7.07106 8.74984 4.99999C8.74984 2.92892 7.07091 1.24999 4.99984 1.24999C2.92877 1.24999 1.24984 2.92892 1.24984 4.99999C1.24984 7.07106 2.92877 8.74999 4.99984 8.74999ZM3.62775 6.96127L4.99979 5.58924L6.37183 6.96127L6.96109 6.37202L5.58905 4.99998L6.96109 3.62794L6.37183 3.03869L4.99979 4.41072L3.62775 3.03869L3.0385 3.62794L4.41054 4.99998L3.0385 6.37202L3.62775 6.96127Z"
                                  fill="#F44242"/>
                        </svg>
                        <span class="text">Invalid address</span>
                    </div>
                    <label>Your refund <?= $from ?> address</label>
                    <div class="q-field-success hidden">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M11 22C4.92487 22 0 17.0751 0 11C0 4.92487 4.92487 0 11 0C17.0751 0 22 4.92487 22 11C22 17.0751 17.0751 22 11 22ZM11 20C15.9706 20 20 15.9706 20 11C20 6.02944 15.9706 2 11 2C6.02944 2 2 6.02944 2 11C2 15.9706 6.02944 20 11 20ZM14.2929 7.29289L9 12.5858L6.70711 10.2929L5.29289 11.7071L9 15.4142L15.7071 8.70711L14.2929 7.29289Z"
                                  fill="#0BB526"/>
                        </svg>
                    </div>
                    <input name="refundAddress" id="refund_address"
                           class="js-order-field"
                           placeholder="Your refund<?= $from ?> address"
                           data-currency="<?= $from ?>">
                </div>
                <?php if ($info[$from]['tagname']) { ?>
                    <div class="field">
                        <div class="exchange__error js-exchange-error">
                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M4.99984 9.58332C2.46853 9.58332 0.416504 7.53129 0.416504 4.99999C0.416504 2.46868 2.46853 0.416656 4.99984 0.416656C7.53114 0.416656 9.58317 2.46868 9.58317 4.99999C9.58317 7.53129 7.53114 9.58332 4.99984 9.58332ZM4.99984 8.74999C7.07091 8.74999 8.74984 7.07106 8.74984 4.99999C8.74984 2.92892 7.07091 1.24999 4.99984 1.24999C2.92877 1.24999 1.24984 2.92892 1.24984 4.99999C1.24984 7.07106 2.92877 8.74999 4.99984 8.74999ZM3.62775 6.96127L4.99979 5.58924L6.37183 6.96127L6.96109 6.37202L5.58905 4.99998L6.96109 3.62794L6.37183 3.03869L4.99979 4.41072L3.62775 3.03869L3.0385 3.62794L4.41054 4.99998L3.0385 6.37202L3.62775 6.96127Z"
                                      fill="#F44242"/>
                            </svg>
                            <span class="text">Invalid address</span>
                        </div>
                        <label>Refund Tag</label>
                        <input name="refundTag" id="refund_tag"
                               placeholder="Enter Your <?= $from ?> Refund Tag"
                               data-currency="<?= $from ?>">
                    </div>
                <?php } ?>
            <?php } ?>

            <div class="field">
                <div class="exchange__error js-exchange-error">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M4.99984 9.58332C2.46853 9.58332 0.416504 7.53129 0.416504 4.99999C0.416504 2.46868 2.46853 0.416656 4.99984 0.416656C7.53114 0.416656 9.58317 2.46868 9.58317 4.99999C9.58317 7.53129 7.53114 9.58332 4.99984 9.58332ZM4.99984 8.74999C7.07091 8.74999 8.74984 7.07106 8.74984 4.99999C8.74984 2.92892 7.07091 1.24999 4.99984 1.24999C2.92877 1.24999 1.24984 2.92892 1.24984 4.99999C1.24984 7.07106 2.92877 8.74999 4.99984 8.74999ZM3.62775 6.96127L4.99979 5.58924L6.37183 6.96127L6.96109 6.37202L5.58905 4.99998L6.96109 3.62794L6.37183 3.03869L4.99979 4.41072L3.62775 3.03869L3.0385 3.62794L4.41054 4.99998L3.0385 6.37202L3.62775 6.96127Z"
                              fill="#F44242"/>
                    </svg>
                    <span class="text">Invalid address</span>
                </div>
                <button type="submit" class="button exchange-button js-submit-order-send" disabled>
                    Next step
                </button>
            </div>
            <div class="field">
                <label class="checkbox-inline">
                    <input type="checkbox" id="q-checkbox-input" class="js-checkbox-admire" value="0">
                    <span>I agree to the <a href="<?= $termsOfUseUrl ?>" target="_blank">Terms of Use</a>, <a
                                href="<?= $howItWorksUrl ?>" target="_blank">How it works</a> and <a
                                href="<?= $privacyPolicyUrl ?>" target="_blank">Privacy Policy</a></span>
                </label>
            </div>
        </div>
    </div>
</form>