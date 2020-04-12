<?php

add_filter('timber_context', 'twigex_get_url');

function twigex_get_url($data) {
    
    $data['url'] = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    
    return $data;
}

class SoftvalenciaPost extends TimberPost {

    var $_wpcf_image;
    
    public function wpcf_image() {
        if (!$this->_wpcf_image) {
            $this->_wpcf_image=get_post_meta(get_the_ID(),'mf-imatge',true);
        }
        return $this->_issue;
    }
}
