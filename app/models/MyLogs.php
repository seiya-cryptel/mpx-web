<?php

class MyLogs extends Phalcon\Mvc\Model
{
    
    const LOG_TYPE_OPR          = 'O';      // User Operation
    const LOG_TYPE_ERROR        = 'E';      // Error detected
    const LOG_TYPE_WARN         = 'W';      // Warning detected
    const LOG_TYPE_INFO         = 'I';      // General Information
    const LOG_TYPE_DEBUG        = 'D';      // Debugging Information
    
    const LOG_MSG_OPR_DISPATCH          = 'DISPATCH: %s, %s, %d';
    const LOG_MSG_OPR_LOGIN             = 'LOGIN: %s, %s';
    const LOG_MSG_OPR_LOGOUT            = 'LOGOUT: %s';
    const LOG_MSG_OPR_PROFILE           = 'PROFILE: %s, %s';
    const LOG_MSG_OPR_RESETPWD          = 'RESETPWD: %s, %s, %s';
    const LOG_MSG_OPR_SETPWD            = 'SETPWD: %s, %s';
    const LOG_MSG_OPR_UPLOAD            = 'UPLOAD: %s, %s';

    public function getSource()
    {
        return "tt91_log";
    }

    public function WriteLog($type, $logMsg, $param) {
        $session = $this->getDI()->getSession();
        $auth = $session->get('auth');
        $userId = is_null($auth) ? 'not login' : $auth['user_id'];
        $this->id = null;
        $this->log_type = $type;
        $this->user_id = $userId;
        $this->remote_addr = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
        $this->log_message = vsprintf($logMsg, $param);
        $this->create();
    }

}
