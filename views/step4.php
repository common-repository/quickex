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
<div class="q-widget">
    <div class="q-body">
        <a href="/">
            <svg width="18" height="11" viewBox="0 0 18 11" fill="none" xmlns="http://www.w3.org/2000/svg"
                 style="float: left;">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M2.26577 5.92897L5.99009 9.77258L5.15312 10.6364L0 5.31818L5.15312 0L5.99009 0.863782L2.26577 4.7074H18V5.92897H2.26577Z"
                      fill="#BCBFC2"/>
            </svg>
            <small class="breadcrumbs-label" style="float: left;">
                Main page
            </small>
        </a>
        <span class="title">Congratulations</span>
        <span class="text">Your exchange has ended</span>
        <a type="submit" class="new-exchange-btn" href="/">
            New exchange
        </a>
        <div class="info">
            <div class="transaction-info">
                <div class="block">
                    <label class="header">You send</label>
                    <label class="value"><?= $amountFrom ?> <?= $from ?></label>
                </div>
                <div class="block">
                    <label class="header">You get</label>
                    <label class="value"><?= $amountTo ?> <?= $to ?></label>
                </div>
                <div class="block">
                    <label class="header">Date</label>
                    <label class="value"><?= $date ?></label>
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
            </div>
        </div>
    </div>
</div>
<style>
    .q-body .breadcrumbs-label {
        line-height: 12px;
    }

    .q-body .title {
        font-weight: bold;
        font-size: 28px;
        line-height: 34px;
        text-align: center;
        display: block;
        margin-top: 40px;
    }

    .q-body .text {
        font-size: 14px;
        line-height: 18px;
        text-align: center;
        color: #848E9C;
        display: block;
    }

    .q-body .new-exchange-btn {
        background: #F0B90B;
        border-radius: 3px;
        width: 100%;
        display: block;
        font-size: 18px;
        line-height: 48px;
        align-items: center;
        text-align: center;
        margin-top: 12px;
    }

    .q-body .info {
        margin-top: 36px;
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
    }

    .q-body .info .transaction-info {
        min-width: 160px;
    }

    .q-body .info .destination-info {
        margin-left: 24px;
        width: calc(100% - 160px);
    }

    .q-body .block {
        margin-top: 17px;
    }

    .q-body .block .header {
        font-size: 14px;
        line-height: 17px;
        color: rgba(132, 142, 156, 0.5);
        display: block;
    }

    .q-body .block .value {
        font-weight: bold;
        font-size: 14px;
        line-height: 17px;
        color: #848E9C;
        display: block;
        word-wrap: break-word;
    }
</style>