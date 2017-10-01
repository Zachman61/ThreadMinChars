<?php

class Z61_ThreadMinChars_Install
{
    public static function install($installedAddon)
    {
        $db = XenForo_Application::getDb();

        if (XenForo_Application::$versionId < 1030070)
        {
            throw new XenForo_Exception('This add-on requires XenForo 1.3.0 or higher.', true);
        }

        $version = is_array($installedAddon) ? $installedAddon['version_id'] : 0;

        if (empty($version)) {

            foreach (self::_getAlters() AS $alterSql) {
                try {
                    $db->query($alterSql);
                } catch (Zend_Db_Exception $e) {
                }
            }
        }
        else
        {
            if ($version < 1010)
            {
                foreach(static::_getUpgrades() as $upgradeSql) {
                    try {
                        $db->query($upgradeSql);
                    } catch(Zend_Db_Exception $e) {
                    }
                }
            }
        }
    }

    public static function uninstall()
    {
        $db = XenForo_Application::getDb();

        try
        {
            $db->query("ALTER TABLE xf_forum DROP `z61_character_min_enable`, DROP `z61_character_min` ");
        }
        catch (Zend_Db_Exception $e) {}
    }

    protected static function _getAlters()
    {
        $alters = array();

        $alters['xf_forum'] = "
            ALTER TABLE `xf_forum`
                ADD COLUMN `z61_character_min_enable` TINYINT(3) UNSIGNED NOT NULL DEFAULT 0,
                ADD COLUMN `z61_character_min` INT(11) UNSIGNED NOT NULL DEFAULT 5          
        ";
        return $alters;
    }

    protected static function _getUpgrades()
    {
        $updates = array();

        $updates['xf_forum'] = "
            ALTER TABLE `xf_forum`
            CHANGE `z61_character_min_enable` DEFAULT 0
        ";

        return $updates;
    }

}