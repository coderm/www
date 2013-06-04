<?php

	echo $this->BSForm->hidden('Form.type',array('value'=>'invoice'));
	echo $this->BSForm->input('taxTitle',array('label'=>__('user_invoice_company_title_input_label'),'bsSpan'=>6));
	echo $this->BSForm->newRow();
        echo $this->BSForm->input('taxOffice',array('label'=>__('user_invoice_tax_id_input_label'),'bsSpan'=>3));
        echo $this->BSForm->input('taxNo',array('label'=>__('user_invoice_tc_id_&_tax_id_input_label'),'bsSpan'=>3));
	echo $this->BSForm->newRow();
        echo $this->BSForm->input('taxAddress',array('label'=>__('user_invoice_address_input_label'),'type'=>'textArea','bsSpan'=>6));
	echo $this->BSForm->newRow();
	

	
	