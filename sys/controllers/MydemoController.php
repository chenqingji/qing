<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MydemoController
 *
 * @author jm
 */
class MydemoController extends SysController {

    public function shortCurUrl() {
        include '../class/ShortUrl.class.php';

        $orginalUrl = 'http://www.fanstang.com/v/98447';
        $newUrl = ShortUrl::cutStringToArrayWithFourSubString($orginalUrl);

        echo $orginalUrl . "<br />";
        echo $newUrl . "<br />";
    }
    
    

}

?>
