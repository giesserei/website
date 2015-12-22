<?php

defined('_JEXEC') or die('Restricted access');

class GiessereiModelFlats extends JModelList
{

    protected function getListQuery()
    {
        $db = $this->getDBO();
        $query = $db->getQuery(true);

        $query->select('*,mo.id as id');
        $query->from('#__mgh_mietobjekt as mo,#__mgh_objekttyp as ot');
        $query->where('mo.typid = ot.id');
        $query->order('mo.id ASC');

        return $query;
    }

}
