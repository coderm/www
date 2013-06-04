<?php

class User extends AppModel {

    public $name = 'User';
    public $useTable = 'dt_users';
    public $primaryKey = 'user_id';
    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'not_empty'
        ),
        'sname' => array(
            'rule' => 'notEmpty',
            'message' => 'not_empty'
        ),
        'email' => array(
            'rule' => array('email', true),
            'message' => 'not_correct_email_format'
        ),
        'phoneNumber' => array(
            'rule' => 'notEmpty',
            'message' => 'not_empty'
        ),
        'phoneCountryCode' => array(
            'rule' => 'notEmpty',
            'message' => 'not_empty'
        ),
        'passwordNew' => array(
            'rule' => array('minLength', 6),
            'message' => 'min_length_%d'
        ),
        'passwordCheck' => array(
            'rule' => array('identicalFieldValues', 'passwordNew'),
            'message' => 'must_equal_password'
        ),
        'check' => array(
            'rule' => array('equalTo', '1'),
            'message' => 'must_checked'
        )
    );
    public $quickLogin = array(
        'uname' => array(
            'rule' => 'notEmpty',
            'message' => 'not_empty'
        ),
        'password' => array(
            'rule' => 'notEmpty',
            'message' => 'not_empty'
        )
    );

    public function getUser($userId) {
        return $this->findByUserSId($userId);
    }

    public function userGroups() {
        $userId = CakeSession::read('User.Id');
        $results = $this->query('select group_s_id, message_text_id, description from vw_users_groups where enable = true and user_s_id = ' . $userId);

        $r = array();
        foreach ($results as $result)
            $r[] = trim($result['vw_users_groups']['message_text_id']);

        return $r;
    }

    public function commentMailList() {
        $mailCount = 2;
        $endTime = 10;
        $hour = date("H");
        $count = $this->query('SELECT count(*)
              FROM dt_booking db
                   JOIN dt_adverts da
                      ON     db.advert_id = da.advert_id
                         AND da.status = "active"
                         AND db.status = "active"
                         AND db.comment_mail <> 1
                         AND db.end_date < ADDDATE(NOW(), INTERVAL -2 DAY)
                   JOIN dt_advert_details dad
                      ON     da.advert_id = dad.advert_id
                         AND dad.detail_class_id = 66
                         AND db.lessor_user_s_id <> dad.advert_detail
                   JOIN tx_users_groups_sellects tug
                      ON db.renter_user_s_id = tug.user_group_sellect_id
                   JOIN dt_users
                      ON tug.user_group_id = dt_users.user_id
                   JOIN dt_user_group_details dud
                      ON     dud.user_group_sellect_id = db.renter_user_s_id
                         AND dud.detail_class_id = 1 AND dud.user_group_detail NOT LIKE "%tatilevim.com%"
                   JOIN dt_user_group_details dud2
                      ON     dud2.user_group_sellect_id = db.renter_user_s_id
                         AND dud2.detail_class_id = 159');
        $count = $count['0']['0']['count(*)'];
        if ($count - (($endTime - $hour) * $mailCount * 4) > 0 && $count > 0 && $hour > 4 && $hour < 20) {
            return $this->query('SELECT db.booking_id,
                   db.advert_id,
                   db.start_date,
                   db.end_date,
                   dt_users.name,
                   dt_users.sname,
                   db.renter_user_s_id,
                   dud.user_group_detail renter_email,
                   dud2.user_group_detail login_key
              FROM dt_booking db
                   JOIN dt_adverts da
                      ON     db.advert_id = da.advert_id
                         AND da.status = "active"
                         AND db.status = "active"
                         AND db.comment_mail <> 1
                         AND db.end_date < ADDDATE(NOW(), INTERVAL -2 DAY)
                   JOIN dt_advert_details dad
                      ON     da.advert_id = dad.advert_id
                         AND dad.detail_class_id = 66
                         AND db.lessor_user_s_id <> dad.advert_detail
                   JOIN tx_users_groups_sellects tug
                      ON db.renter_user_s_id = tug.user_group_sellect_id
                   JOIN dt_users
                      ON tug.user_group_id = dt_users.user_id
                   JOIN dt_user_group_details dud
                      ON     dud.user_group_sellect_id = db.renter_user_s_id
                         AND dud.detail_class_id = 1 AND dud.user_group_detail NOT LIKE "%tatilevim.com%"
                   JOIN dt_user_group_details dud2
                      ON     dud2.user_group_sellect_id = db.renter_user_s_id
                         AND dud2.detail_class_id = 159
             LIMIT ' . $mailCount);
        } else {
            return FALSE;
        }
    }

    public function commentMailSent($bookingId) {
        return $this->query('update dt_booking SET comment_mail = 1 WHERE booking_id ="' . $bookingId . '"');
    }

    public function loginKeyLogin($loginKey, $userId) {
        $count = $this->query('select count(*) from dt_user_group_details where detail_class_id = 159 and user_group_sellect_id = ' . $userId . ' and user_group_detail = "' . $loginKey . '"');
        $count = $count['0']['0']['count(*)'];
        if ($count > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function UserRateAdvert($advertId) {
        $userId = CakeSession::read('User.Id');
        $bookCount = $this->query('select count(*) from dt_booking where end_date < NOW()and status = "active" and renter_user_s_id = ' . $userId . ' and advert_id = ' . $advertId);
        $rateCount = $this->query('select count(*) from dt_comments where scored = 1 and status IN ("active","passive") and user_s_id = ' . $userId . ' and advert_id = ' . $advertId);
        return $bookCount['0']['0']['count(*)'] - $rateCount['0']['0']['count(*)'];
    }

    public function getUserDetail($userId) {
        $userDetails = $this->query('select
                      dsd.user_group_sellect_id as user_s_id
                     ,ldc.message_text_id
                     ,dsd.user_group_detail as user_detail
                     from
                        dt_user_group_details dsd
                     JOIN
                        lu_details_class ldc
                     ON ldc.detail_class_id = dsd.detail_class_id
                        where dsd.user_group_sellect_id =' . $userId);
        $banks = array();
        foreach ($userDetails as $userDetail) {
            $messageTextId = $userDetail['ldc']['message_text_id'];
            if ($messageTextId == 'ldc_user_bank') {
                $details = $this->parseProperties($userDetail['dsd']['user_detail']);
                $id = $details['id'];
                $banks[$id] = $details;
            }
        }
        $userDetails['userBanks'] = $banks;
        return $userDetails;
    }

    public function getBankList() {
        return $this->query('select banking_id, message_text_id from lu_banking');
    }

    public function taxFormInputsDetailDBTextIdTransections() {
        $tx = array();
        $tx['taxTitle'] = 'ldc_invoice_title';
        $tx['taxOffice'] = 'ldc_invoice_tax_office';
        $tx['taxNo'] = 'ldc_invoice_tax_id';
        $tx['taxTCNo'] = 'ldc_user_tc_no';
        $tx['taxAddress'] = 'ldc_invoice_address';
        $tx['taxUserType'] = 'ldc_invoice_taxpayer';
        return $tx;
    }

    public function bankFormInputsDBTextIdTransections() {
        $tx = array();
        $tx['bankCity'] = 'cityId';
        $tx['bankName'] = 'bankId';

        $tx['bankPayeeTitle'] = 'title';
        $tx['bankOfficeName'] = 'branchName';
        $tx['bankOfficeCode'] = 'branchCode';
        $tx['bankAccountNo'] = 'accountNo';
        $tx['bankAccountIBAN'] = 'Iban';

        return $tx;
    }

    public function getUserByMail($email) {
        return $this->findByPrimaryEmail($email);
    }

    public function getHouseHolder($id) {
        $results = $this->query('SELECT * FROM vw_users_list_ajax WHERE user_s_id=' . $id);
        $result = $results[0];
        return array('userId' => $result['vw_users_list_ajax']['user_s_id'], 'userDetails' => $this->parseProperties($result['vw_users_list_ajax']['user_detail']));
    }

    public function createSecurityCodeForNewPasswordRequest($userSId) {
        $deleteOlderCodesQuery = 'DELETE FROM dt_user_group_details where user_group_sellect_id =' . $userSId . ' AND detail_class_id=\'123\'';
        $this->query($deleteOlderCodesQuery);
        $securityCodeForUser = md5(uniqid());
        $securityCodeForUserSQL = 'INSERT INTO dt_user_group_details(user_group_sellect_id,detail_class_id,user_group_detail) VALUES (' . $userSId . ',123,\'' . $securityCodeForUser . '\');';
        $this->query($securityCodeForUserSQL);

        return $securityCodeForUser;
    }

    public function updateUserPassViaSecurityCodeForNewPassword($userMail, $securityCodeForUser, $newPassword) {
        $sqlQuery = 'call prt_pasword_confirm(\'' . $userMail . '\', \'' . $securityCodeForUser . '\', \'' . $newPassword . '\')';
        $results = $this->query($sqlQuery);
        return $results[0]['lsm']['message_text_id'];
    }

    public $validateForProfile = array(
        'uname' => array(
            'rule' => 'notEmpty',
            'message' => 'Bu alan boş bırakılamaz'
        ),
        'email1' => array(
            'rule1' => array(
                'rule' => 'notEmpty',
                'message' => 'Bu alan boş bırakılamaz',
            ),
            'rule2' => array(
                'rule' => array('email', true),
                'message' => 'Mail adresi geçersiz'
            )
        ),
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Bu alan boş bırakılamaz'
        ),
        'sname' => array(
            'rule' => 'notEmpty',
            'message' => 'Bu alan boş bırakılamaz'
        ),
        'passwordConfirm' => array(
            'rule' => 'notEmpty',
            'message' => 'Bilgilerinizin güvenliği için mevcut şifrenizi girmeniz gereklidir'
        ),
        'phoneNumber' => array(
            'rule1' => array(
                'rule' => '/[-\( \/]*(0{1})?[-\)\( \/]*([\d]{3})[-\) \/]*([0-9]{1})([\d]{2})[- \/]*([\d]{2})[- \/]*([\d]{2})+$/',
                'message' => 'Telefon numarasını kontrol edin'
            )
        )
        ,
        'gender' => array(
            'rule' => array('comparison', '!=', 0),
            'message' => 'Bu alan boş bırakılamaz'
        )
        ,
        'acceptAgreement' => array(
            'rule1' => array(
                'rule' => 'notEmpty',
                'message' => 'Bu alan boş bırakılamaz',
            ),
            'rule2' => array(
                'rule' => array('comparison', '!=', 0),
                'message' => 'Kayıt olabilmek için kullanıcı sözleşmesini onaylamanız gerekmektedir.'
            )
        )
        ,
        'acceptRentalAgreement' => array(
            'rule1' => array(
                'rule' => 'notEmpty',
                'message' => 'Bu alan boş bırakılamaz',
            ),
            'rule2' => array(
                'rule' => array('comparison', '!=', 0),
                'message' => 'Kayıt olabilmek için kiralama sözleşmesini onaylamanız gerekmektedir.'
            )
        )
    );

    function identicalFieldValues($field = array(), $compare_field = null) {
        foreach ($field as $key => $value) {
            $v1 = $value;
            $v2 = $this->data[$this->name][$compare_field];
            if ($v1 !== $v2) {
                return FALSE;
            } else {
                continue;
            }
        }
        return TRUE;
    }

}

?>
