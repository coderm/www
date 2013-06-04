<?php
class LocalesController extends AppController
{
    function beforeFilter() 
    {
	//Configure::write('debug', 0);
        parent::beforeFilter();
    }  
    
    function language($val = 'tur')
    {
	$this->Session->write('Config.language', $val);
	$this->redirect($this->referer());
    }
    
    function update()
    {
	$data = array();
	
	$poFilePath = ROOT . "/app/Locale/".$this->request->data['lang']."/LC_MESSAGES/default.po";
	$poFile = fopen($poFilePath,"r+",true);
	
	if(!$poFile)
	{
	    $data['success'] = false;
	    return $data;
	}
	
	$newLine = '';
	$allPoContent = '';
	$alreadySetInContent = false;
	
	$newMsgStr = $this->request->data['msgStr'];
	$newMsgStr = str_replace(array("\r","\n"),"",$newMsgStr);


	
	while(!feof($poFile))
	{
	     $newLine = $lineContent = fgets($poFile);
	     $lineContent = str_replace("\r\n", '', $lineContent);
	     $lineContent = str_replace("\"", '', $lineContent);
	     $lineContent = trim($lineContent);

	     if(strpos($lineContent,"msgid")!==false)
	     {
		$msgId = $lineContent;
		$msgId = str_replace("msgid", "", $msgId);
		$msgId = trim($msgId);
		if($msgId == $this->request->data['msgId'] )
		{
		    $msgStr = fgets($poFile);
		    $newLine.= "msgstr \"".$newMsgStr."\"\r\n";
		    $alreadySetInContent = true;
		}
		
	     }
	     
	     $allPoContent.=$newLine;
	}
	
	
	if(!$alreadySetInContent)
	{
	    $allPoContent.= "\r\n";
	    $allPoContent.= "msgid \"".$this->request->data['msgId']."\"\r\n";
	    $allPoContent.= "msgStr \"".$newMsgStr."\"\r\n";
	}
	
	
	
	
	fclose($poFile);
	
	$poFile = fopen($poFilePath,"w+",true);
	if(!$poFile)
	{
	    $data['success'] = false;
	    return $results;
	}
	
	if(!fwrite($poFile,$allPoContent))
	{
	    $data['success'] = false;
	    return $results;
	}
	fclose($poFile);
	
	$data['success'] = true;
	
	$this->set(compact('data'));
	$this->set('_serialize',array('data'));
    }
}
?>
