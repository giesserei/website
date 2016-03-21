<?php

defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
echo GiessereiFrontendHelper::getScriptToHideHeaderImage();

?>

<h1 style="font-weight:bold;color: #7BA428; margin-bottom:10px;padding-bottom:0px;">
    Foto hochladen von <?php echo $this->item->vorname . " " . $this->item->nachname ?>
</h1>

<div class="component">

    Wir verwenden in der Mitglieder- und Bewohnerliste dein Foto (Avatar) aus dem Forum.
    <p/>
    Daher ist das Aendern deines Fotos nur über die Profil-Seite des Forums möglich. Mit dem folgenden Button kannst du
    direkt
    auf die Profil-Seite des Forums springen. Von da gelangst du über die Menüleiste wieder zurück zur Profil-Seite
    unserer Mitglieder-Datenbank.

    <div style="margin-top:25px;">
        <?php echo "<input type=\"button\" value=\"Profil-Seite des Forums\" onclick=\"window.location.href='forum/profile?view=user&layout=edit&userid=" . $this->item->userid . "'\" />" ?>
        <input type="button" value="Zurück"
               onclick="window.location.href='<?php echo JRoute::_('index.php?option=com_giesserei&view=profil&layout=view') ?>'"/>
    </div>
</div>