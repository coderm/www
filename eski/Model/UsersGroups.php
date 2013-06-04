<?php
class UsersGroups extends AppModel
{
    public $name = 'UsersGroups';
    public $useTable = 'vw_users_groups';
    public $primaryKey = 'user_s_id';
    public $hasMany= array(
        'UsersGroup' => array(
            'className' => 'UsersGroups',
            'foreignKey' => 'group_s_id'
        )
    );
    
}
?>
