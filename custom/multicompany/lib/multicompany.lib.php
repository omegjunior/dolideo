<?php
/* Copyright (C) 2011-2023 Regis Houssin  <regis.houssin@inodbox.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * or see http://www.gnu.org/
 */

/**
 *	\file       /multicompany/lib/multicompany.lib.php
 *	\brief      Ensemble de fonctions de base pour le module Multi-Company
 * 	\ingroup	multicompany
 */


function multicompany_prepare_head()
{
	global $langs, $conf;
	$langs->load('multicompany@multicompany');

	$h = 0;
	$head = array();

	$head[$h][0] = dol_buildpath("/multicompany/admin/multicompany.php",1);
	$head[$h][1] = $langs->trans("Entities");
	$head[$h][2] = 'entities';
	$h++;

	$head[$h][0] = dol_buildpath("/multicompany/admin/options.php",1);
	$head[$h][1] = $langs->trans("Options");
	$head[$h][2] = 'options';
	$h++;

	if (!empty($conf->global->MULTICOMPANY_SHARING_BYELEMENT_ENABLED)) {
		$head[$h][0] = dol_buildpath("/multicompany/admin/granularity.php",1);
		$head[$h][1] = $langs->trans("SharingsByElement");
		$head[$h][2] = 'granularity';
		$h++;
	}

	$head[$h][0] = dol_buildpath("/multicompany/admin/caches.php",1);
	$head[$h][1] = $langs->trans("Caches");
	$head[$h][2] = 'caches';
	$h++;

	$head[$h][0] = dol_buildpath("/multicompany/admin/multicompany_extrafields.php", 1);
	$head[$h][1] = $langs->trans("ExtraFields");
	$head[$h][2] = 'attributes';
	$h ++;

    // Show more tabs from modules
    // Entries must be declared in modules descriptor with line
    // $this->tabs = array('entity:+tabname:Title:@mymodule:/mymodule/mypage.php?id=__ID__');   to add new tab
    // $this->tabs = array('entity:-tabname:Title:@mymodule:/mymodule/mypage.php?id=__ID__');   to remove a tab
    complete_head_from_modules($conf,$langs,null,$head,$h,'multicompany');

    $head[$h][0] = dol_buildpath("/multicompany/admin/about.php",1);
    $head[$h][1] = $langs->trans("About");
    $head[$h][2] = 'about';
    $h++;

	return $head;
}

/**
 * Prepare array with list of tabs
 *
 * @param   Object	$object		Object related to tabs
 * @param	array	$aEntities	Entities array
 * @return  array				Array of tabs
 */
function entity_prepare_head($object, $aEntities)
{
	global $conf, $langs, $user, $mc;

	$head = array();
	$i = 0;

	foreach($aEntities as $entity)
	{
		$mc->getInfo($entity);

		if (empty($conf->global->MULTICOMPANY_TEMPLATE_MANAGEMENT) && $mc->visible == 2) continue;
		if ($object->element == 'user' && $mc->visible == 2) continue;
		if ($mc->visible == 2 && (empty($user->admin) || !empty($user->entity))) continue;		// Only visible by superadmin

		$head[$entity][0] = $_SERVER['PHP_SELF'].'?id='.$object->id.'&amp;entity='.$entity;
		if ($mc->visible == 2) {
			$head[$entity][1] = '<span id="template_' . $object->id . '" class="fas fa-clone multicompany-button-template" title="'.$langs->trans("TemplateOfEntity").'"></span>'.$mc->label;
		} else {
			$head[$entity][1] = '<span id="template_' . $object->id . '" class="fas fa-globe multicompany-button-template" title="'.$langs->trans("Entity").'"></span>'.$mc->label;
		}
		$head[$entity][2] = $entity;

		$i++;
	}

	if (!empty($conf->global->MULTICOMPANY_TEMPLATE_MANAGEMENT) && $object->element == 'usergroup' && !empty($user->admin) && empty($user->entity)) { // Only visible by superadmin
		$i = $i + $entity;

		$head[$i][0] = '';
		$head[$i][1] = '<span id="clonerights" class="fas fa-sitemap multicompany-button-clonerights" title="'.$langs->trans("DuplicateRights").'"></span>';
		$head[$i][2] = 'image';
	}

	return $head;
}

/**
 *
 */
function getTablesWithField($searchfield, $exclude=false, $include=false)
{
	global $db;

	$out=array();

	$tables = $db->DDLListTables($db->database_name);

	if (is_array($tables))
	{
		// Pour chaque table : vérif si présence d'un champ
		foreach($tables as $table)
		{
			if (is_array($exclude))
			{
				if (! in_array($table, $exclude, true))
				{
					$datas = $db->DDLInfoTable($table);
					foreach ($datas as $key => $fields)
					{
						if (is_array($fields) && in_array($searchfield, $fields))
						{
							$out[] = $table;
						}
					}
				}
			}
			else if (!empty($exclude))
			{
				if (! preg_match($exclude, $table))
				{
					$datas = $db->DDLInfoTable($table);
					foreach ($datas as $key => $fields)
					{
						if (is_array($fields) && in_array($searchfield, $fields))
						{
							$out[] = $table;
						}
					}
				}
			}
			else if (!empty($include))
			{
				if (preg_match($include, $table))
				{
					$datas = $db->DDLInfoTable($table);
					foreach ($datas as $key => $fields)
					{
						if (is_array($fields) && in_array($searchfield, $fields))
						{
							$out[] = $table;
						}
					}
				}
			}
		}
	}

	return $out;
}

/**
 *
 */
function getSqlInitFilePath($name)
{
	return dol_buildpath("/multicompany/sql/init/llx_" . basename($name) . ".sql");
}

function isSharingAllByDefault($element)
{
	global $conf;

	if (empty($conf->global->MULTICOMPANY_SHARING_BYELEMENT_ENABLED)) {
		return false;
	}

	$sharingbyelementname = 'MULTICOMPANY_'.strtoupper($element).'_SHARING_BYELEMENT_ENABLED';
	$shareallbydefaultname = 'MULTICOMPANY_'.strtoupper($element).'_SHARE_ALL_BY_DEFAULT';

	if (!empty($conf->global->$sharingbyelementname) && !empty($conf->global->$shareallbydefaultname)) {
		return true;
	}

	return false;
}

/**
 *
 * @param unknown $url
 * @param unknown $param
 * @return mixed
 */
function removeParam($url, $param) {
	$url = preg_replace('/(&|\?)'.preg_quote($param).'=[^&]*$/', '', $url);
	$url = preg_replace('/(&|\?)'.preg_quote($param).'=[^&]*&/', '$1', $url);
	return $url;
}

/**
 * Get a value from the store
 *
 * @param  string $key Data Key
 *
 * @return string|null
 */
function getCache($key)
{
	global $conf, $sessionname;

	$key = $sessionname . '_' . date("Y-m-d-H") . '_' . $key; // 1 hour validity

	if (!empty($conf->global->MULTICOMPANY_MEMCACHED_ENABLED)) {
		$serveraddress = (!empty($conf->global->MULTICOMPANY_MEMCACHED_SERVER) ? $conf->global->MULTICOMPANY_MEMCACHED_SERVER : (!empty($conf->global->MEMCACHED_SERVER)?$conf->global->MEMCACHED_SERVER : '127.0.0.1:11211'));
		$tmparray = explode(':',$serveraddress);
		$host = $tmparray[0];
		$port = (!empty($tmparray[1])?$tmparray[1]:11211);

		// Using a memcached server
		if (class_exists('Memcached')) {
			$m = new Memcached();
			$result = $m->addServer($host, $port);
			$data = $m->get($key);
			$rescode = $m->getResultCode();
			if ($rescode == 0) {
				return $data;
			}
		} elseif (class_exists('Memcache')) {
			$m = new Memcache();
			$result = $m->addServer($host, $port);
			$data = $m->get($key);
			if ($data) {
				return $data;
			}
		}
	} elseif (!empty($conf->global->MULTICOMPANY_SHMOP_ENABLED)) {
		if (function_exists("shmop_read")) {
			$shmkey = base_convert(hash("crc32b", $key), 16, 10);
			$handle = @shmop_open($shmkey,'a',0,0);
			if (!empty($handle)) {
				$my_string = trim(@shmop_read($handle,0,0));
				if (!empty($conf->global->MULTICOMPANY_SHMOP_MEMCOMPRESS_LEVEL) && function_exists('gzuncompress')){
					$my_string = @gzuncompress($my_string);
				}
				if (!empty($my_string)) {
					return unserialize(base64_decode($my_string));
				}
			}
		}
	} elseif (!empty($conf->global->MULTICOMPANY_SESSION_ENABLED)) {
		if (isset($_SESSION[$key])) {
			return unserialize(base64_decode($_SESSION[$key]));
		}
	}

	return false;
}

/**
 * Set a value in the store
 * @param string $key   Data Key
 * @param string $value Data Value
 *
 * @return void
 */
function setCache($key, $value)
{
	global $conf, $sessionname;

	$key = $sessionname . '_' . date("Y-m-d-H") . '_' . $key; // 1 hour validity

	if (!empty($conf->global->MULTICOMPANY_MEMCACHED_ENABLED)) {
		$serveraddress = (!empty($conf->global->MULTICOMPANY_MEMCACHED_SERVER) ? $conf->global->MULTICOMPANY_MEMCACHED_SERVER : (!empty($conf->global->MEMCACHED_SERVER) ? $conf->global->MEMCACHED_SERVER : '127.0.0.1:11211'));
		$tmparray = explode(':',$serveraddress);
		$host = $tmparray[0];
		$port = (!empty($tmparray[1]) ? $tmparray[1] : 11211);

		// Using a memcached server
		if (class_exists('Memcached')) {
			$m = new Memcached();
			$result = $m->addServer($host, $port);
			$m->set($key, $value);
			$rescode = $m->getResultCode();
			if ($rescode == 0) {
				return true;
			}
		} elseif (class_exists('Memcache')) {
			$m = new Memcache();
			$result = $m->addServer($host, $port);
			$result = $m->set($key, $value);
			if ($result) {
				return true;
			}
		}
	} elseif (!empty($conf->global->MULTICOMPANY_SHMOP_ENABLED)) {
		if (function_exists("shmop_write")) {
			$shmkey = base_convert(hash("crc32b", $key), 16, 10);
			$fdata = base64_encode(serialize($value));
			if (!empty($conf->global->MULTICOMPANY_SHMOP_MEMCOMPRESS_LEVEL) && function_exists('gzcompress')){
				$fdata = @gzcompress($fdata, (int) $conf->global->MULTICOMPANY_SHMOP_MEMCOMPRESS_LEVEL);
			}
			$fsize = strlen($fdata);
			$handle = @shmop_open($shmkey,'c',0644,$fsize);
			if (!empty($handle)) {
				$shm_bytes_written = @shmop_write($handle, $fdata, 0);
				if ($shm_bytes_written == $fsize) {
					return true;
				}
			}
		}
	} elseif (!empty($conf->global->MULTICOMPANY_SESSION_ENABLED)) {
		$_SESSION[$key] = base64_encode(serialize($value));
		return true;
	}

	return false;
}

/**
 * Clear the key from the store
 *
 * @param $key Data Key
 *
 * @return void
 */
function clearCache($key)
{
	global $conf, $sessionname;

	$key = $sessionname . '_' . date("Y-m-d-H") . '_' . $key; // 1 hour validity

	if (!empty($conf->global->MULTICOMPANY_MEMCACHED_ENABLED)) {
		$serveraddress = (!empty($conf->global->MULTICOMPANY_MEMCACHED_SERVER) ? $conf->global->MULTICOMPANY_MEMCACHED_SERVER : (!empty($conf->global->MEMCACHED_SERVER) ? $conf->global->MEMCACHED_SERVER : '127.0.0.1:11211'));
		$tmparray = explode(':',$serveraddress);
		$host = $tmparray[0];
		$port = (!empty($tmparray[1]) ? $tmparray[1] : 11211);

		// Using a memcached server
		if (class_exists('Memcached')) {
			$m = new Memcached();
			$result = $m->addServer($host, $port);
			$m->delete($key);
			$rescode = $m->getResultCode();
			if ($rescode == 0) {
				return true;
			}
		} elseif (class_exists('Memcache')) {
			$m = new Memcache();
			$result = $m->addServer($host, $port);
			$result = $m->delete($key);
			if ($result) {
				return true;
			}
		}
	} elseif (!empty($conf->global->MULTICOMPANY_SHMOP_ENABLED)) {
		if (function_exists("shmop_delete")) {
			$shmkey = base_convert(hash("crc32b", $key), 16, 10);
			$handle = @shmop_open($shmkey,'a',0,0);
			if (!empty($handle)) {
				if (!@shmop_delete($handle)) {
					return false;
				} else {
					return true;
				}
			}
		}
	} elseif (!empty($conf->global->MULTICOMPANY_SESSION_ENABLED)) {
		if (isset($_SESSION[$key])) {
			unset($_SESSION[$key]);
			return true;
		}
	}

	return false;
}

/**
 * 	On/off button for constant
 *
 * 	@param	string	$code			Name of constant
 * 	@param	array	$input			Array of type->list of CSS element to switch. Example: array('disabled'=>array(0=>'cssid'))
 * 	@param	int		$entity			Entity to set
 *  @param	int		$revertonoff	Revert on/off
 * 	@return	void
 */
function ajax_mcconstantonoff($code, $input = array(), $entity = null, $revertonoff = 0, $strict = 0, $forcereload = 0, $marginleftonlyshort = 2, $forcenoajax = 0)
{
	global $conf, $langs, $user;

	$entity = ((isset($entity) && is_numeric($entity) && $entity >= 0) ? $entity : $conf->entity);

	$out= "\n<!-- Ajax code to switch constant ".$code." -->".'
	<script type="text/javascript">
		$(document).ready(function() {
			var input = '.json_encode($input).';
			var url = \''.DOL_URL_ROOT.'/core/ajax/constantonoff.php\';
			var code = \''.$code.'\';
			var entity = \''.$entity.'\';
            var strict = \''.$strict.'\';
            var userid = \''.$user->id.'\';
			var yesButton = "'.dol_escape_js($langs->transnoentities("Yes")).'";
			var noButton = "'.dol_escape_js($langs->transnoentities("No")).'";
            var token = \''.currentToken().'\';

			// Set constant
			$("#set_" + code).click(function() {
				if (input.alert && input.alert.set) {
					if (input.alert.set.yesButton) yesButton = input.alert.set.yesButton;
					if (input.alert.set.noButton)  noButton = input.alert.set.noButton;
					confirmMulticompanyConstantAction("set", url, code, input, input.alert.set, entity, yesButton, noButton, strict, userid, token);
				} else {
					setMulticompanyConstant(url, code, input, entity, 0, '.$forcereload.', userid, token);
				}
			});

			// Del constant
			$("#del_" + code).click(function() {
				if (input.alert && input.alert.del) {
					if (input.alert.del.yesButton) yesButton = input.alert.del.yesButton;
					if (input.alert.del.noButton)  noButton = input.alert.del.noButton;
					confirmMulticompanyConstantAction("del", url, code, input, input.alert.del, entity, yesButton, noButton, strict, userid, token);
				} else {
					delMulticompanyConstant(url, code, input, entity, 0, '.$forcereload.', userid, token);
				}
			});
		});
	</script>'."\n";

	$out.= '<div id="confirm_'.$code.'" title="" style="display: none;"></div>';
	$out.= '<span id="set_'.$code.'" class="linkobject '.(!empty($conf->global->$code)?'hideobject':'').'">'.($revertonoff?img_picto($langs->trans("Enabled"),'switch_on', '', false, 0, 0, '', '', $marginleftonlyshort):img_picto($langs->trans("Disabled"),'switch_off', '', false, 0, 0, '', '', $marginleftonlyshort)).'</span>';
	$out.= '<span id="del_'.$code.'" class="linkobject '.(!empty($conf->global->$code)?'':'hideobject').'">'.($revertonoff?img_picto($langs->trans("Disabled"),'switch_off', '', false, 0, 0, '', '', $marginleftonlyshort):img_picto($langs->trans("Enabled"),'switch_on', '', false, 0, 0, '', '', $marginleftonlyshort)).'</span>';
	$out.="\n";

	return $out;
}

/**
 *	Check multicompany version
 *
 *	@return int		0 = OK
 *					1 = Multicompany is older than Dolibarr
 *					-1 = Dolibarr is older than MultiCompany
 *					-2 = Multicompany need upgrade (disable/enable module)
 */
function checkMultiCompanyVersion()
{
	global $conf;

	$out = 0;

	$dolversion = explode('.', DOL_VERSION);

	if (empty($conf->global->MULTICOMPANY_MAIN_VERSION) || (version_compare($dolversion[0], '18', '=') && version_compare($conf->global->MULTICOMPANY_MAIN_VERSION, '18.0.5', '<'))) {
		$out = -2;
	} else {
		$out = version_compare($dolversion[0], '18');
	}

	return $out;
}

/**
 * Check mc authentication
 */
function checkMulticompanyAutentication()
{
	global $conf;

	if (isset($conf->file->main_authentication) && preg_match('/^mc$/',$conf->file->main_authentication)) return true;
	else return false;
}