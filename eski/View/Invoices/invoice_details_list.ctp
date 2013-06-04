<?php
$tlOptions = array(
    'places' => 2,
    'before' => '',
    'after' => ' TL',
    'escape' => false,
    'decimals' => ',',
    'thousands' => '.'
);
echo $this->Html->link('Fatura Listesine Geri Dön', array('action' => 'index'),array('class'=>'btn btn-success pull-right'));
echo '<div class="clear"></div>';

$userNameSurname = $invoiceDetailsList[0][0]['invoice_user'];
?>
<h4>Müşteri Bilgisi</h4>
<table class="table">
    <tr>
        <th>Kullanıcı</th>
        <th>Firma</th>
    </tr>
    <tr>
        <td><b><?php echo $userNameSurname; ?></b></td>
        <td><b></b></td>
    </tr>
</table>

<h4>Fatura Listesi</h4>
<?php
echo $this->Form->create('invoiceDetails');
?>
<table class="table">
    <tr>
        <th>Rezervasyon No</th>
        <th>Başlangıç Tarihi</th>
        <th style="text-align:right;">Tutar</th>
        <th style="text-align:right;">KDV</th>
        <th style="text-align:right;">Toplam Tutar</th>
    </tr>
    <?php
    foreach ($invoiceDetailsList as $invoiceDetail)
    {
        echo '<tr>';
        echo '<td>' . $this->Form->checkbox($invoiceDetail[0]['booking_id'], array('value' => '1')) . $invoiceDetail[0]['booking_id'] . '</td>';
        echo '<td>' . $invoiceDetail[0]['start_date'] . '</td>';
        echo '<td style="text-align:right;">' . $this->Number->format($invoiceDetail[0]['net'], $tlOptions) . '</td>';
        echo '<td style="text-align:right;">' . $this->Number->format($invoiceDetail[0]['vat'], $tlOptions) . '</td>';
        echo '<td style="text-align:right;">' . $this->Number->format($invoiceDetail[0]['total'], $tlOptions) . '</td>';
        echo '</tr>';
    }
    ?>
</table>

<center>
    <?php
	echo $this->Html->tag('button','Seçili kalemleri bas',array('class'=>'btn btn-success'));
	echo $this->Form->end(); 
    ?>

</center>





