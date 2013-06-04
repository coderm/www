<td style="text-align: center;">
<?php
    $normPrice = round($houseHolderPrice * 0.36 + 0.05) * 5;
    
    $prefix = $postfix = '';
    $postfix = '<span style="font-size:12px;padding-left:3px;">'.$currencySymboll.'</span>';

    echo '<b>'.$label.'</b><br/>';
    if($isPartner)
        echo '<span style="text-decoration: line-through;color:red;font-size:14px;">'.$prefix.$normPrice.$postfix.'</span><br/>';
    echo '<span style="font-size:22px;">'.$prefix.$price.$postfix.'</span>';
?>
</td>
