<?php

class Z61_ThreadMinChars_XenForo_ControllerAdmin_Forum extends XFCP_Z61_ThreadMinChars_XenForo_ControllerAdmin_Forum
{
    public function actionSave()
    {
        $this->_assertPostOnly();

        if ($this->_input->filterSingle('delete', XenForo_Input::STRING))
        {
            return $this->responseReroute('XenForo_ControllerAdmin_Forum', 'deleteConfirm');
        }

        $nodeId = $this->_input->filterSingle('node_id', XenForo_Input::UINT);

        $prefixIds = $this->_input->filterSingle('available_prefixes', XenForo_Input::UINT, array('array' => true));

        $writerData = $this->_input->filter(array(
            'title' => XenForo_Input::STRING,
            'node_name' => XenForo_Input::STRING,
            'node_type_id' => XenForo_Input::STRING,
            'parent_node_id' => XenForo_Input::UINT,
            'display_order' => XenForo_Input::UINT,
            'display_in_list' => XenForo_Input::UINT,
            'description' => XenForo_Input::STRING,
            'style_id' => XenForo_Input::UINT,
            'moderate_threads' => XenForo_Input::UINT,
            'moderate_replies' => XenForo_Input::UINT,
            'allow_posting' => XenForo_Input::UINT,
            'allow_poll' => XenForo_Input::UINT,
            'count_messages' => XenForo_Input::UINT,
            'find_new' => XenForo_Input::UINT,
            'default_prefix_id' => XenForo_Input::UINT,
            'require_prefix' => XenForo_Input::UINT,
            'allowed_watch_notifications' => XenForo_Input::STRING,
            'default_sort_order' => XenForo_Input::STRING,
            'default_sort_direction' => XenForo_Input::STRING,
            'list_date_limit_days' => XenForo_Input::UINT,
            'min_tags' => XenForo_Input::UINT,
            'z61_character_min_enable' => XenForo_Input::BOOLEAN,
            'z61_character_min' => XenForo_Input::UINT,
        ));
        if (!$this->_input->filterSingle('style_override', XenForo_Input::UINT))
        {
            $writerData['style_id'] = 0;
        }

        $writer = $this->_getNodeDataWriter();

        if ($nodeId)
        {
            $writer->setExistingData($nodeId);
        }

        if (!in_array($writerData['default_prefix_id'], $prefixIds))
        {
            $writerData['default_prefix_id'] = 0;
        }
        $writer->bulkSet($writerData);
        $writer->save();

        $this->_getPrefixModel()->updatePrefixForumAssociationByForum($writer->get('node_id'), $prefixIds);

        return $this->responseRedirect(
            XenForo_ControllerResponse_Redirect::SUCCESS,
            XenForo_Link::buildAdminLink('nodes') . $this->getLastHash($writer->get('node_id'))
        );
    }
}