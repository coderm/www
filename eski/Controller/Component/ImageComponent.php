<?php
App::import('Vendor', 'SimpleImage');
class ImageComponent extends Component 
{
    var $resultMessage ='';
    var $filePath ='';
    
    var $originalImagePath;
    var $galleryImagePath;
    var $listingThumbPath;
    var $galleryThumbPath;
    
    var $fileName ='';
    var $fileExtension = '';
    var $uploadDir = '';

    
    public function uploadImageFromURL($url,$uploadFileDir)
    {
        pr($url);
        $this->fileExtension = $this->getFileExtension($url);
        if($this->fileExtension=='')
                return;
            
        $this->fileName = uniqid().'.'.$this->fileExtension;
        
        $this->uploadDir = $uploadFileDir;
        $this->filePath = $this->uploadDir."/" . $this->fileName;
        $this->thumbPath = $this->uploadDir."/thumb_" . $this->fileName;          

            $parsedURL = parse_url($url);
            $path = $parsedURL['path'];
            //$path = str_replace('İ', '%C4%B0', $path);
            $path = implode('/', array_map("utf8_encode", explode("/", $path)));
            $path = implode('/', array_map("urlencode", explode("/", $path)));
            //$path = str_replace('+', '%20', $path);
            $path = str_replace('%C3%83%C2%96', '%C3%96', $path);
            $path = str_replace('%C3%83%C2%9C', '%C3%9C', $path);
            $path = str_replace('%C3%84%C2%B0', '%C4%B0', $path);
            $path = str_replace('%C3%83%C2%87', '%C3%87', $path);
            $path = str_replace('%C3%84%C2%B1', '%C4%B1', $path);
            $path = str_replace('%C3%85%C2%9F', '%C5%9F', $path);
            $path = str_replace('%C3%85%C2%9F', '%C5%9F', $path);
            $path = str_replace('%C3%83%C2%B6', '%C3%B6', $path);

            /*
            %C3%84%C2%B1
            %C3%85%C2%9F
            %C4%B1
            %C5%9F
            %20*/
            

            //$path = $this->utf8_rawurldecode($path);
            $path = str_replace('+', '%20', $path);

                
            $u = $parsedURL['scheme'].'://'.$parsedURL['host'].$path;
            

            $image = new SimpleImage();
            $image->load($u);
            $image->fit(670,502);
            $image->save($this->filePath);
            
            $image->fit(150,120);
            $image->save($this->thumbPath);
    }
    

    function utf8_rawurldecode($raw_url_encoded){ 
    $enc = rawurldecode($raw_url_encoded); 
    if(utf8_encode(utf8_decode($enc))==$enc){; 
    return rawurldecode($raw_url_encoded); 
    }else{ 
    return utf8_encode(rawurldecode($raw_url_encoded)); 
    } 
    } 

    
    public function upload($file, $uploadFileDir)
    {
        $this->fileName = uniqid().'.'.$this->getFileExtension($file["name"]);
        $this->uploadDir = $uploadFileDir;
        $this->filePath = $this->uploadDir."/" . $this->fileName;
	
        $fileType = $file["type"];
        $fileSize = $file["size"];
        $fileError = $file["error"];
        $fileTmpName = $file["tmp_name"];
        if ((($fileType  == "image/gif")
                || ($fileType  == "image/jpeg")
                || ($fileType  == "image/pjpeg")
                || ($fileType  == "image/png")
                )
                && ($fileSize < 10000000))
                  {
                  if ( $fileError> 0)
                    {
                        //$result = "<div id='status'>error</div>";
                        //$result .= '<div id="message">'. $file["error"] .'</div>';  
                        return false;
                    }
                    else
                    {


                      if (file_exists($this->fileName))
                      {
                        return false;                        
                      }
                      else
                      {
			  $this->createAdvertImageSet($fileTmpName);
                          return true;
                      }
                    }
                  }
                else
                  {
                        return false;
                  }
    }
    
    function createAdvertImageSet($sourcePath, $createFromOriginal = false)
    {

	$image = new SimpleImage();
	
	if($createFromOriginal)
	{
	    $path_parts = pathinfo($sourcePath);
	    $this->uploadDir = $path_parts['dirname'];
	    $this->fileName = $path_parts['filename'].'.'.$path_parts['extension'];	
	    $this->fileName = str_replace('original_', '', $this->fileName);
	} 
	
	$this->originalImagePath = $this->uploadDir.'/original_'.$this->fileName;
	$this->galleryImagePath = $this->uploadDir.'/'.$this->fileName;
	$this->listingThumbPath = $this->uploadDir.'/thumb_'.$this->fileName;
	$this->galleryThumbPath = $this->uploadDir.'/gallery_thumb_'.$this->fileName;	
	
	
	
	if(!$createFromOriginal)
	{
	    $image->load($sourcePath);
	    $image->save($this->originalImagePath, IMAGETYPE_JPEG, 100);
	}
	
	$image->load($sourcePath);
	$image->fit(587,389,false,true);
	$image->save($this->galleryImagePath, IMAGETYPE_JPEG, 90);	
	
	$image->load($sourcePath);
	$image->fit(150,112,true,false);
	$image->save($this->listingThumbPath, IMAGETYPE_JPEG, 90);

	$image->load($sourcePath);
	$image->fit(125,82,true,false);
	$image->save($this->galleryThumbPath, IMAGETYPE_JPEG, 90);
    }
    
    
    //function to return file extension from a path or file name
    function getFileExtension($path)
    {
        $parts=pathinfo($path);

        if(isset($parts['extension']))
            return $parts['extension'];
        else 
            return '';
    }
    //function to return file name from a path
    function getFileName($path)
    {
        $parts=pathinfo($path);
        return $parts['basename'];
    }
    
}
?>
