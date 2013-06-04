    <?php
	    echo $this->BSForm->hidden('Form.type',array('value'=>'bank_account'));
	    echo $this->BSForm->input('bankCity', array('options' => $cities, 'empty' => '-- Seçiniz --','label'=>'İl', 'bsSpan'=>3));
	    echo $this->BSForm->input('bankName',array('options' => $bankList, 'empty' => '-- Seçiniz --','label'=>'Banka Adı', 'bsSpan'=>3));
	    echo $this->BSForm->newRow();
	    echo $this->BSForm->input('bankOfficeName',array('label'=>'Şube Adı', 'bsSpan'=>3));
	    echo $this->BSForm->input('bankOfficeCode',array('label'=>'Şube Kodu', 'bsSpan'=>3));
	    echo $this->BSForm->input('bankPayeeTitle',array('label'=>'Ünvan', 'bsSpan'=>6));
	    echo $this->BSForm->newRow();
	    echo $this->BSForm->input('bankAccountNo',array('label'=>'Hesap No', 'bsSpan'=>3));
	    echo $this->BSForm->input('bankAccountIBAN',array('label'=>'IBAN No', 'bsSpan'=>3));
    ?>
