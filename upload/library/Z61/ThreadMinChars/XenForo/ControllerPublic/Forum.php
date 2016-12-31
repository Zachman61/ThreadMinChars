<?php

class Z61_ThreadMinChars_XenForo_ControllerPublic_Forum extends XFCP_Z61_ThreadMinChars_XenForo_ControllerPublic_Forum
{
    public function actionAddThread()
    {
        $title = $this->_input->filterSingle('title', XenForo_Input::STRING);
        $nodeId = $this->_input->filterSingle('node_id', XenForo_Input::UINT);

        $forum = $this->_getForumModel()->getForumById($nodeId);

        if (!empty($forum))
        {
            if ($forum['z61_character_min_enable'])
            {
                if (strlen($title) < $forum['z61_character_min'])
                {
                    return $this->responseError(new XenForo_Phrase('z61_threadminchars_thread_title_must_contain_at_least_x_characters', array('x' => $forum['z61_character_min'])));
                }
            }
        }
        return parent::actionAddThread();
    }
}