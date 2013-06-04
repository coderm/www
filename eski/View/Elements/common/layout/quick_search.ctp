<?php
    echo $this->Form->create('Search',array('id'=>'SearchIndexForm','action'=>'index'));
    echo $this->Form->hidden('searchType',array('value'=>'quick'));
    echo $this->Form->input('query',array('placeholder'=> __('form_input_place_holder_common_quick_search'),'label'=>false,'div'=>false));
    echo $this->Form->submit(__('btn_label_common_quick_search'),array('div'=>false,'class'=>'btn'));
    echo $this->Form->end();
?>
