<?php

class TxUser extends AppModel {

    public $name = 'TxUser';
    public $useTable = 'tx_users_groups_sellects';
    public $primaryKey = 'user_group_sellect_id';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_group_id',
            'type' => 'inner'
        )
    );
    public $hasMany = array(
        'UserGroupDetail' => array(
            'className' => 'UserGroupDetail',
            'foreignKey' => 'user_group_sellect_id',
            'type' => 'inner'
        )
    );

    public function userData($userId) {
        $this->recursive = 0;
        $result = $this->findByUserGroupSellectId($userId);

        $return = array();
        $result['User']['userSId'] = $userId;
        $result['User']['otherPhone'] = unserialize($result['User']['phone']);
        $return['User'] = array_merge($result['User'], $this->UserGroupDetail->userDetails($userId));
        if (isset($return['User']['ldc_user_phone']))
            $return['User']['ldc_user_phone'] = $this->propertiesToArray($return['User']['ldc_user_phone']);
        if (isset($return['User']['ldc_user_bank']))
            $bank = $this->propertiesToArray($return['User']['ldc_user_bank']);

        $return['User']['email'] = $return['User']['ldc_primary_email'];
        if (isset($return['User']['ldc_user_phone']['code']))
            $return['User']['phoneCountryCode'] = $return['User']['ldc_user_phone']['code'];
        if (isset($return['User']['ldc_user_phone']['number']))
            $return['User']['phoneNumber'] = $return['User']['ldc_user_phone']['number'];
        if (isset($return['User']['ldc_user_tc_no']))
            $return['User']['tcId'] = $return['User']['ldc_user_tc_no'];
        $return['User']['dateOfBirth']['year'] = date('Y', strtotime($return['User']['birth_date']));
        $return['User']['dateOfBirth']['month'] = date('m', strtotime($return['User']['birth_date']));
        $return['User']['dateOfBirth']['day'] = date('d', strtotime($return['User']['birth_date']));



        if (isset($return['User']['ldc_invoice_title']))
            $return['User']['taxTitle'] = $return['User']['ldc_invoice_title'];
        if (isset($return['User']['ldc_invoice_tax_office']))
            $return['User']['taxOffice'] = $return['User']['ldc_invoice_tax_office'];
        if (isset($return['User']['ldc_invoice_tax_id']))
            $return['User']['taxNo'] = $return['User']['ldc_invoice_tax_id'];
        if (isset($return['User']['ldc_invoice_address']))
            $return['User']['taxAddress'] = $return['User']['ldc_invoice_address'];
        if (isset($return['User']['ldc_invoice_taxpayer']))
            $return['User']['taxUserType'] = $return['User']['ldc_invoice_taxpayer'];


        if (isset($bank['cityId']))
            $return['User']['bankCity'] = $bank['cityId'];
        if (isset($bank['bankId']))
            $return['User']['bankName'] = $bank['bankId'];
        if (isset($bank['title']))
            $return['User']['bankPayeeTitle'] = $bank['title'];
        if (isset($bank['branchName']))
            $return['User']['bankOfficeName'] = $bank['branchName'];
        if (isset($bank['branchCode']))
            $return['User']['bankOfficeCode'] = $bank['branchCode'];
        if (isset($bank['accountNo']))
            $return['User']['bankAccountNo'] = $bank['accountNo'];
        if (isset($bank['Iban']))
            $return['User']['bankAccountIBAN'] = $bank['Iban'];

        return $return;
    }

    public function updateUser($data) {
        $result = array();
        $result['success'] = 0;
        if (isset($data['User']['userId']))
            $userId = $data['User']['userId'];
        else
            $userId = CakeSession::read('User.Id');

        $this->recursive = 0;
        $conditions = array();
        $conditions['conditions']['TxUser.user_group_sellect_id'] = $userId;
        $conditions['conditions']['User.pass'] = $data['User']['currentPass'];
        $isPassTrue = $this->find('count', $conditions);
        if ($isPassTrue) {
            switch ($data['Form']['type']) {
                case 'user' :
                    $params = array();
                    $params['TxUser.user_group_sellect_id'] = $userId;
                    $fields = array();
                    $fields['User.name'] = '"' . $data['User']['name'] . '"';
                    $fields['User.sname'] = '"' . $data['User']['sname'] . '"';
                    $fields['User.gender_id'] = $data['User']['gender_id'];
                    if (isset($data['User']['otherPhone']))
                        $fields['User.phone'] = serialize($data['User']['otherPhone']);
                    $fields['User.birth_date'] = '"' . $data['User']['dateOfBirth']['year'] . '-' . $data['User']['dateOfBirth']['month'] . '-' . $data['User']['dateOfBirth']['day'] . '"';
                    $this->updateAll($fields, $params);
                    $this->addUserDetail($userId, 'ldc_user_phone', 'code=>' . $data['User']['phoneCountryCode'] . '[|]number=>' . $data['User']['phoneNumber']);
                    $this->addUserDetail($userId, 'ldc_primary_email', $data['User']['email']);
                    $this->addUserDetail($userId, 'ldc_user_tc_no', $data['User']['tcId']);
                    $result['success'] = 1;
                    break;
                case 'bank_account' :
                    $detail = 'id=>1[|]cityId=>' . $data['User']['bankCity'] . '[|]bankId=>' . $data['User']['bankName'] . '[|]title=>' . $data['User']['bankPayeeTitle'] . '[|]branchName=>' . $data['User']['bankOfficeName'] . '[|]branchCode=>' . $data['User']['bankOfficeCode'] . '[|]accountNo=>' . $data['User']['bankAccountNo'] . '[|]Iban=>' . $data['User']['bankAccountIBAN'];
                    $this->addUserDetail($userId, 'ldc_user_bank', $detail);
                    $result['success'] = 1;
                    break;
                case 'invoice' :
                    $this->addUserDetail($userId, 'ldc_invoice_title', $data['User']['taxTitle']);
                    $this->addUserDetail($userId, 'ldc_invoice_tax_office', $data['User']['taxOffice']);
                    $this->addUserDetail($userId, 'ldc_invoice_tax_id', $data['User']['taxNo']);
                    $this->addUserDetail($userId, 'ldc_invoice_address', $data['User']['taxAddress']);
                    $this->addUserDetail($userId, 'ldc_invoice_taxpayer', $data['User']['taxUserType']);
                    $result['success'] = 1;
                    break;
                case 'password' :
                    if ($data['User']['passwordCheck'] != $data['User']['passwordNew']) {
                        $result['success'] = 0;
                        $result['message_text_id'] = 'lsm_password_not_match';
                    } else {
                        if (strlen($data['User']['passwordNew']) > 5) {
                            $params = array();
                            $params['TxUser.user_group_sellect_id'] = $userId;
                            $fields = array();
                            $fields['User.pass'] = '"' . $data['User']['passwordNew'] . '"';
                            $this->updateAll($fields, $params);
                            $result['success'] = 1;
                        } else {
                            $result['message_text_id'] = 'lsm_password_too_small';
                            $result['success'] = 0;
                        }
                    }
                    break;
            }
        } else {
            $result['success'] = 0;
            $result['message_text_id'] = 'lsm_wrong_password';
        }
        return $result;
    }

    public function addUserDetail($userId, $messageTextId, $detail) {
        $addUser = CakeSession::read('User.Id');
        $this->query('call prt_user_detail_update_add(' . $addUser . ',' . $userId . ',"' . $messageTextId . '","' . $detail . '")');
    }

}