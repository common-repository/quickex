<?php
/**
 * @var integer $id
 * @var integer $step
 * @var string  $status
 * @var string  $statusName
 * @var string  $progress
 * @var string  $from
 * @var string  $to
 * @var string  $depositAddress
 * @var string  $depositTag
 * @var string  $destinationAddress
 * @var string  $destinationTag
 * @var string  $refundAddress
 * @var string  $refundTag
 * @var string  $expectedAmountFrom
 * @var string  $expectedAmountTo
 * @var string  $amountFrom
 * @var string  $amountTo
 * @var string  $date
 * @var array   $info
 */
?>
<form class="q-widget" action="/exchange/create">
    <div class="q-body">
        <small>Step <?= $step ?>/4</small>
        <span id="qtitle">Send <?= $expectedAmountFrom ?> <?= $from ?></span>
        <span class="qtitle-text">to the address below as one transaction</span>
        <div class="send-address">
            <label>Address</label>
            <div class="address-block">
                <div class="address-padding">
                    <span class="address-value" id="address-value-id"><?= $depositAddress ?></span>
                    <a class="copy-link" data-id="address-value-id">Copy</a>
                </div>
            </div>
            <?php if ($depositTag) { ?>
                <label style="margin-top: 5px;"><?= $info[$from]['tagname'] ?></label>
                <div class="address-block">
                    <div class="address-padding">
                        <span class="address-value" id="tag-value-id"><?= $depositTag ?></span>
                        <a class="copy-link" data-id="tag-value-id">Copy</a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="block">
            <label class="header">Date</label>
            <label class="value"><?= $date ?></label>
        </div>
        <div class="exchange-status">
            <div class="bg"></div>
            <div class="progress" style="width: <?= $progress ?>"></div>
            <span class="status-name"><?= $statusName ?></span>
        </div>
        <div class="time-text">
            You have 3 hours to send funds otherwise the transaction will be canceled automatically
        </div>
        <div class="info">
            <div class="transaction-info">
                <div class="block">
                    <label class="header">You send</label>
                    <label class="value"><?= $amountFrom ? $amountFrom : $expectedAmountFrom ?> <?= $from ?></label>
                </div>
                <div class="block">
                    <label class="header">You get</label>
                    <label class="value"><?= $expectedAmountTo ?> <?= $to ?></label>
                </div>
                <div class="block">
                    <label class="header">Estimated arrival</label>
                    <label class="value">&#8776; 5-30 minutes</label>
                </div>
            </div>
            <div class="destination-info">
                <div class="block">
                    <label class="header">Destination address</label>
                    <label class="value"><?= $destinationAddress ?></label>
                </div>
                <?php if ($destinationTag) { ?>
                    <div class="block">
                        <label class="header">Destination Tag</label>
                        <label class="value"><?= $refundTag ?></label>
                    </div>
                <?php } ?>
                <div class="block">
                    <label class="header">Refund address</label>
                    <label class="value"><?= $refundAddress ?></label>
                </div>
                <?php if ($refundTag) { ?>
                    <div class="block">
                        <label class="header">Refund Tag</label>
                        <label class="value"><?= $refundTag ?></label>
                    </div>
                <?php } ?>
                <div class="block">
                    <label class="header">Date</label>
                    <label class="value"><?= $date ?></label>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    var txid = '<?=$id?>';
</script>