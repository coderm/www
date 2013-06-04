<div class="row">
<h4 class="headline">Kullanıcı Detayı</h4>
</div>
<table class="table">
    <tr>
        <td>Id</td>
        <td><?php echo $user['user_s_id'];?></td>
    </tr>    
    <tr>
        <td>Kullanıcı Adı</td>
        <td><?php echo $user['uname'];?></td>
    </tr>
    <tr>
        <td>Cinsiyet</td>
        <td><?php echo __($user['gender']);?></td>
    </tr>     
    <tr>
        <td>Ad</td>
        <td><?php echo $user['name'];?></td>
    </tr>
    <tr>
        <td>Soyad</td>
        <td><?php echo $user['sname'];?></td>
    </tr>
    <tr>
        <td>Doğum Tarihi</td>
        <td><?php echo $user['birth_date'];?></td>
    </tr>         
    <tr>
        <td>e-posta</td>
        <td><?php echo $user['primary_email'];?></td>
    </tr>    
    <tr>
        <td>Telefon</td>
        <td><?php echo $user['phoneCode'].' '.$user['phoneNumber'];?></td>
    </tr>      
</table>
<?php echo $this->Html->link('Başka bir kullanıcı ara',array('controller'=>'users','action'=>'index'),array('class'=>'btn btn-success pull-right'));?>
