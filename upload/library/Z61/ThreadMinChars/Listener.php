<?php

class Z61_ThreadMinChars_Listener
{
    public static function loadForumDataWriter($class, &$extend)
    {
        $extend[] = 'Z61_ThreadMinChars_XenForo_DataWriter_Forum';
    }

    public static function loadAdminForumController($class, &$extend)
    {
        $extend[] = 'Z61_ThreadMinChars_XenForo_ControllerAdmin_Forum';
    }

    public static function loadPublicThreadController($class, &$extend)
    {
        $extend[] = 'Z61_ThreadMinChars_XenForo_ControllerPublic_Thread';
    }

    public static function loadPublicForumController($class, &$extend)
    {
        $extend[] = 'Z61_ThreadMinChars_XenForo_ControllerPublic_Forum';
    }
}