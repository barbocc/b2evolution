<?php
/**
 * The Filemanager
 *
 * b2evolution - {@link http://b2evolution.net/}
 * Released under GNU GPL License - {@link http://b2evolution.net/about/license.html}
 * @copyright (c)2003-2004 by Francois PLANQUE - {@link http://fplanque.net/}
 *
 * @package admin
 */
 
// FP: this is to check if CVS works: Daniel please say hello below...
// DH: hello Francois! Nice to meet you in this file.. ;o)

require_once( dirname(__FILE__).'/_header.php' );
require( dirname(__FILE__).'/'.$admin_dirout.'/'.$core_subdir.'/_class_filemanager.php' );
$admin_tab = 'files';
$admin_pagetitle = T_('File Manager').' (beta)';

if( $current_User->level < 10 )
{
	die( 'this is beta. you need user level 10 to play with this.' );
}

param( 'cd', 'string', '' );         // the path relative to the root dir
param( 'action', 'string', '' );     // 3.. 2.. 1.. action :)
param( 'selaction', 'string', '' );  // action for selected files/dirs

param( 'file', 'string', '' );       // selected file
param( 'order', 'string', 'name' );
param( 'asc', 'integer', 1 );

$Fileman = new FileManager( $current_User, 'files.php', $cd, $order, $asc );

if( $action == '' && $file != '' )
{ // a file is selected/clicked, default action
	?>
	<html>
		<head>
		<title><?php echo $file.'&mdash;'.T_('b2evolution Filemanager') ?></title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<link href="<?php echo $admin_url ?>/admin.css" rel="stylesheet" type="text/css" />
		</head>

		<body onclick="javascript:window.close()" title="<?php echo T_('Click anywhere in this window to close it,') ?>">
		<div style="text-align:center;clear:both;margin-top:5ex;">
			<img style="border:1px dashed #d91;padding:1ex;" src="<?php $Fileman->cdisp_file( $file, 'url' ) ?>" <?php $Fileman->cdisp_file( $file, 'imgsize', 'string' ) ?>>
			<!--
			<br /><br />
			<a href="javascript:window.close()"><img class="center" src="<?php echo $admin_url.'/img/xross.gif' ?>" width="13" height="13" alt="[X]" title="<?php echo T_('Close this window') ?>" /></a>-->
		</div>

		</body>
	</html>
	<?php
	exit;
}


if( $selaction != '' )
{
	param( 'selectedfiles', 'array', array() );
	param( 'sel_recursive', 'array', array() );
	
	// map informations
	foreach( $selectedfiles as $nr => $name )
	{
		$withsubdirs[ $name ] = in_array( $name, $sel_recursive );
		
	}
	

	if( !count( $selectedfiles ) )
	{
		$Fileman->Messages->add( T_('Nothing selected.') );
	}
	else switch( $selaction )
	{
		case T_('Send by mail'):
			echo 'todo: Send selected by mail, query email address..';
			break;
		
		case T_('Download'):
			param( 'zipname', 'string', '' );
			param( 'recursesd', 'integer', 1 );
			
			if( empty($zipname) )
			{
				require( dirname(__FILE__).'/_menutop.php' );
				require( dirname(__FILE__).'/_menutop_end.php' );
				?>
				<div class="panelblock">
				<div class="panelinfo">
				<p>
				<?php
				echo T_('You want to download:').'<ul>';
				foreach( $selectedfiles as $file )
				{
					if( $Fileman->cisdir( $file ) )
					{
						printf('<li>'.T_('Directory [%s]'), $file).( $withsubdirs[$file] ? ' ('.T_('with subdirectories').')' : '').'</li>';
					}
					else printf('<li>'.T_('File [%s]'), $file).( $withsubdirs[$file] ? ' ('.T_('with subdirectories').')' : '').'</li>';
				}
				?>
				</p>
				</div>
				<form action="files.php" class="fform" method="post">
				<fieldset>
					<legend><?php echo T_('Please give a filename and choose zip format:') ?></legend>
					
					<?php
					foreach( $selectedfiles as $file )
					{?>
					<input type="hidden" name="selectedfiles[]" value="<?php echo format_to_output( $file, 'formvalue' ) ?>" />
					<?php
					}?>
					
					<input type="hidden" name="cd" value="<?php echo format_to_output( $cd, 'formvalue' ) ?>" />
					<input type="hidden" name="file" value="<?php echo format_to_output( $file, 'formvalue' ) ?>" />
					<?php
					form_text( 'zipname', '', 20, T_('Archive filename'), T_('This is the filename that will be send to you.') );
					form_checkbox( 'recursesb', $recursesd, T_('Recurse subdirectories'), T_('This will include subdirectories of directories.') );
					?>
					<div class="input"><input type="submit" name="selaction" value="<?php echo T_('Download') ?>" class="search" /></div>
				</fielset>
				</form>
				</div>
				<?php
				require( dirname(__FILE__). '/_footer.php' );
			}
			else
			{ // Downloading
				require( dirname(__FILE__).'/'.$admin_dirout.'/'.$core_subdir.'/_class_zip.php' );
				
				$flags[ 'recursesd' ] = $recursesd; // TODO: add a comment to archive?
					
				$zipfile = new zipfile($Fileman->cwd, $flags);
				$zipfile->addfiles( $Fileman->arraylist('files') );
				$zipfile->adddirectories( $Fileman->arraylist('dirs') );
				$zipfile->filedownload( $zipname );
				exit;
				#$Fileman->Messages->add( sprintf(T_('Zipfile [%s] sent to you!'), $selectedfiles[0]), 'note' );
				
			}
		
			break;
			
		case T_('Delete'):
			// TODO: extra confirmation?
			
			foreach( $selectedfiles as $file )
			{
				$Fileman->Messages->add( sprintf(T_('Would delete [%s]'), $file).( $withsubdirs[$file] ? ' ('.T_('with subdirectories').')' : '').'..', 'note' );
				
			}
			
			break;
	}
}
	


require( dirname(__FILE__).'/_menutop.php' );
echo T_('Current directory').': '.$Fileman->cwd;
require( dirname(__FILE__).'/_menutop_end.php' );
?>
<div class="panelblock">
<?php
	switch( $action ) // we catched empty action before
	{
		case 'createdir':
			param( 'createname', 'string', '' );
			if( $Fileman->createdir( $createname ) )
			{
				$Fileman->reloadpage();
			}
			break;
		
		case 'createfile':
			param( 'createname', 'string', '' );
			if( $Fileman->createfile( $createname ) )
			{
				$Fileman->reloadpage();
			}
			break;
		
		case 'delete':
			param( 'file', 'string', '' );
			
			if( $Fileman->delete( $file ) )
			{
				$Fileman->reloadpage();
			}
			
			break;
		case 'rename':
			param( 'file', 'string', '' );
			
			echo 'todo: Rename dialog..';
			break;
			
		case 'editperm':
			param( 'file', 'string', '' );
			param( 'chmod', 'string', '' );
			
			if( empty($chmod) )
			{
			?>
			<form action="files.php">
			<input type="hidden" name="cd" value="<?php echo format_to_output( $cd, 'formvalue' ) ?>" />
			<input type="hidden" name="file" value="<?php echo format_to_output( $file, 'formvalue' ) ?>" />
			<input type="text" name="chmod" value="<?php echo $Fileman->cget_file( $file, 'perms', 'octal' ) ?>" />
			<input type="submit" name="action" value="editperm" />
			</form>
			<?php
			}
			else
			{
				$oldperm = $Fileman->cget_file( $file, 'perms' );
				pre_dump( $Fileman->cdo_file( $file, 'chmod', $chmod ), 'chmod!');
			}
			
			break;
	}
	
	?>
	<div id="FilemanMain">
	<?php
	if( $Fileman->Messages->count( 'all' ) )
	{
		?>
		<div class="messages">
		<?php
	
		$Fileman->Messages->display( '', '', true, 'error' );
		$Fileman->Messages->display( '', '', true, 'note' );
		?>
		</div>
		<?php
	}
	?>
	<form action="files.php" name="search" class="toolbaritem">
		<input type="hidden" name="cd" value="<?php echo format_to_output( $cd, 'formvalue' ) ?>" />
		<input type="text" name="searchfor" value="" size="20" /> 
		<input type="submit" value="<?php echo format_to_output( T_('Search'), 'formvalue' ) ?>" />
	</form>
	
	<form action="files.php" name="createnew" class="toolbaritem">
		<input type="hidden" name="cd" value="<?php echo format_to_output( $cd, 'formvalue' ) ?>" />
		<select name="action">
			<option value="createfile"><?php echo T_('file') ?></option> 
			<option value="createdir"><?php echo T_('directory') ?></option> 
		</select>
		<input type="text" name="createname" value="" size="20" /> 
		<input type="submit" value="<?php echo format_to_output( T_('Create new'), 'formvalue' ) ?>" />
	</form>
	
	<form name="FilesForm" action="files.php">
	<table border="0" class="fileman">
	<tr class="toprow">
		<td colspan="2" class="icon">
			<a href="<?php $Fileman->cdisp('link', 'parent') ?>"><?php $Fileman->cdisp('iconimg', 'parent') ?></a>
			&nbsp;
			<a href="<?php $Fileman->cdisp('link', 'home') ?>"><?php $Fileman->cdisp('iconimg', 'home') ?></a>
			<br />
			<a href="#" onclick="toggleCheckboxes('FilesForm', 'selectedfiles[]');" title="<?php echo T_('(un)selects all checkboxes using Javascript') ?>">
				<span id="checkallspan_0"><?php echo T_('(un)check all')?></span>
			</a>
		</td>
		<td colspan="8" class="right">
			<strong><?php echo T_('with selected files:') ?> </strong>
			<input type="hidden" name="cd" value="<?php echo format_to_output( $cd, 'formvalue' ) ?>" />
			<input class="toolbar" type="submit" name="selaction" value="<?php echo T_('Delete') ?>" onclick="return confirm('<?php echo /* This is a Javascript string! */ T_('Do you really want to delete the selected files?') ?>')" />
			<input class="toolbar" type="submit" name="selaction" value="<?php echo T_('Download') ?>" />
			<input class="toolbar" type="submit" name="selaction" value="<?php echo T_('Send by mail') ?>" />
		</td>
	</tr>
	
	<tr>
		<th></th>
		<th></th>
		<th>
		<?php	echo $Fileman->sortlink( 'type', '<a href="%s">'. /* TRANS: file type */ T_('Type').'</a>' ) ?></th>
		<th><?php echo /* TRANS: file name */ T_('Name') ?></th>
		<th><?php echo /* TRANS: file size */ T_('Size') ?></th>
		<th><?php echo /* TRANS: file's last change / timestamp */ T_('Last change') ?></th>
		<th><?php echo /* TRANS: file's permissions */ T_('Perms') ?></th>
		<th><?php echo /* TRANS: file action, (html) view */ T_('Action') ?></th>
	</tr>
	
	<?php
	$i = 0;
	while( $Fileman->next() )
	{
		$i++;
		
		$link_default_js = 'window.open(\''.$Fileman->cget('link')."', 'fileman_default', 'toolbar=0,resizable=yes,";
		if( $r = $Fileman->cget('imgsize', 'widthheight') )
		{
			$link_default_js .= 'width='.($r[0]+100).',height='.($r[1]+100);
		}
		$link_default_js .= "')";
		
		?>
		<tr onmouseout="this.style.background='#fff'" onmouseover="this.style.background='#ddd'" onclick="document.getElementsByName('selectedfiles[]')[<?php echo $i-1 ?>].click();">
			<td class="checkbox">
				<input title="<?php echo T_('select this file') ?>" type="checkbox" name="selectedfiles[]" value="<?php echo format_to_output( $Fileman->cdisp('name'), 'formvalue' ) ?>" onclick="document.getElementsByName('selectedfiles[]')[<?php echo $i-1 ?>].click();" />
			</td>
			<td class="icon" onclick="window.location.href = '<?php $Fileman->cdisp('link') ?>'">
				<?php /*echo $i++;*/ $Fileman->cdisp('iconimg') ?>
			</td>
			<td class="type"><?php $Fileman->cdisp('type') ?></td>
			<td class="filename" onclick="<?php echo $link_default_js ?>">
				<a href="<?php $Fileman->cdisp('link') ?>">
					<?php	$Fileman->cdisp('name'); $Fileman->cdisp('imgsize', '', ' (%s)') ?>
				</a>
			</td>
			<td class="size"><?php $Fileman->cdisp('nicesize') ?></td>
			<td class="timestamp"><?php $Fileman->cdisp('lastmod') ?></td>
			<td class="perms"><?php $Fileman->cdisp( 'link_editperm', '', '<a href="%s">'.$Fileman->cget('perms', 'octal').'</a>' ) ?></td>
			<td class="actions">
				<?php	$Fileman->cdisp( 'link_edit', '', '<a href="%s">['./* TRANS: edit file */ T_('Edit').']</a>' ); ?>
				<?php $Fileman->cdisp( 'link_copymove', '', '<a href="%s">['./* TRANS: file copy/move */ T_('Copy / Move').']</a>' ); ?>
				<?php $Fileman->cdisp( 'link_rename', '', '<a href="%s">['./* TRANS: file rename */ T_('Rename').']</a>' ); ?>
				<?php	$Fileman->cdisp( 'link_delete', '', '<a href="%s">['./* TRANS: delete file */ T_('Delete').']</a>'
																							.($Fileman->cisdir() == 'dir' ? ' <input title="'.T_('include sub-directories for selected-files action.').'" class="checkbox" type="checkbox" name="sel_recursive[]" value="'.format_to_output( $Fileman->cget('name'), 'formvalue' ).'" />' : '') ); ?>
				<?php
					// TODO: action link
				?>
			</td>
		</tr>
		<?php
	}
	if( $i == 0 )
	{ // empty directory
		?>
		<tr>
		<td colspan="8" class="left">
		<?php echo T_('The directory is empty.') ?>
		</td>
		</tr>
		<?php
	}
	?>
	</table>
	</form>
	</div>
</div>
<?php
require( dirname(__FILE__). '/_footer.php' );
?>
