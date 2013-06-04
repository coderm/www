<?php
App::uses('Sanitize', 'Utility');
class SiteToolsController extends AppController
{

    public $components = array('Image');
    public $name = 'SiteTools';
    
    public function beforeFilter()
    {
	parent::beforeFilter();
	
	
	if(!isset($this->userPermissions['lp_user_is_admin']))
	    $this->redirect('/');
	
	if(isset($this->userPermissions['lp_user_is_admin']) && $this->userPermissions['lp_user_is_admin']!=1)
	    $this->redirect('/');
	
	
    }

    function backUp()
    {
	$this->SiteTool->backup_database_tables('*');
    }

    function import($firmName)
    {
	$userId = CakeSession::read('User.Id');


	$this->set('firmName', $firmName);
	switch ($firmName)
	{
	    case "deska":
		$result = $this->SiteTool->getNextDeskaData();
		$advert = $result['vw_deskarental_adverts'];
		break;
	    case "villaTurizm":
		$result = $this->SiteTool->getNextVillaTurizmData();
		$advert = $result[0]['vt_adverts'];
		break;
	}


	$result = $result[0];

	$category = $advert['advert_class_id'];

	$this->loadModel('Advertisement');
	$result = $this->Advertisement->query('CALL prt_advert_add(' . $userId . ',' . $category . ')');
	$advertId = $result[0][0]['advert_id'];

	$uploadFileDir = 'upload/' . 'advert_' . $advertId;
	mkdir($uploadFileDir);

	pr($advertId . " nolu ilan ekleniyor...");

	$pictureOrder = 0;
	foreach (array_keys($advert) as $key)
	{
	    $skipThis = false;
	    $advertDetail = $advert[$key];

	    if (strpos($key, 'ldc_advert_picture_') !== false)
		$key = 'ldc_advert_picture';

	    $detailClassId = $this->SiteTool->getDetailClassIdByTextId($key);
	    if ($detailClassId !== false)
	    {
		if ($key == 'ldc_advert_picture')
		{
		    $this->Image->uploadImageFromURL($advertDetail, $uploadFileDir);

		    if ($this->Image->fileExtension != "")
		    {
			$advertDetail = 'name=>' . $this->Image->fileName . '[|]' . 'order=>' . $pictureOrder;
			$pictureOrder++;
		    } else
		    {
			$skipThis = true;
		    }
		}

		if (!$skipThis)
		{
		    $advertDetail = Sanitize::clean($advertDetail, array('encode' => false));
		    $advert_detail_add_result = $this->Advertisement->query('CALL prt_advert_detail_add(' . $userId . ',' . $advertId . ',' . $detailClassId . ',"' . $advertDetail . '")');
		}
	    } else
	    {
		switch ($key)
		{
		    case 'deskarental_advert_id':
			$importId = $advertDetail;
			break;
		    case 'vt_id':
			$importId = $advertDetail;
			break;
		}
	    }
	}
	$status = 'passive';
	$advert_confirm_result = $this->Advertisement->query('CALL prt_advert_confirm(' . $userId . ',' . $advertId . ',"' . $status . '")');


	switch ($firmName)
	{
	    case "deska":
		$this->Advertisement->query('UPDATE _deskarental_villa SET tatilevim_id = ' . $advertId . ' where UniqueKey =' . $importId);
		break;
	    case "villaTurizm":

		$villaTurizmImagesResult = $this->Advertisement->query('SELECT * FROM vt_pictures WHERE vt_id=' . substr($importId, 0, 3) . ' ORDER BY is_main DESC');
		$pictureOrder = 0;
		foreach ($villaTurizmImagesResult as $image)
		{
		    $skipThis = false;
		    $imageUrl = $image['vt_pictures']['picture_name'];
		    $this->Image->uploadImageFromURL($imageUrl, $uploadFileDir);
		    if ($this->Image->fileExtension != "")
		    {
			$advertDetail = 'name=>' . $this->Image->fileName . '[|]' . 'order=>' . $pictureOrder;
			$pictureOrder++;
		    } else
		    {
			$skipThis = true;
		    }

		    if (!$skipThis)
			$advert_detail_add_result = $this->Advertisement->query('CALL prt_advert_detail_add(' . $userId . ',' . $advertId . ',11,"' . $advertDetail . '")');
		}
		$this->Advertisement->query('UPDATE vt_adverts SET advert_id = ' . $advertId . ' where vt_id =' . $importId);
		break;
	}

	//$this->redirect($this->here.'?r='.  uniqid());  
    }

    public function to_duplicate($sourceAdvertId, $count)
    {
	$userId = CakeSession::read('User.Id');
	$this->loadModel('Advertisement');

	$details = $this->Advertisement->query('select * from vw_get_advert_details where advert_id =' . $sourceAdvertId);

	$category = $details['0']['vw_get_advert_details']['advert_class'];
	$category = $this->Advertisement->query('select advert_class_id FROM lu_adverts_class where message_text_id ="' . $category . '"');
	$category = $category['0']['lu_adverts_class']['advert_class_id'];
	for ($counter = 1; $counter <= $count; $counter++)
	{
	    $advert = $this->Advertisement->query('CALL prt_advert_add(' . $userId . ',' . $category . ')');
	    $advertId = $advert[0][0]['advert_id'];
	    ECHO $advertId;
	    $uploadFileDir = 'upload/' . 'advert_' . $advertId;
	    $copyFileDir = 'upload/' . 'advert_' . $sourceAdvertId;
	    mkdir($uploadFileDir);


	    foreach ($details as $detail)
	    {
		$advertDetail = $detail['vw_get_advert_details']['detail'];
		$advertDetail = Sanitize::clean($advertDetail, array('encode' => false));
		$detailClassId = $detail['vw_get_advert_details']['detail_class_id'];


		if ($detailClassId == 11)
		{
		    $a = $this->parseProperties($advertDetail);
		    $fileName = $a['name'];
		    if (!copy($copyFileDir . '/' . $fileName, $uploadFileDir . '/' . $fileName))
		    {
			echo "resim kopyalanamadı";
		    }
		    if (!copy($copyFileDir . '/thumb_' . $fileName, $uploadFileDir . '/thumb_' . $fileName))
		    {
			echo "thumb kopyalanamadı";
		    }
		    if (!copy($copyFileDir . '/gallery_thumb_' . $fileName, $uploadFileDir . '/gallery_thumb_' . $fileName))
		    {
			echo "gallery thumb kopyalanamadı";
		    }
		    
		    if (!copy($copyFileDir . '/original_' . $fileName, $uploadFileDir . '/original_' . $fileName))
		    {
			echo "orijinal kopyalanamadı";
		    }
		    
		}
		$this->Advertisement->query('CALL prt_advert_detail_add(' . $userId . ',' . $advertId . ',' . $detailClassId . ',"' . $advertDetail . '")');
	    }

	    $this->Advertisement->query('CALL prt_advert_detail_add(' . $userId . ',' . $advertId . ',88,"' . $sourceAdvertId . '")');

	    $status = 'passive';
	    $this->Advertisement->query('CALL prt_advert_confirm(' . $userId . ',' . $advertId . ',"' . $status . '")');
	}
	$this->Advertisement->query('CALL prt_advert_detail_add(' . $userId . ',' . $sourceAdvertId . ',88,"' . $sourceAdvertId . '")');
    }

    public function applyWatermarks()
    {
	Configure::write('debug', 2);

	$uploadFolder = $_SERVER['DOCUMENT_ROOT'] . '/app/webroot/upload';
	$advertUploadFolders = scandir($uploadFolder);

	$imageTypes = array('jpg',
	    'JPG',
	    'Jpeg',
	    'png',
	    'gif',
	    'jpeg',
	    'PNG');



	foreach ($advertUploadFolders as $advertUploadFolder)
	{
	    $advertUploadFolderPath = $uploadFolder . '/' . $advertUploadFolder;

	    if (!file_exists($advertUploadFolderPath . '/complete3.txt'))
	    {
		pr($advertUploadFolderPath);
		if ($advertUploadFolder != '.' && $advertUploadFolder != '..')
		{
		    $a = explode('_', $advertUploadFolder);
		    if (isset($a[1]) && $a[1] > 0)
		    {


			$imageFiles = scandir($advertUploadFolderPath);
			foreach ($imageFiles as $imageFile)
			{
			    if ($imageFile != '.' && $imageFile != '..' && in_array(pathinfo($advertUploadFolderPath . '/' . $imageFile, PATHINFO_EXTENSION), $imageTypes))
			    {
				if (strpos($imageFile, 'original_') !== 0)
				{
				    unlink($advertUploadFolderPath . '/' . $imageFile);
				}
			    }
			}


			$imageFiles = scandir($advertUploadFolderPath);
			foreach ($imageFiles as $imageFile)
			{
			    if ($imageFile != '.' && $imageFile != '..' && in_array(pathinfo($advertUploadFolderPath . '/' . $imageFile, PATHINFO_EXTENSION), $imageTypes))
			    {

				$originalImageFile = $imageFile;
				$originalImagePath = $advertUploadFolderPath . '/' . $originalImageFile;

				$this->Image->createAdvertImageSet($originalImagePath, true);
			    }
			}

			$ourFileHandle = fopen($advertUploadFolderPath . '/complete3.txt', 'w') or die("can't open file");
			fclose($ourFileHandle);
		    }
		}
	    }
	}
    }

    public function formElements()
    {
	$this->loadModel('User');
	$formElements = $this->User->query('select * from lu_details_class');
	$this->set(compact('formElements'));
    }

    public function formElementEdit($id)
    {
	$this->loadModel('User');
	if ($this->request->isPost())
	{
	    $this->User->query('UPDATE lu_details_class SET properties ="' . $this->request->data['FormElement']['properties'] . '" WHERE detail_class_id=' . $id);
	}


	$formElement = $this->User->query('select * from lu_details_class where detail_class_id=' . $id);
	$this->set(compact('formElement'));
    }

}