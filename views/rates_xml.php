<?php
/**
 * @var array $rates
 */
?>
<rates>
    <?php
    foreach ($rates as $rate) {
        ?>
        <item>
            <from><?= $rate['from'] ?></from>
            <to><?= $rate['to'] ?></to>
            <in><?= $rate['in'] ?></in>
            <out><?= $rate['out'] ?></out>
            <minamount><?= $rate['minamount'] ?> <?= $rate['from'] ?></minamount>
            <maxamount><?= $rate['maxamount'] ?> <?= $rate['from'] ?></maxamount>
            <amount><?= $rate['amount'] ?></amount>
            <param><?= $rate['param'] ?></param>
        </item>
        <?php
    }
    ?>
</rates>
