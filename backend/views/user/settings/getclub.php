<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
foreach($clublist as $club)
    {?><option value="<?php echo $club['id']?>"><?php echo $club['name'];?></option>
    
<?php }

die;