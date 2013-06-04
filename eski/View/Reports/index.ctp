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
<h2>Raporlar</h2>
<h3>Brüt kar (bugün)</h3>
<b><?php echo $this->Number->format($todaysTotalProfit,$tlOptions); ?></b>
<br/><br/>
</hr>
<br/><br/>
<h3>Ay bazında elde edilen brüt karlar</h3>
<table class="table">
    <tr>
    <th>Ay</th>
    <th>Brüt Kar</th>
    </tr>
<?php
    
    foreach($monthlyTotalProfits as $monthlyTotalProfit)
    {
        $month = $monthlyTotalProfit['monthly']['month'];
	if($month<10)
	    $month = "0".$month;
        echo '<tr>';
            echo '<td>'.$monthlyTotalProfit['monthly']['year'].'-'.$month.'</td>';
            echo '<td>'.$this->Number->format($monthlyTotalProfit['monthly']['total'],$tlOptions).'</td>';
        echo '</tr>';
    }
?>  
</table>

<b><?php echo 'Bürüt Kar Toplamı: '.$this->Number->format($totalProfit,$tlOptions); ?></b>
<br/><br/>
</hr>
<br/><br/>
<h3>Yapılmamış Ev Sahibi Ödemeleri (Aylık)</h3>
<table class="table">
    <tr>
    <th>Ay</th>
    <th>Ödeme Sayısı</th>
    <th>Toplam Ödeme Tutarı</th>
    </tr>    
<?php
    

    foreach($monthlyHouseHolderPayments as $date=>$houseHolderPayments)
    {
	if($date=='total')
	{
	    $total = $this->Number->format($houseHolderPayments['price'],$tlOptions);
	} else if($date == 'today')
	{
	    $todayTotal = $this->Number->format($houseHolderPayments['price'],$tlOptions); 
	    $todayPaymentsCount = $houseHolderPayments['count'];
	}
	else
	{
	    $date = explode("-", $date);

	    $month = $date[0];
	    if($month<10)
		$month = "0".$month;
	    echo '<tr>';
		echo '<td>'.$date[1].'-'.$month.'</td>';
		echo '<td>'.$houseHolderPayments['count'].'</td>';
		echo '<td>'.$this->Number->format($houseHolderPayments['price'],$tlOptions).'</td>';
	    echo '</tr>';
	}
    }
?>  
</table>

<b><?php echo 'Ödemeler Toplamı: '.$total; ?></b><br/>
<b><?php echo 'Bugün yapılacak '.$todayPaymentsCount.' adet , toplam ' .$todayTotal .' ödeme mevcut!'; ?></b>




<br/><br/>
<h3>Müşterilerden Alacaklar (Aylık)</h3>
<table class="table">
    <tr>
    <th>Ay</th>
    <th>Ödeme Sayısı</th>
    <th>Toplam Alacak Tutarı</th>
    </tr>    
<?php
    

    foreach($monthlyPendingReceivables as $date=>$monthlyReceievables)
    {
	if($date=='total')
	{
	    $total = $this->Number->format($monthlyReceievables['price'],$tlOptions);
	} else if($date == 'today')
	{
	    $todayTotal = $this->Number->format($monthlyReceievables['price'],$tlOptions); 
	    $todayPaymentsCount = $monthlyReceievables['count'];
	}
	else
	{
	    $date = explode("-", $date);

	    $month = $date[0];
	    if($month<10)
		$month = "0".$month;
	    echo '<tr>';
		echo '<td>'.$date[1].'-'.$month.'</td>';
		echo '<td>'.$monthlyReceievables['count'].'</td>';
		echo '<td>'.$this->Number->format($monthlyReceievables['price'],$tlOptions).'</td>';
	    echo '</tr>';
	}
    }
?>  
</table>

<b><?php echo 'Alacaklar Toplamı: '.$total; ?></b><br/>
<b><?php echo 'Bugün tahsil edilecek '.$todayPaymentsCount.' adet, toplam ' .$todayTotal .' alacak mevcut!'; ?></b>