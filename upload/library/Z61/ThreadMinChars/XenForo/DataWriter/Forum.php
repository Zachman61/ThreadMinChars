<?php

class Z61_ThreadMinChars_XenForo_DataWriter_Forum extends XFCP_Z61_ThreadMinChars_XenForo_DataWriter_Forum
{
    protected function _getFields()
    {
        $response = parent::_getFields();
        $response['xf_forum'] += array(
            'z61_character_min'               => array('type' => self::TYPE_UINT, 'min' => 5, 'max' => '150', 'default' => 0),
            'z61_character_min_enable'        => array('type' => self::TYPE_BOOLEAN, 'default' => 0)
        );

        return $response;
    }
}