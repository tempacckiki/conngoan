<?php

class DatabaseDebug extends Phpfox_Service
{

        public function __construct()
        {
                $this->_sTable = Phpfox::getT('user');
        }

        public function getAllUsers()
        {
                return $this->database()->select('u.*')
                                ->from(Phpfox::getT('user'), 'u')
                                ->execute('getSlaveRows');
        }

}

?>