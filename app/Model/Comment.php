<?php

class Comment extends AppModel {

    public $name = 'Comment';
    public $useTable = 'dt_comments';
    public $primaryKey = 'comment_id';
    public $belongsTo = array(
        'CommentedUser' => array(
            'className' => 'TxUser',
            'foreignKey' => 'user_s_id'
        ),
        'ComfirmedUser' => array(
            'className' => 'TxUser',
            'foreignKey' => 'confirming_s_id'
        )
    );

    public function getComment($advertId = 0, $page = 1, $count = 5) {
        $this->recursive = -1;
        $params['conditions']['status'] = 'active';
        $params['fields'] = array('user_s_id', 'comment', 'check_in_out', 'cleaning', 'comfort', 'value_for_money', 'add_date');
        $params['limit'] = $count;
        $params['order'] = 'add_date desc';
        $results = $this->find('all', $params);
        foreach ($results as $key => $value) {
            $results[$key]['CommentedUser'] = $this->CommentedUser->userData($value['Comment']['user_s_id']);
        }
        return $results;
        /*
          $start = ($page - 1) * $count;
          $userId = CakeSession::read('User.Id');
          $viewPassiveComment = $this->query('call prt_permission(' . $userId . ',"lp_user_view_passive_comment")');
          $result = array();
          if ($viewPassiveComment['0'] ['0']['permit'] == 1) {
          if ($advertId == 0) {

          $result = Cache::read('comment_admin_result_' . $advertId . '_' . $page . '_' . $count, 'monthly');
          if (!$result) {
          $result = $this->find('all', array('limit' => $start . ',' . $count, 'conditions' => array('Comment.status' => array('passive'))));
          $result['cached'] = 'true';
          Cache::write('comment_admin_result_' . $advertId . '_' . $page . '_' . $count, $result, 'monthly');
          }


          $resultcount = $this->find('count', array('recursive' => -1, 'conditions' => array('Comment.status' => array('passive'))));
          } else {

          $result = Cache::read('comment_admin_result_' . $advertId . '_' . $page . '_' . $count, 'monthly');
          if (!$result) {
          $result = $this->find('all', array('order' => 'Comment.add_date desc', 'limit' => $start . ',' . $count, 'conditions' => array('Comment.status' => array('active', 'passive'), 'Comment.advert_id' => array($advertId))));
          $result['cached'] = 'true';
          Cache::write('comment_admin_result_' . $advertId . '_' . $page . '_' . $count, $result, 'monthly');
          }


          $resultcount = $this->find('count', array('recursive' => -1, 'conditions' => array('Comment.status' => array('active', 'passive'), 'Comment.advert_id' => array($advertId))));
          }
          } else {

          $result = Cache::read('comment_result_' . $advertId . '_' . $page . '_' . $count, 'monthly');
          if (!$result) {
          $result = $this->find('all', array('order' => 'Comment.add_date desc', 'limit' => $start . ',' . $count, 'conditions' => array('Comment.status' => array('active'), 'Comment.advert_id' => array($advertId))));
          $result['cached'] = 'true';
          Cache::write('comment_result_' . $advertId . '_' . $page . '_' . $count, $result, 'monthly');
          }
          $resultcount = $this->find('count', array('recursive' => -1, 'conditions' => array('Comment.status' => array('active'), 'Comment.advert_id' => array($advertId))));
          }

          $score = Cache::read('comment_score_' . $advertId, 'monthly');
          if (!$score) {
          $score = $this->find('all', array('fields' => array('AVG(Comment.check_in_out) as check_in_out', 'AVG(Comment.cleaning) as cleaning', 'AVG(Comment.comfort) as comfort', 'AVG(Comment.value_for_money) as value_for_money', 'AVG(Comment.check_in_out + Comment.cleaning + Comment.comfort + Comment.value_for_money) / 4  as average'), 'conditions' => array('Comment.status' => array('active'), 'Comment.scored' => array(1), 'Comment.advert_id' => array($advertId))));
          Cache::write('comment_score_' . $advertId, $score, 'monthly');
          }
          $result['cached'] = '';
          $result['score'] = $score;
          $result['count'] = $resultcount;
          return $result;
         */
    }

    public function addComment($advertId, $comment, $checkInOut = 0, $cleaning = 0, $comfort = 0, $valueForMoney = 0) {

        $userId = CakeSession::read('User.Id');
        if ($userId != 6) {

            $this->create();
            if ($checkInOut + $cleaning + $comfort + $valueForMoney > 0) {
                $this->query('update dt_user_group_details SET user_group_detail = (SELECT ROUND(RAND() * 89999999, 0) + 10000000)  WHERE detail_class_id = 159 AND user_group_sellect_id =' . $userId);
                $data ['scored'] = 1;
            } else {
                $data ['scored'] = 0;
            }
            $data ['advert_id'] = $advertId;
            $data ['user_s_id'] = $userId;
            $data ['comment'] = $comment;
            $data ['check_in_out'] = $checkInOut;
            $data ['cleaning'] = $cleaning;
            $data ['comfort'] = $comfort;
            $data ['value_for_money'] = $valueForMoney;
            $data ['add_date'] = date('Y-m-d H:i:s', time());
            $this->save($data);
            $lsm [0]['lsm']['type'] = 'success';
            $lsm [0]['lsm']['message_text_id'] = 'lsm_comment_added';
        } else {
            $lsm [0]['lsm']['type'] = 'error';
            $lsm [0]['lsm']['message_text_id'] = 'lsm_user_not_login';
        }
        $this->pagecachedelete('comment_admin_result_' . $advertId, 'monthly');
        $this->pagecachedelete('comment_admin_result_0', 'monthly');

        return $lsm;
    }

    public function comfirmComment($commentId, $status) {
        $userId = CakeSession::read('User.Id');
        $viewPassiveComment = $this->query('call prt_permission(' . $userId . ',"lp_user_comfirm_comment")');
        if ($viewPassiveComment['0'] ['0']['permit'] == 1) {
            $data ['comment_id'] = $commentId;
            $data ['confirming_s_id'] = $userId;
            $data ['confirm_date'] = date('Y-m-d H:i:s', time());
            $data ['status'] = $status;
            $this->save($data);
            $lsm [0]['lsm']['type'] = 'success';
            if ($status == 'deleted') {
                $lsm [0]['lsm']['message_text_id'] = 'lsm_comment_deleted';
            } else {
                $lsm [0]['lsm']['message_text_id'] = 'lsm_comment_comfirmed';
            }
            $lsm [0]['lsm']['message_text_id'] = 'lsm_comment_comfirmed';
        } else {
            $lsm [0]['lsm']['type'] = 'error';
            $lsm [0]['lsm']['message_text_id'] = 'lsm_you_have_not_permission';
        }
        $advertId = $this->findByCommentId($commentId);
        $advertId = $advertId['Comment']['advert_id'];
        $this->pagecachedelete('comment_admin_result_' . $advertId, 'monthly');
        $this->pagecachedelete('comment_result_' . $advertId, 'monthly');
        $this->pagecachedelete('comment_admin_result_0', 'monthly');
        $this->deleteCache('comment_score_' . $advertId, 'monthly');
    }

    private function pagecachedelete($key, $config) {
        for ($page = 1; $page < 11; $page++) {
            for ($count = 3; $count < 11; $count++) {
                $this->deleteCache($key . '_' . $page . '_' . $count, $config);
            }
        }
    }

    public function getTotalWaitingForAprovals() {
        $result = $this->query('select count(*) from dt_comments where status IN ("passive")');
        return $result['0']['0']['count(*)'];
    }

}

