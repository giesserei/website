<?php

defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
echo GiessereiFrontendHelper::getScriptToHideHeaderImage();

?>

<div class="component">

  <!-- Style direkt festgelegt, da das giesserei_default.css zu früh vom Joomla eingebunden wird -->
  <h1 style="font-weight:bold;color: #7BA428; margin-bottom:10px;padding-bottom:0px;">
    Profil von <?php echo $this->profilData->basisDaten->vorname . " " . $this->profilData->basisDaten->nachname; ?>
  </h1>
  <h1 style="margin-top:0px;padding-top:0px;font-size:14pt">
    <?php echo (empty($this->profilData->basisDaten->wohnung) ? 'Passivmitglied' : 'Wohnung: ' . $this->profilData->basisDaten->wohnung); ?>
  </h1>
  
  <div>
  <div style="float:left;margin-right:100px">
    <h3>Deine gespeicherten Daten</h3>
    <table class="user_profil">
      <tr>
        <td class="user_profil_lb">Vorname</td>
        <td class="user_profil_view"><?php echo $this->profilData->basisDaten->vorname?></td>
      </tr>
      <tr>
        <td class="user_profil_lb">Nachname</td>
        <td class="user_profil_view"><?php echo $this->profilData->basisDaten->nachname?></td>
      </tr>
      <tr>
        <td class="user_profil_lb">E-Mail</td>
        <td class="user_profil_view"><?php echo $this->profilData->basisDaten->email?></td>
      </tr>
      <tr>
        <td class="user_profil_lb">Adresse</td>
        <td class="user_profil_view"><?php echo $this->profilData->basisDaten->adresse?></td>
      </tr>
      <tr>
        <td class="user_profil_lb">PLZ</td>
        <td class="user_profil_view"><?php echo $this->profilData->basisDaten->plz?></td>
      </tr>
      <tr>
        <td class="user_profil_lb">Ort</td>
        <td class="user_profil_view"><?php echo $this->profilData->basisDaten->ort?></td>
      </tr>
      <tr>
        <td class="user_profil_lb">Telefon 1</td>
        <td class="user_profil_view">
          <?php 
          if (empty($this->profilData->basisDaten->telefon)) {
            echo "-";
          }
          else {
            echo $this->profilData->basisDaten->telefon . " (" . ($this->profilData->basisDaten->telefon_frei ? "sichtbar" : "nicht sichtbar") . ")";
          }
          ?>
        </td>
      </tr>
      <tr>
        <td class="user_profil_lb">Telefon 2</td>
        <td class="user_profil_view">
          <?php 
          if (empty($this->profilData->basisDaten->handy)) {
            echo "-";
          }
          else {
            echo $this->profilData->basisDaten->handy . " (" . ($this->profilData->basisDaten->handy_frei ? "sichtbar" : "nicht sichtbar") . ")";
          }
          ?>
        </td>
      </tr>
      <tr>
        <td class="user_profil_lb">Geburtstag</td>
        <td class="user_profil_view">
          <?php 
            $birthdate = GiessereiFrontendHelper::mysqlDateToViewDate($this->profilData->basisDaten->birthdate);
            echo empty($birthdate) ? '-' : $birthdate;
          ?>
        </td>
      </tr>
    </table>

    <fieldset>
      <input type="button" value="Bearbeiten" onclick="window.location.href='index.php?option=com_giesserei&task=updprofil.edit'" />
      <input type="button" value="Passwort ändern" onclick="window.location.href='index.php?option=com_giesserei&task=updpassword.edit'" />
    </fieldset>
  </div>
  <?php if (!empty($this->profilData->kindListe)) { ?>
    <div>
      <h3><?php echo count($this->profilData->kindListe) == 1 ? "Daten deines minderjährigen Kindes" : "Daten deiner minderjährigen Kinder" ?></h3>
      <?php foreach ($this->profilData->kindListe as $kind) { ?>
        <table class="user_profil">
          <tr>
            <td class="user_profil_lb">Vorname</td>
            <td class="user_profil_view"><?php echo $kind->vorname . " (" . ($kind->name_frei ? "sichtbar" : "nicht sichtbar") . ")"; ?></td>
          </tr>
          <tr>
            <td class="user_profil_lb">Jahrgang</td>
            <td class="user_profil_view"><?php echo $kind->jahrgang . " (" . ($kind->jahrgang_frei ? "sichtbar" : "nicht sichtbar") . ")"; ?></td>
          </tr>
          <tr>
            <td class="user_profil_lb">Handy</td>
            <td class="user_profil_view">
              <?php 
                if (empty($kind->handy)) {
                  echo "-";
                }
                else {
                  echo $kind->handy . " (" . ($kind->handy_frei ? "sichtbar" : "nicht sichtbar") . ")";
                }
              ?>
            </td>
          </tr>
        </table>
        <div style="margin-top:5px;margin-bottom:20px;">
          <?php 
          echo "<input type=\"button\" value=\"Bearbeiten\" onclick=\"window.location.href='index.php?option=com_giesserei&task=updkind.edit&kind_id=". $kind->id ."'\" />";
          ?>
        </div>
      <?php } ?>
    </div>
  <?php } ?>
  </div>
  
  <div style="clear:both"></div>
 
  <div>
    <div style="float:right;margin-left:60px;margin-bottom:20px;margin-top:17px">
      <?php echo "<img src='/media/kunena/avatars/resized/size200/" . $this->profilData->basisDaten->avatar. "'></img>"; ?>
    </div>
    <div >
      <h3>Zu deiner Person</h3>
      <?php 
        if (empty($this->profilData->basisDaten->zur_person)) {
          echo "Du hast dich noch nicht beschrieben.";
        }
        else {
          echo $this->profilData->basisDaten->zur_person;
        }
      ?>
      <div style="margin-top:15px;">
        <input type="button" value="Bearbeiten" onclick="window.location.href='index.php?option=com_giesserei&task=updbeschreibung.edit'" />
        <?php echo "<input type=\"button\" value=\"Foto hochladen\" onclick=\"window.location.href='index.php?option=com_giesserei&task=updbeschreibung.jumpToPhoto'\" />" ?>
        
      </div>
    </div>
  </div>
 
</div>