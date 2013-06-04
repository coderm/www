<div class="row">
<h4 class="headline shadow clear">Yeni Üyelik</h4>
</div>
<div class="row">
    <div class="span7">
	<div class="well">
	    <h4>Neden Tatil Evim</h4>
	    <p>
		Lorem ipsum dolor sit amet...
		<ul>
		    <li>lorem ipsum</li>
		    <li>lorem ipsum</li>
		    <li>lorem ipsum</li>
		    <li>lorem ipsum</li>
		    <li>lorem ipsum</li>
		</ul>
	    </p>
	</div>
    </div>
    <div class="span5">
	<div class="well lightblue">
	    <h4>Yeni Üyelik <i class="icon-user pull-right alpha60"></i></h4>

	    <?php 
		echo $this->BSForm->create();
		echo '<div class="row">';
		echo $this->element('/user/form/register');
		echo '</div>';
		echo $this->BSForm->end(array('label'=>'Kaydol','class'=>'btn btn-block btn-large btn-success'));
		
	    ?>

	</div>
    </div>

</div>
