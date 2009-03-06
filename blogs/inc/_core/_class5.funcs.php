<?php
/**
 * Function for handling Classes in PHP 5.
 *
 * For PHP4, _class4.funcs.php gets used.
 *
 * This file is part of the evoCore framework - {@link http://evocore.net/}
 * See also {@link http://sourceforge.net/projects/evocms/}.
 *
 * @copyright (c)2009 by Francois PLANQUE - {@link http://fplanque.net/}
 * Parts of this file are copyright (c)2009 by Daniel HAHLER - {@link http://daniel.hahler.de/}.
 *
 * {@internal License choice
 * - If you have received this file as part of a package, please find the license.txt file in
 *   the same folder or the closest folder above for complete license terms.
 * - If you have received this file individually (e-g: from http://evocms.cvs.sourceforge.net/)
 *   then you must choose one of the following licenses before using the file:
 *   - GNU General Public License 2 (GPL) - http://www.opensource.org/licenses/gpl-license.php
 *   - Mozilla Public License 1.1 (MPL) - http://www.opensource.org/licenses/mozilla1.1.php
 * }}
 *
 * {@internal Open Source relicensing agreement:
 * Daniel HAHLER grants Francois PLANQUE the right to license
 * Daniel HAHLER's contributions to this file and the b2evolution project
 * under any OSI approved OSS license (http://www.opensource.org/licenses/).
 * }}
 *
 * @package evocore
 *
 * @author blueyed: Daniel HAHLER.
 *
 * @version $Id$
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );


/**
 * Autoload class files, if the class gets accessed and is not defined yet.
 * Requires PHP5.
 */
function __autoload($classname)
{
	global $inc_path, $adminskins_path;
	static $map_class_path;

	/*
	List generated with (executed in ./blogs):
	for i in $(find . -name \*.class.php -o -name \*.widget.php); do echo "'$(basename $i .php | tr '[:upper:'] '[:lower:'] | sed 's/.widget$/_widget/; s/.class$//; s/^_//; s/^collsettings$/collectionsettings/; s/^itemlist$/itemlist2/; s/^widget$/componentwidget/; s/^uiwidget$/widget/')' => $(echo $i|sed "s~^./inc/~\$inc_path.'~;s~^./skins_adm/~\$adminskins_path.'/~")',"; done
	*/
	if( ! isset($map_class_path) )
	{
		$_map_class_path = array(
			/* SPECIAL: several classes in one file. */
			'table' => $inc_path.'_core/ui/_uiwidget.class.php',
			'log_noop' => $inc_path.'_core/model/_log.class.php',
			/* SPECIAL END */

			/* AUTOGENERATED LIST: */
			'commentlist' => $inc_path.'comments/model/_commentlist.class.php',
			'comment' => $inc_path.'comments/model/_comment.class.php',
			'skin' => $inc_path.'skins/model/_skin.class.php',
			'skincache' => $inc_path.'skins/model/_skincache.class.php',
			'iconlegend' => $inc_path.'_core/ui/_iconlegend.class.php',
			'form' => $inc_path.'_core/ui/forms/_form.class.php',
			'resultsel' => $inc_path.'_core/ui/results/_resultsel.class.php',
			'results' => $inc_path.'_core/ui/results/_results.class.php',
			'widget' => $inc_path.'_core/ui/_uiwidget.class.php',
			'pagecache' => $inc_path.'_core/model/_pagecache.class.php',
			'dataobjectcache' => $inc_path.'_core/model/dataobjects/_dataobjectcache.class.php',
			'dataobjectlist' => $inc_path.'_core/model/dataobjects/_dataobjectlist.class.php',
			'dataobjectlist2' => $inc_path.'_core/model/dataobjects/_dataobjectlist2.class.php',
			'dataobject' => $inc_path.'_core/model/dataobjects/_dataobject.class.php',
			'timer' => $inc_path.'_core/model/_timer.class.php',
			'log' => $inc_path.'_core/model/_log.class.php',
			'sql' => $inc_path.'_core/model/db/_sql.class.php',
			'db' => $inc_path.'_core/model/db/_db.class.php',
			'filetype' => $inc_path.'files/model/_filetype.class.php',
			'filetypecache' => $inc_path.'files/model/_filetypecache.class.php',
			'filerootcache' => $inc_path.'files/model/_filerootcache.class.php',
			'file' => $inc_path.'files/model/_file.class.php',
			'filecache' => $inc_path.'files/model/_filecache.class.php',
			'filelist' => $inc_path.'files/model/_filelist.class.php',
			'fileroot' => $inc_path.'files/model/_fileroot.class.php',
			'coll_xml_feeds_widget' => $inc_path.'widgets/widgets/_coll_xml_feeds.widget.php',
			'coll_longdesc_widget' => $inc_path.'widgets/widgets/_coll_longdesc.widget.php',
			'coll_title_widget' => $inc_path.'widgets/widgets/_coll_title.widget.php',
			'menu_link_widget' => $inc_path.'widgets/widgets/_menu_link.widget.php',
			'user_tools_widget' => $inc_path.'widgets/widgets/_user_tools.widget.php',
			'coll_media_index_widget' => $inc_path.'widgets/widgets/_coll_media_index.widget.php',
			'coll_category_list_widget' => $inc_path.'widgets/widgets/_coll_category_list.widget.php',
			'coll_common_links_widget' => $inc_path.'widgets/widgets/_coll_common_links.widget.php',
			'colls_list_owner_widget' => $inc_path.'widgets/widgets/_colls_list_owner.widget.php',
			'coll_post_list_widget' => $inc_path.'widgets/widgets/_coll_post_list.widget.php',
			'coll_comment_list_widget' => $inc_path.'widgets/widgets/_coll_comment_list.widget.php',
			'coll_search_form_widget' => $inc_path.'widgets/widgets/_coll_search_form.widget.php',
			'colls_list_public_widget' => $inc_path.'widgets/widgets/_colls_list_public.widget.php',
			'coll_logo_widget' => $inc_path.'widgets/widgets/_coll_logo.widget.php',
			'links_widget' => $inc_path.'widgets/widgets/_links.widget.php',
			'coll_tagline_widget' => $inc_path.'widgets/widgets/_coll_tagline.widget.php',
			'free_html_widget' => $inc_path.'widgets/widgets/_free_html.widget.php',
			'coll_page_list_widget' => $inc_path.'widgets/widgets/_coll_page_list.widget.php',
			'coll_tag_cloud_widget' => $inc_path.'widgets/widgets/_coll_tag_cloud.widget.php',
			'linkblog_widget' => $inc_path.'widgets/widgets/_linkblog.widget.php',
			'widgetcache' => $inc_path.'widgets/model/_widgetcache.class.php',
			'componentwidget' => $inc_path.'widgets/model/_widget.class.php',
			'session' => $inc_path.'sessions/model/_session.class.php',
			'hitlist' => $inc_path.'sessions/model/_hitlist.class.php',
			'hit' => $inc_path.'sessions/model/_hit.class.php',
			'goal' => $inc_path.'sessions/model/_goal.class.php',
			'idna_convert' => $inc_path.'_ext/idna/_idna_convert.class.php',
			'item' => $inc_path.'items/model/_item.class.php',
			'itemlistlight' => $inc_path.'items/model/_itemlistlight.class.php',
			'itemlight' => $inc_path.'items/model/_itemlight.class.php',
			'link' => $inc_path.'items/model/_link.class.php',
			'itemlist2' => $inc_path.'items/model/_itemlist.class.php',
			'itemtype' => $inc_path.'items/model/_itemtype.class.php',
			'itemquery' => $inc_path.'items/model/_itemquery.class.php',
			'linkcache' => $inc_path.'items/model/_linkcache.class.php',
			'itemtypecache' => $inc_path.'items/model/_itemtypecache.class.php',
			'itemcache' => $inc_path.'items/model/_itemcache.class.php',
			'group' => $inc_path.'users/model/_group.class.php',
			'usercache' => $inc_path.'users/model/_usercache.class.php',
			'user' => $inc_path.'users/model/_user.class.php',
			'usersettings' => $inc_path.'users/model/_usersettings.class.php',
			'genericorderedcache' => $inc_path.'generic/model/_genericorderedcache.class.php',
			'genericordered' => $inc_path.'generic/model/_genericordered.class.php',
			'genericcategory' => $inc_path.'generic/model/_genericcategory.class.php',
			'genericcategorycache' => $inc_path.'generic/model/_genericcategorycache.class.php',
			'genericelement' => $inc_path.'generic/model/_genericelement.class.php',
			'genericcache' => $inc_path.'generic/model/_genericcache.class.php',
			'xhtml_validator' => $inc_path.'xhtml_validator/_xhtml_validator.class.php',
			'pofile' => $inc_path.'locales/_pofile.class.php',
			'plugins' => $inc_path.'plugins/model/_plugins.class.php',
			'plugins_admin' => $inc_path.'plugins/model/_plugins_admin.class.php',
			'pluginsettings' => $inc_path.'plugins/model/_pluginsettings.class.php',
			'pluginusersettings' => $inc_path.'plugins/model/_pluginusersettings.class.php',
			'plugins_admin_no_db' => $inc_path.'plugins/model/_plugins_admin_no_db.class.php',
			'plugin' => $inc_path.'plugins/_plugin.class.php',
			'cronjob' => $inc_path.'cron/model/_cronjob.class.php',
			'generalsettings' => $inc_path.'settings/model/_generalsettings.class.php',
			'abstractsettings' => $inc_path.'settings/model/_abstractsettings.class.php',
			'blogcache' => $inc_path.'collections/model/_blogcache.class.php',
			'collectionsettings' => $inc_path.'collections/model/_collsettings.class.php',
			'blog' => $inc_path.'collections/model/_blog.class.php',
			'chaptercache' => $inc_path.'chapters/model/_chaptercache.class.php',
			'chapter' => $inc_path.'chapters/model/_chapter.class.php',
			'adminui_general' => $adminskins_path.'/_adminUI_general.class.php',
			'adminui' => $adminskins_path.'/evo/_adminUI.class.php',
			'adminui' => $adminskins_path.'/legacy/_adminUI.class.php',
			'adminui' => $adminskins_path.'/chicago/_adminUI.class.php',
			/* AUTOGENERATED LIST END */
		);
		$map_class_path = $_map_class_path;
	}

	$classname = strtolower($classname);
	if( isset($map_class_path[$classname]) )
	{
		require_once $map_class_path[$classname];
	}
}


/**
 * Load class file. No-op for PHP5, uses __autoload().
 * But handle the case for require=false, where the file gets checked for existence.
 */
function load_class( $class_path, $require = true )
{
	if( ! $require )
	{
		global $inc_path;
		return file_exists( $inc_path.$class_path );
	}
	return true;
}


/*
 * $Log$
 * Revision 1.3  2009/03/06 00:11:27  blueyed
 * Abstract POFile handling to POFile class completely.
 *  - move gettext/pofile.class.php to blogs/inc/locales
 *  - use it in locales.ctrl
 * _global.php generation:
 *  - use double quotes only when necessary (msgid/msgstr containing e.g. \n),
 *    this speeds up reading the file a lot
 *  - add __meta__ key to trans array, used for versioning, so old files still
 *    get handled (and converted when being read)
 * Not tested for long in CVS HEAD, but works well in whissip for some time
 * already.
 *
 * Revision 1.2  2009/03/05 23:42:43  blueyed
 * Remove todo
 *
 * Revision 1.1  2009/03/05 23:38:53  blueyed
 * Merge autoload branch (lp:~blueyed/b2evolution/autoload) into CVS HEAD.
 *
 */
?>
