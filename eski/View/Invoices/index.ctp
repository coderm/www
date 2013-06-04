<?php
$tlOptions = array(
    'places' => 2,
    'before' => '',
    'after' => ' TL',
    'escape' => false,
    'decimals' => ',',
    'thousands' => '.'
);
?>
<div class="row">
<h4 class="headline">Fatura Basılacak Müşteriler</h4>
</div>
<table class="table">
    <tr>
        <th>Kullanıcı</th>
        <th>Rezervasyon Sayısı</th>
        <th>Toplam Tutar</th>
        <th>İşlem</th>
    </tr>
<?php
    foreach($clientList as $client)
    {
        echo '<tr>';
            echo '<td>'.$client[0]['invoice_user'].'</td>';
            echo '<td>'.$client[0]['count(booking_id)'].'</td>';
            echo '<td style="text-align:right;">'.$this->Number->format($client[0]['sum(gross_profit)'],$tlOptions).'</td>';
            echo '<td style="text-align:right;">'.$this->Html->link('Kalemleri Görüntüle',array('action'=>'invoiceDetailsList',$client[0]['invoice_user_id']),array('class'=>'btn btn-success btn-mini')).'</td>';
        echo '</tr>';
    }
?>
</table>
