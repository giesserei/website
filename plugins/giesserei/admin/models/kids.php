<?php

defined('_JEXEC') or die('Restricted access');

class GiessereiModelKids extends JModelList
{

    protected function getListQuery()
    {
        $db = $this->getDBO();
        $query = $db->getQuery(true);

        $query->select('*');
        $query->from('#__mgh_kind');
        $query->order('nachname ASC');

        return $query;
    }

}
