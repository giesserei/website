<?php
defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');

class JFormFieldWohnungstyp extends JFormFieldList
{
    /**
     * Method to get the field options.
     *
     * @return  array  The field option objects.
     */
    protected function getOptions()
    {
        $options = array();

        $typen = $this->getTypen();
        foreach ($typen as $option)
        {
            $value = (string) $option->id;
            $text = $option->bezeichnung . '(' . $option->zimmerbezeichnung . ')';

            $tmp = array(
                'value'    => $value,
                'text'     => $text,
                'disable'  => false,
                'class'    => '',
                'selected' => false,
                'checked'  => false
            );

            // Add the option object to the result set.
            $options[] = (object) $tmp;
        }

        reset($options);

        return $options;
    }

    private function getTypen()
    {
        $db = JFactory::getDBO();
        $query = "SELECT * FROM #__mgh_objekttyp ORDER BY bezeichnung";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        return ($rows);
    }

}


