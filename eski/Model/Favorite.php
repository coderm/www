<?php

class Favorite extends AppModel {

    public $name = 'Favorite';
    public $useTable = 'dt_favorites';
    public $primaryKey = 'favorite_id';
    public $belongsTo = array(
        'Advertisement' => array(
            'className' => 'Advertisement',
            'foreignKey' => 'advert_id'
            ));

    public function addFavorite($advertId, $favoriteList) {
        if (ereg('[0-9]', $advertId)) {
            $userId = CakeSession::read('User.Id');
            $userAgent = CakeSession::read('Config.userAgent');
            $data ['created'] = date('Y-m-d H:i:s');
            $data ['user_s_id'] = $userId;
            $data ['user_agent'] = $userAgent;
            $data ['advert_id'] = $advertId;
            $this->create();
            $this->save($data);
            $favoriteList[] = $advertId;
        }
        return $favoriteList;
    }

    public function listFavorite() {
        $userId = CakeSession::read('User.Id');
        $this->recursive = -1;
        $results = $this->find('all', array('conditions' => array('Favorite.user_s_id' => $userId)));
        $favoriteList = array();
        foreach ($results as $result) {
            $favoriteList[] = $result['Favorite']['advert_id'];
        }
        return $favoriteList;
    }

    public function totalFavorite($adverts) {
        $userId = CakeSession::read('User.Id');

        $favoriteList = '';
        foreach ($adverts as $advert) {
            if (ereg('[0-9]', $advert))
                $favoriteList .= $advert . ',';
        }
        $favoriteList .= '999';
        if ($userId == 6)
            $result = $this->query('select count(*) total from dt_adverts where status IN ("active") and visibility = "show" and advert_id IN(' . $favoriteList . ')');
        else
            $result = $this->query('select count(*) total from dt_adverts where status IN ("active") and advert_id IN(' . $favoriteList . ')');
        $result = $result ['0']['0']['total'];
        return $result;
    }

    public function favoriteDetails($adverts) {
        $favoriteList = array();
        foreach ($adverts as $advert) {
            if (ereg('[0-9]', $advert))
                $favoriteList [] = $advert;
        }
        $data['conditions']['Advertisement.advert_id'] = $favoriteList;
        $data['conditions']['Advertisement.visibility'] = 'show';
        $data['conditions']['Advertisement.status'] = 'active';
        return $this->Advertisement->advertList($data, FALSE);
    }

    public function deleteFavorite($advertId) {
        $userId = CakeSession::read('User.Id');
        $userAgent = CakeSession::read('Config.userAgent');
        if ($userId == 6) {
            $this->deleteAll(array('Favorite.user_s_id' => $userId, 'Favorite.user_agent' => $userAgent, 'Favorite.advert_id' => $advertId), false);
        } else {
            $this->deleteAll(array('Favorite.user_s_id' => $userId, 'Favorite.advert_id' => $advertId), false);
        }
    }

}