<?php

class Z61_ThreadMinChars_XenForo_ControllerPublic_Thread extends  XFCP_Z61_ThreadMinChars_XenForo_ControllerPublic_Thread
{
    public function actionSave()
    {
        $title = $this->_input->filterSingle('title', XenForo_Input::STRING);
        $threadId = $this->_input->filterSingle('thread_id', XenForo_Input::UINT);

        $ftpHelper = $this->getHelper('ForumThreadPost');
        list($thread, $forum) = $ftpHelper->assertThreadValidAndViewable($threadId);

        if (!empty($forum))
        {
            if ($forum['z61_character_min_enable'] == true)
            {
                if (strlen($title) < $forum['z61_character_min'])
                {
                    return $this->responseError(new XenForo_Phrase('z61_threadminchars_thread_title_must_contain_at_least_x_characters', array('x' => $forum['z61_character_min'])));
                }
            }
        }
        return parent::actionSave();
    }
}