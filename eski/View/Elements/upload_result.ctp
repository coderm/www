<?php 

    $result = '<div style="position:relative;float:left;clear:none;padding:8px;margin:5px;background-color:#fff;color:#000;text-align:center;border:1px solid #166a9a;">';
    $result.= '<input type="hidden" value="'.$fileName.'#'.$filePath.'" name="data[Advertisement][images]['.$fileName.']">';
    $result.= '<span class="imageThumb">';
    $result.= '<img src="/'.$filePath.'"/>';
    $result.= '</span>';
    $result.= '<span>';
    $result.= '<span class="imageRemove">Sil</span>';
    $result.= '</span>';
    $result.= '</div>';
    if($inlineElement==true)
    {
        echo $result;
    } else
    {
?>
<script type="text/javascript">
//<![CDATA[
   parent.uploadResultHandler('<?php echo $result?>','<?php echo $fileName.'#'.$filePath?>');
//]]>
</script>
<?php
    }
?>
