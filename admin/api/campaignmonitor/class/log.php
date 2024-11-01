<?php
define('VCS_CS_REST_LOG_VERBOSE', 1000);
define('VCS_CS_REST_LOG_WARNING', 500);
define('VCS_CS_REST_LOG_ERROR', 250);
define('VCS_CS_REST_LOG_NONE', 0);

if ( ! class_exists('VCS_CS_REST_Log') ) :
class VCS_CS_REST_Log {
    var $_level;

    function VCS_CS_REST_Log($level) {
        $this->_level = $level;
    }

    function log_message($message, $module, $level) {
        if($this->_level >= $level) {
            echo date('G:i:s').' - '.$module.': '.$message."<br />\n";
        }
    }
}
endif;