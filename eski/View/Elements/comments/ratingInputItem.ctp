<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


?>
<div class="ratingInput">
    <?php echo $this->Form->hidden($id);?>
    <table>
        <tr>
            <td width ="50%"><?php echo $label ?></td>
            <td>
                <?php 
                    for($i = 0; $i<5; $i++)
                    {
                        echo '<span class="ratingStar interactive"></span>';
                    }
                ?>
            </td>
        </tr>
    </table>
    
</div>


