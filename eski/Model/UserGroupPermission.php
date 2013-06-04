<?php
class UserGroupPermission extends AppModel {

    public $name = 'UserGroupPermission';
    public $useTable = 'tx_permissons_ug';
    public $primaryKey = 'permissions_ug';
     public $belongsTo= array(
        'UserGroup' => array(
            'className' => 'UsersGroups',
            'foreignKey' => 'user_group_sellect_id'
        ),
           'Permission' => array(
            'className' => 'Permission',
            'foreignKey' => 'permission_id'
        )
    );
}