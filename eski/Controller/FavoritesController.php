<?php
App::uses('Sanitize', 'Utility');
class FavoritesController extends AppController
{

    public $name = 'Favorites';
    public $components = array('Cookie');

    public function index()
    {
	$favoryAdverts = $this->getFavorites(TRUE);

        if (count($favoryAdverts) == 0)
            $this->redirect(array('controller' => 'searches', 'action' => 'index', 'lac-all'));
        $favoryAdverts = $this->parseAdvertListResults($favoryAdverts);
	
        $this->set(compact('favoryAdverts'));
    }

    public function add($advertId)
    {
	$results = $this->getFavorites();
	$favoriteList = array();
	if (is_array($results))
	    $favoriteList = $results;
	if (in_array($advertId, $favoriteList))
	    $result = $favoriteList;
	else
	    $result = $this->Favorite->addFavorite($advertId, $favoriteList);

	$this->Cookie->write('favoriteList', $result, false, '30 DAY');
        $this->Session->setFlash('İlan favorilerinize eklendi');
        $this->redirect($this->referer());
    }

    public function check($advertId)
    {
	return in_array($advertId, $this->getFavorites());
    }

    private function getFavorites($details = false)
    {
	$userId = CakeSession::read('User.Id');
	if ($userId == 6)
	    $favoriteList = $this->arrayCookie();
	else
	    $favoriteList = $this->Favorite->listFavorite();

	if ($details)
	    return $this->Favorite->favoriteDetails($favoriteList);
	else
            return $favoriteList;
    }

    public function delete($advertId)
    {
	$favoriteList = $this->arrayCookie();
        $key = array_search($advertId, $favoriteList);
	unset($favoriteList[$key]);
	$favoriteList = array_values($favoriteList);
        $this->Cookie->write('favoriteList', $favoriteList, false, '30 DAY');
	$this->Favorite->deleteFavorite($advertId);
	$this->Session->setFlash($advertId . ' nolu ilan favori listenizden çıkartıldı.');
	$this->redirect($this->referer());
    }
    
 public function arrayCookie()
    {
     $favoriteList = $this->Cookie->read('favoriteList');
        if (is_array($favoriteList))
            $result = $favoriteList;
        else {
            $result = str_replace(array('\\', '[', ']', '"'), '', $favoriteList);
            $result = explode(',', $result);
        }
       
        $result = array_values($result);

        return $result;
    }
   
    

}