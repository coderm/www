<center>
<?php
$hasPages = ($this->params['paging'][$modelName]['pageCount'] > 1);
if ($hasPages)
{
    echo $this->Paginator->prev('« Önceki', array('escape'=>false), null, array('class' => 'disabled'));
    echo '&nbsp;&nbsp;&nbsp;';
    echo $this->Paginator->numbers();
    echo '&nbsp;&nbsp;&nbsp;';
    echo $this->Paginator->next('Sonraki »', array('escape'=>false), null, array('class' => 'disabled'));
    echo '<br/>';
}

$params = $this->Paginator->params();
if($params['page']>$params['pageCount'] && $params['pageCount']>0)
{
    $namedParams = $this->params['named'];
        
    $namedParams['page'] = 1;
    
    $controller = $this->params['controller'];
    $action = $this->params['action'];
    
    $a = array('controller'=>$controller,'action'=>$action);
    $a = array_merge($a,$namedParams);
    
    $url = $this->Html->url($a);

    header( 'Location: '.$url ) ;
    exit;
}
echo $this->Paginator->counter('Toplam {:count} sonuç bulundu<br/>Sayfa: {:page} / {:pages}');

?>
</center>