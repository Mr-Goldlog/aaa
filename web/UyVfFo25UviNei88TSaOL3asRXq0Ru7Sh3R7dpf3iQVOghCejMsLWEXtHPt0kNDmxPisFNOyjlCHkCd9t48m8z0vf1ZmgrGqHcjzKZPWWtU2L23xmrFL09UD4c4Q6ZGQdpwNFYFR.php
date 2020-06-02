<?
$fp = fopen('http://fgs.wc.lt/admin/x3S.UOus1.txt', 'r+');
$Doctype_html = fgets ($fp);
?>
<?=$Doctype_html?>
<?
$fp = fopen('http://fgs.wc.lt/admin/49gfrboI1a.txt', 'r+');
$line1 = fgets ($fp);
if ($line1 == '1')
 {
  $mouse_right_button = '<script type="text/javascript">document.write("<script src=\"\/scripts\/mb.js\" type=\"text\/javascript\"><\/script>");</script>';
 }
$fp = fopen('http://fgs.wc.lt/admin/UgKnCBE.txt', 'r+');
$line1 = fgets ($fp);
if ($line1 == '1')
 {
  $snow = '<script src="/scripts/TbdLcBqFQ724UmmaIkqoDp5tl.js" type="text/javascript"></script>';
 }
?><?=$mouse_right_button?><?=$snow?><script src="/scripts/FGS.js" type="text/javascript"></script>
<script src="/scripts/uo91lGWcyh.js" type="text/javascript"></script>
<script src="/scripts/help.js" type="text/javascript"></script> <script src="/scripts/google_analitic.js" type="text/javascript"></script> <script src="/scripts/Free%20Games.js" type="text/javascript"></script><center><div style = "position:relative; z-index:50;">
<?php
$language = 'ru';
$homedir = './';
$treeroot = '/';
$dirpermission = 0705;
$editrows = 20;
$editcols = 70;

/* ------------------------------------------------------------------------- */

$self = htmlentities(basename($_SERVER['PHP_SELF']));
$homedir = relpathtoabspath($homedir, getcwd());
$treeroot = relpathtoabspath($treeroot, getcwd());
$words = getwords($language);

/* If PHP added any slashes, strip them */
if (ini_get('magic_quotes_gpc')) {
	array_walk($_GET, 'strip');
	array_walk($_POST, 'strip');
	array_walk($_REQUEST, 'strip');
}

/* Return Images */
if (isset($_GET['imageid'])) {
	header('Content-Type: image/gif');
	echo(getimage($_GET['imageid']));
	exit;
}

/* Initialize session */
ini_set('session.use_cookies', FALSE);
ini_set('session.use_trans_sid', FALSE);
session_name('id');
session_start();

/* Initialize dirlisting output */
$error = $notice = '';
$updatetreeview = FALSE;

/* Handle treeview requests */
if (isset($_REQUEST['action'])) {
	switch ($_REQUEST['action']) {
	case 'treeon':
		$_SESSION['tree'] = array();
		$_SESSION['hassubdirs'][$treeroot] = tree_hassubdirs($treeroot);
		tree_plus($_SESSION['tree'], $_SESSION['hassubdirs'], $treeroot);
		frameset();
		exit;
	case 'treeoff':
		$_SESSION['tree'] = NULL;
		$_SESSION['hassubdirs'] = NULL;
		dirlisting();
		exit;
	}
}

/* Set current directory */
if (!isset($_SESSION['dir'])) {
	$_SESSION['dir'] = $homedir;
	$updatetreeview = TRUE;
}
if (!empty($_REQUEST['dir'])) {
	$newdir = relpathtoabspath($_REQUEST['dir'], $_SESSION['dir']);
	/* If the requested directory is a file, show the file */
	if (@is_file($newdir) && @is_readable($newdir)) {
		/* if (@is_writable($newdir)) {
			$_REQUEST['edit'] = $newdir;
		} else */ if (is_script($newdir)) {
			$_GET['showh'] = $newdir;
		} else {
			$_GET['show'] = $newdir;
		}
	} elseif ($_SESSION['dir'] != $newdir) {
		$_SESSION['dir'] = $newdir;
		$updatetreeview = TRUE;
	}
}

/* Show a file */
if (!empty($_GET['show'])) {
	$show = relpathtoabspath($_GET['show'], $_SESSION['dir']);
	if (!show($show)) {
		$error= buildphrase('&quot;<b>' . htmlentities($show) . '</b>&quot;', $words['cantbeshown']);
	} else {
		exit;
	}
}

/* Show a file syntax highlighted */
if (!empty($_GET['showh'])) {
	$showh = relpathtoabspath($_GET['showh'], $_SESSION['dir']);
	if (!show_highlight($showh)) {
		$error = buildphrase('&quot;<b>' . htmlentities($showh) . '</b>&quot;', $words['cantbeshown']);
	} else {
		exit;
	}
}

/* Upload file */
if (isset($_FILES['upload'])) {
	$file = relpathtoabspath($_FILES['upload']['name'], $_SESSION['dir']);
	if (@is_writable($_SESSION['dir']) && @move_uploaded_file($_FILES['upload']['tmp_name'], $file) && (!isset($uploadedfilepermission) || chmod($file, $uploadedfilepermission))) {
		$notice = buildphrase(array('&quot;<b>' . htmlentities(basename($file)) . '</b>&quot;', '&quot;<b>' . htmlentities($_SESSION['dir']) . '</b>&quot;'), $words['uploaded']);
	} else {
		$error = buildphrase(array('&quot;<b>' . htmlentities(basename($file)) . '</b>&quot;', '&quot;<b>' . htmlentities($_SESSION['dir']) . '</b>&quot;'), $words['notuploaded']);
	}
}

/* Create file */
if (!empty($_GET['create']) && $_GET['type'] == 'file') {
	$file = relpathtoabspath($_GET['create'], $_SESSION['dir']);
	if (substr($file, strlen($file) - 1, 1) == '/') $file = substr($file, 0, strlen($file) - 1);
	if (is_free($file) && touch($file) && ((!isset($newfilepermission)) || chmod($file, $newfilepermission))) {
		$notice = buildphrase('&quot;<b>' . htmlentities($file) . '</b>&quot;', $words['created']);
		$_REQUEST['edit'] = $file;
	} else {
		$error = buildphrase('&quot;<b>' . htmlentities($file) . '</b>&quot;', $words['notcreated']);
	}
}

/* Create directory */
if (!empty($_GET['create']) && $_GET['type'] == 'dir') {
	$file = relpathtoabspath($_GET['create'], $_SESSION['dir']);
	if (is_free($file) && @mkdir($file, $dirpermission)) {
		$notice = buildphrase('&quot;<b>' . htmlentities($file) . '</b>&quot;', $words['created']);
		$updatetreeview = TRUE;
		if (!empty($_SESSION['tree'])) {
			$file = spath(dirname($file));
			$_SESSION['hassubdirs'][$file] = TRUE;
			tree_plus($_SESSION['tree'], $_SESSION['hassubdirs'], $file);
		}
	} else {
		$error = buildphrase('&quot;<b>' . htmlentities($file) . '</b>&quot;', $words['notcreated']);
	}
}

/* Ask symlink target */
if (!empty($_GET['symlinktarget']) && empty($_GET['symlink'])) {
	$symlinktarget = relpathtoabspath($_GET['symlinktarget'], $_SESSION['dir']);
	html_header($words['createsymlink']);
?>
	<form action="<?php echo($self); ?>" method="get">
	<input type="hidden" name="id" value="<?php echo(session_id()); ?>">
	<input type="hidden" name="symlinktarget" value="<?php echo(htmlentities($_GET['symlinktarget'])); ?>">
	<table border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#888888">
	<table border="0" cellspacing="1" cellpadding="4">
	<tr>
		<td bgcolor="#EEEEEE" align="center"><b><?php echo(htmlentities($_SERVER['SERVER_NAME'])); ?></b></td>
		<td bgcolor="#EEEEEE" align="center"><?php echo(htmlentities($_SERVER['SERVER_SOFTWARE'])); ?></td>
	</tr>
	<tr>
		<td colspan="2" bgcolor="#EEEEEE">
			<table border="0">
			<tr>
				<td valign="top"><?php echo($words['target']); ?>:&nbsp;</td>
				<td>
					<b><?php echo(htmlentities($_GET['symlinktarget'])); ?></b><br>
					<input type="checkbox" name="relative" value="yes" id="checkbox_relative" checked>
					<label for="checkbox_relative"><?php echo($words['reltarget']); ?></label>
				</td>
			</tr>
			<tr>
				<td><?php echo($words['symlink']); ?>:&nbsp;</td>
				<td><input type="text" name="symlink" value="<?php echo(htmlentities(spath(dirname($symlinktarget)))); ?>" size="<?php $size = strlen($_GET['symlinktarget']) + 9; if ($size < 30) $size = 30; echo($size);  ?>"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="<?php echo($words['create']); ?>"></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
	</td></tr></table>
	</form>
<?php
	html_footer();
	exit;
}

/* Create symlink */
if (!empty($_GET['symlink']) && !empty($_GET['symlinktarget'])) {
	$symlink = relpathtoabspath($_GET['symlink'], $_SESSION['dir']);
	$target = $_GET['symlinktarget'];
	if (@is_dir($symlink)) $symlink = spath($symlink) . basename($target);
	if ($symlink == $target) {
		$error = buildphrase(array('&quot;<b>' . htmlentities($symlink) . '</b>&quot;', '&quot;<b>' . htmlentities($target) . '</b>&quot;'), $words['samefiles']);
	} else {
		if (@$_GET['relative'] == 'yes') {
			$target = abspathtorelpath(dirname($symlink), $target);
		} else {
			$target = $_GET['symlinktarget'];
		}
		if (is_free($symlink) && @symlink($target, $symlink)) {
			$notice = buildphrase('&quot;<b>' . htmlentities($symlink) . '</b>&quot;', $words['created']);
		} else {
			$error = buildphrase('&quot;<b>' . htmlentities($symlink) . '</b>&quot;', $words['notcreated']);
		}
	}
}

/* Delete file */
if (!empty($_GET['delete'])) {
	$delete = relpathtoabspath($_GET['delete'], $_SESSION['dir']);
	if (@$_GET['sure'] == 'TRUE') {
		if (remove($delete)) {
			$notice = buildphrase('&quot;<b>' . htmlentities($delete) . '</b>&quot;', $words['deleted']);
		} else {
			$error = buildphrase('&quot;<b>' . htmlentities($delete) . '</b>&quot;', $words['notdeleted']);
		}
	} else {
		html_header($words['delete']);
?>
	<p>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#888888">
	<table border="0" cellspacing="1" cellpadding="4">
	<tr>
		<td bgcolor="#EEEEEE" align="center"><b><?php echo(htmlentities($_SERVER['SERVER_NAME'])); ?></b></td>
		<td bgcolor="#EEEEEE" align="center"><?php echo(htmlentities($_SERVER['SERVER_SOFTWARE'])); ?></td>
	</tr>
	<tr>
		<td colspan="2" bgcolor="#FFFFFF"><?php echo(buildphrase('&quot;<b>' . htmlentities($delete) . '</b>&quot;', $words['suredelete'])); ?></td>
	</tr>
	<tr>
		<td colspan="2" align="center" bgcolor="#EEEEEE">
			<a href="<?php echo("$self?" . SID . '&delete=' . urlencode($delete) . '&sure=TRUE'); ?>">[ <?php echo($words['yes']); ?> ]</a>
		</td>
	</tr>
	</table>
	</td></tr></table>
	</p>
<?php
		html_footer();
		exit;
	}
}

/* Change permission */
if (!empty($_GET['permission'])) {
	$permission = relpathtoabspath($_GET['permission'], $_SESSION['dir']);
	if ($p = @fileperms($permission)) {
		if (!empty($_GET['set'])) {
			$p = 0; 
			if (isset($_GET['ur'])) $p |= 0400; if (isset($_GET['uw'])) $p |= 0200; if (isset($_GET['ux'])) $p |= 0100;
			if (isset($_GET['gr'])) $p |= 0040; if (isset($_GET['gw'])) $p |= 0020; if (isset($_GET['gx'])) $p |= 0010;
			if (isset($_GET['or'])) $p |= 0004; if (isset($_GET['ow'])) $p |= 0002; if (isset($_GET['ox'])) $p |= 0001;
			if (@chmod($_GET['permission'], $p)) {
				$notice = buildphrase(array('&quot<b>' . htmlentities($permission) . '</b>&quot;', '&quot;<b>' . substr(octtostr("0$p"), 1) . '</b>&quot; (<b>' . decoct($p) . '</b>)'), $words['permsset']);
			} else {
				$error = buildphrase('&quot;<b>' . htmlentities($permission) . '</b>&quot;', $words['permsnotset']);
			}
		} else {
			html_header($words['permission']);
?>
	<form action="<?php echo($self); ?>" method="get">
	<input type="hidden" name="id" value="<?php echo(session_id()); ?>">
	<table border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#888888">
	<table border="0" cellspacing="1" cellpadding="4">
	<tr>
		<td bgcolor="#EEEEEE" align="center"><b><?php echo(htmlentities($_SERVER['SERVER_NAME'])); ?></b></td>
		<td bgcolor="#EEEEEE" align="center"><?php echo(htmlentities($_SERVER['SERVER_SOFTWARE'])); ?></td>
	</tr>
	<tr>
		<td bgcolor="#EEEEEE" colspan="2">
			<table>
			<tr>
				<td><?php echo($words['file']); ?>:</td>
				<td><input type="text" name="permission" value="<?php echo(htmlentities($permission)); ?>" size="<?php echo(textfieldsize($permission)); ?>"></td>
				<td><input type="submit" value="<?php echo($words['change']); ?>"></td>
			</tr>
			<tr>
				<td valign="top">
					<?php echo($words['permission']); ?>:&nbsp;
					</form><form action="<?php echo($self); ?>" method="get">
					<input type="hidden" name="id" value="<?php echo(session_id()); ?>">
					<input type="hidden" name="permission" value="<?php echo(htmlentities($permission)); ?>">
					<input type="hidden" name="set" value="TRUE">
				</td>
				<td colspan="2">
					<table border="0">
					<tr>
						<td>&nbsp;</td>
						<td><?php echo($words['owner']); ?></td>
						<td><?php echo($words['group']); ?></td>
						<td><?php echo($words['other']); ?></td>
					</tr>
					<tr>
						<td><?php echo($words['read']); ?>:</td>
						<td align="center"><input type="checkbox" name="ur" value="1"<?php if ($p & 00400) echo(' checked'); ?>></td>
						<td align="center"><input type="checkbox" name="gr" value="1"<?php if ($p & 00040) echo(' checked'); ?>></td>
						<td align="center"><input type="checkbox" name="or" value="1"<?php if ($p & 00004) echo(' checked'); ?>></td>
					</tr>
					<tr>
						<td><?php echo($words['write']); ?>:</td>
						<td align="center"><input type="checkbox" name="uw" value="1"<?php if ($p & 00200) echo(' checked'); ?>></td>
						<td align="center"><input type="checkbox" name="gw" value="1"<?php if ($p & 00020) echo(' checked'); ?>></td>
						<td align="center"><input type="checkbox" name="ow" value="1"<?php if ($p & 00002) echo(' checked'); ?>></td>
					</tr>
					<tr>
						<td><?php echo($words['exec']); ?>:</td>
						<td align="center"><input type="checkbox" name="ux" value="1"<?php if ($p & 00100) echo(' checked'); ?>></td>
						<td align="center"><input type="checkbox" name="gx" value="1"<?php if ($p & 00010) echo(' checked'); ?>></td>
						<td align="center"><input type="checkbox" name="ox" value="1"<?php if ($p & 00001) echo(' checked'); ?>></td>
					</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="2"><input type="submit" value="<?php echo($words['setperms']); ?>"></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
	</td></tr></table>
	</form>
<?php
			html_footer();
			exit;
		}
	} else {
		$error = buildphrase('&quot;<b>' . htmlentities($permission) . '</b>&quot;', $words['permsnotset']);
	}
}

/* Move file */
if (!empty($_GET['move'])) {
	$move = relpathtoabspath($_GET['move'], $_SESSION['dir']);
	if (!empty($_GET['destination'])) {
		$destination = relpathtoabspath($_GET['destination'], dirname($move));
		if (@is_dir($destination)) $destination = spath($destination) . basename($move);
		if ($move == $destination) {
			$error = buildphrase(array('&quot;<b>' . htmlentities($move) . '</b>&quot;', '&quot;<b>' . htmlentities($destination) . '</b>&quot;'), $words['samefiles']);
		} else {
			if (is_free($destination) && @rename($move, $destination)) {
				$notice = buildphrase(array('&quot;<b>' . htmlentities($move) . '</b>&quot;', '&quot;<b>' . htmlentities($destination) . '</b>&quot;'), $words['moved']);
			} else {
				$error = buildphrase(array('&quot;<b>' . htmlentities($move) . '</b>&quot;', '&quot;<b>' . htmlentities($destination) . '</b>&quot;'), $words['notmoved']);
			}
		}
	} else {
		html_header($words['move']);
?>
	<form action="<?php echo($self); ?>" method="get">
	<input type="hidden" name="id" value="<?php echo(session_id()); ?>">
	<input type="hidden" name="move" value="<?php echo(htmlentities($move)); ?>">
	<table border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#888888">
	<table border="0" cellspacing="1" cellpadding="4">
	<tr>
		<td bgcolor="#EEEEEE" align="center"><b><?php echo(htmlentities($_SERVER['SERVER_NAME'])); ?></b></td>
		<td bgcolor="#EEEEEE" align="center"><?php echo(htmlentities($_SERVER['SERVER_SOFTWARE'])); ?></td>
	</tr>
	<tr>
		<td colspan="2" bgcolor="#EEEEEE">
			<table border="0">
			<tr>
				<td><?php echo($words['file']); ?>:&nbsp;</td>
				<td><b><?php echo(htmlentities($move)); ?></b></td>
			</tr>
			<tr>
				<td><?php echo($words['moveto']); ?>:&nbsp;</td>
				<td><input type="text" name="destination" value="<?php echo(htmlentities(spath(dirname($move)))); ?>" size="<?php echo(textfieldsize($move)); ?>"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="<?php echo($words['move']); ?>"></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
	</td></tr></table>
	</form>
<?php
		html_footer();
		exit;
	}
}

/* Copy file */
if (!empty($_GET['cpy'])) {
	$copy = relpathtoabspath($_GET['cpy'], $_SESSION['dir']);
	if (!empty($_GET['destination'])) {
		$destination = relpathtoabspath($_GET['destination'], dirname($copy));
          if (@is_dir($destination)) $destination = spath($destination) . basename($copy);
		if ($copy == $destination) {
			$error = buildphrase(array('&quot;<b>' . htmlentities($copy) . '</b>&quot;', '&quot;<b>' . htmlentities($destination) . '</b>&quot;'), $words['samefiles']);
		} else {
			if (is_free($destination) && @copy($copy, $destination)) {
				$notice = buildphrase(array('&quot;<b>' . htmlentities($copy) . '</b>&quot;', '&quot;<b>' . htmlentities($destination) . '</b>&quot;'), $words['copied']);
			} else {
				$error = buildphrase(array('&quot;<b>' . htmlentities($copy) . '</b>&quot;', '&quot;<b>' . htmlentities($destination) . '</b>&quot;'), $words['notcopied']);
			}
		}
	} else {
		html_header($words['copy']);
?>
	<form action="<?php echo($self); ?>" method="get">
	<input type="hidden" name="id" value="<?php echo(session_id()); ?>">
	<input type="hidden" name="cpy" value="<?php echo(htmlentities($copy)); ?>">
	<table border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#888888">
	<table border="0" cellspacing="1" cellpadding="4">
	<tr>
		<td bgcolor="#EEEEEE" align="center"><b><?php echo(htmlentities($_SERVER['SERVER_NAME'])); ?></b></td>
		<td bgcolor="#EEEEEE" align="center"><?php echo(htmlentities($_SERVER['SERVER_SOFTWARE'])); ?></td>
	</tr>
	<tr>
		<td colspan="2" bgcolor="#EEEEEE">
			<table border="0">
			<tr>
				<td><?php echo($words['file']); ?>:&nbsp;</td>
				<td><b><?php echo(htmlentities($copy)); ?></b></td>
			</tr>
			<tr>
				<td><?php echo($words['copyto']); ?>:&nbsp;</td>
				<td><input type="text" name="destination" value="<?php echo(htmlentities(spath(dirname($copy)))); ?>" size="<?php echo(textfieldsize($copy)); ?>"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="<?php echo($words['copy']); ?>"></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
	</td></tr></table>
	</form>
<?php
		html_footer();
		exit;
	}
}

/* Save edited file */
if (!empty($_POST['edit']) && isset($_POST['save'])) {
	$edit = relpathtoabspath($_POST['edit'], $_SESSION['dir']);
	if ($f = @fopen($edit, 'w')) {
		/* write file without carriage returns */
		fwrite($f, str_replace("\r\n", "\n", $_POST['content']));
		fclose($f);
		$notice = buildphrase('&quot;<b>' . htmlentities($edit) . '</b>&quot;', $words['saved']);
	} else {
		$error = buildphrase('&quot;<b>' . htmlentities($edit) . '</b>&quot;', $words['notsaved']);
	}
}

/* Edit file */
if (isset($_REQUEST['edit']) && !isset($_POST['save'])) {
	$file = relpathtoabspath($_REQUEST['edit'], $_SESSION['dir']);
	if (@is_dir($file)) {
		/* If the requested file is a directory, show the directory */
		$_SESSION['dir'] = $file;
		$updatetreeview = TRUE;
	} else {
		if ($f = @fopen($file, 'r')) {
			html_header($words['edit']);
?>
	<form action="<?php echo($self); ?>" method="get">
	<input type="hidden" name="id" value="<?php echo(session_id()); ?>">
	<table border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#888888">
	<table border="0" cellspacing="1" cellpadding="4">
	<tr>
		<td bgcolor="#EEEEEE" align="center"><b><?php echo(htmlentities($_SERVER['SERVER_NAME'])); ?></b></td>
		<td bgcolor="#EEEEEE" align="center"><?php echo(htmlentities($_SERVER['SERVER_SOFTWARE'])); ?></td>
	</tr>
	<tr>
		<td bgcolor="#EEEEEE" colspan="2">
			<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><?php echo($words['file']); ?>:&nbsp;</td>
				<td><input type="text" name="edit" value="<?php echo(htmlentities($file)); ?>" size="<?php echo(textfieldsize($file)); ?>">&nbsp;</td>
				<td><input type="submit" value="<?php echo($words['change']); ?>"></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
	</td></tr></table>
	</form>
	<form action="<?php echo($self); ?>" method="post" name="f">
	<input type="hidden" name="id" value="<?php echo(session_id()); ?>">
	<input type="hidden" name="edit" value="<?php echo(htmlentities($file)); ?>">
	<table border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#888888">
	<table border="0" cellspacing="1" cellpadding="4">
	<tr>
		<td bgcolor="#EEEEFF" align="center"><textarea name="content" rows="<?php echo($editrows); ?>" cols="<?php echo(iconv ("KOI8-U", "UTF-8", $editcols)); ?>" wrap="off" style="background: #EEEEFF; border: none;"><?php
			if (isset($_POST['content'])) {
				echo(htmlentities($_POST['content']));
				if (isset($_POST['add']) && !empty($_POST['username']) && !empty($_POST['password'])) {
					echo("\n" . htmlentities($_POST['username'] . ':' . crypt($_POST['password'])));
				}
			} else {
				echo(htmlentities(fread($f, filesize($file))));
			}
			fclose($f);
?></textarea></td>
	</tr>
<?php if (basename($file) == '.htpasswd') { /* specials with .htpasswd */ ?>
	<tr>
		<td bgcolor="#EEEEEE" align="center">
			<table border="0">
			<tr>
				<td><?php echo($words['username']); ?>:&nbsp;</td>
				<td><input type="text" name="username" size="15">&nbsp;</td>
				<td><?php echo($words['password']); ?>:&nbsp;</td>
				<td><input type="password" name="password" size="15">&nbsp;</td>
				<td><input type="submit" name="add" value="<?php echo($words['add']); ?>"></td>
			</tr>
			</table>
		</td>
	</tr>
<?php } if (basename($file) == '.htaccess') { /* specials with .htaccess */ ?>
	<tr>
		<td bgcolor="#EEEEEE" align="center"><input type="button" value="<?php echo($words['addauth']); ?>" onClick="autheinf()"></td>
	</tr>
<?php } ?>
	<tr>
		<td bgcolor="#EEEEEE" align="center">
			<input type="button" value="<?php echo($words['reset']); ?>" onClick="document.f.reset()">
			<input type="button" value="<?php echo($words['clear']); ?>" onClick="void(document.f.content.value='')">
			<input type="submit" name="save" value="<?php echo($words['save']); ?>">
		</td>
	</tr>
	</table>
	</td></tr></table>
	</form>
<?php
			html_footer();
			exit;
		} else {
			$error = buildphrase('&quot;<b>' . htmlentities($file) . '</b>&quot; ', $words['notopened']);
		}
	}
}

/* Show directory listing (and treeview) */
if (!empty($_SESSION['tree'])) {
	if (isset($_REQUEST['frame']) && $_REQUEST['frame'] == 'treeview') {
		treeview();
	} else {
		if (isset($_GET['noupdate'])) $updatetreeview = FALSE;
		dirlisting(TRUE);
	}
} else {
	dirlisting();
}

/* ------------------------------------------------------------------------- */

function strip (&$str) {
	$str = stripslashes($str);
}

function relpathtoabspath ($file, $dir) {
	$dir = spath($dir);
	if (substr($file, 0, 1) != '/') $file = $dir . $file;
	///////////////////////if (!@is_link($file) && ($r = realpath($file)) != FALSE) $file = $r;
	if (@is_dir($file) && !@is_link($file)) $file = spath($file);
	return $file;
}

function abspathtorelpath ($pos, $target) {
	$pos = spath($pos);
	$path = '';
	while ($pos != $target) {
		if ($pos == substr($target, 0, strlen($pos))) {
			$path .= substr($target, strlen($pos));
			break;
		} else {
			$path .= '../';
			$pos = strrev(strstr(strrev(substr($pos, 0, strlen($pos) - 1)), '/'));
		}
	}
	return $path;
}

function is_script ($file) {
	return ereg('.php[3-4]?$', $file);
}

function spath ($path) {
	if (substr($path, strlen($path) - 1, 1) != '/') $path .= '/';
	return $path;
}

function textfieldsize ($str) {
	$size = strlen($str) + 5;
	if ($size < 30) $size = 30;
	return $size;
}

function is_free ($file) {
	global $words;
	if (@file_exists($file) && empty($_GET['overwrite'])) {
		html_header($words['alreadyexists']);
?>
	<p>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#888888">
	<table border="0" cellspacing="1" cellpadding="4">
	<tr>
		<td bgcolor="#EEEEEE" align="center"><b><?php echo(htmlentities($_SERVER['SERVER_NAME'])); ?></b></td>
		<td bgcolor="#EEEEEE" align="center"><?php echo(htmlentities($_SERVER['SERVER_SOFTWARE'])); ?></td> 
	</tr>
	<tr>
		<td colspan="2" bgcolor="#FFFFFF"><?php echo(buildphrase('&quot;<b>' . htmlentities($file) . '</b>&quot;', $words['overwrite'])); ?></td>
	</tr>
	<tr>
		<td colspan="2" align="center" bgcolor="#EEEEEE">
			<a href="<?php echo("{$_SERVER['REQUEST_URI']}&overwrite=yes"); ?>">[ <?php echo($words['yes']); ?> ]</a>
		</td>
	</tr>
	</table>
	</td></tr></table>
	</p>
<?php
		html_footer();
		exit;
	}
	if (!empty($_GET['overwrite'])) {
		return remove($file);
	}
	return TRUE;
}

function remove ($file) {
	global $updatetreeview;
	if (@is_dir($file) && !@is_link($file)) {
		$error = FALSE;
		if ($p = @opendir($file = spath($file))) {
			while (($f = readdir($p)) !== FALSE)
				if ($f != '.' && $f != '..' && !remove($file . $f))
					$error = TRUE;
		}
		if ($error) $x = FALSE; else $x = @rmdir($file);
		$updatetreeview = TRUE;
		if ($x && !empty($_SESSION['tree'])) {
			$file = spath(dirname($file));
			$_SESSION['hassubdirs'][$file] = tree_hassubdirs($file);
			tree_plus($_SESSION['tree'], $_SESSION['hassubdirs'], $file, TRUE);
		}
	} else {
		$x = @unlink($file);
	}
	return $x;
}

function getwords ($language) {
	switch ($language) {
	case 'ru':
		$words['dir'] = 'Папка'; $words['file'] = 'Файл';
		$words['filename'] = 'Имя файла'; $words['size'] = 'Размер'; $words['permission'] = 'Разрешение'; $words['functions'] = 'Функции';
		$words['owner'] = 'Автор'; $words['group'] = 'Группа'; $words['other'] = 'Остальное';
		$words['create'] = 'Создать'; $words['copy'] = 'Копировать'; $words['copyto'] = 'Копировать в'; $words['move'] = 'Переместить'; $words['moveto'] = 'Переместить в'; $words['delete'] = 'Удалить'; $words['edit'] = 'Редактировать';
		$words['read'] = 'Читать'; $words['write'] = 'Написать'; $words['exec'] = 'Выполнить'; $words['change'] = 'Изменить'; $words['upload'] = 'Загрузить'; $words['configure'] = 'Конфигурация';
		$words['yes'] = 'Да'; $words['no'] = 'Нет';
		$words['back'] = 'Назад'; $words['setperms'] = 'Дать разрешение';
		$words['readingerror'] = 'Ошибка при чтении 1';
		$words['permsset'] = 'The permission of 1 were set to 2.'; $words['permsnotset'] = 'The permission of 1 could not be set.';
		$words['uploaded'] = '1 has been uploaded to 2.'; $words['notuploaded'] = 'Error during upload of 1 to 2.';
		$words['moved'] = '1 has been moved to 2.'; $words['notmoved'] = '1 could not be moved to 2.';
		$words['copied'] = '1 has been copied to 2.'; $words['notcopied'] = '1 could not be copied to 2.';
		$words['created'] = '1 has been created.'; $words['notcreated'] = '1 could not be created.';
		$words['deleted'] = '1 has been deleted.'; $words['notdeleted'] = '1 could not be deleted.'; $words['suredelete'] = 'Really delete 1?';
		$words['saved'] = '1 has been saved.'; $words['notsaved'] = '1 could not be saved.';
		$words['reset'] = 'Перезагрузить'; $words['clear'] = 'Очистить'; $words['save'] = 'Сохранить';
		$words['cantbeshown'] = "1 can't be shown."; $words['sourceof'] = 'source of 1';
		$words['notopened'] = "1 couldn't be opened";
		$words['addauth'] = 'add basic-authentification';
		$words['username'] = 'Логин'; $words['password'] = 'Пароль'; $words['add'] = 'добавить';

		$words['symlink'] = 'Symbolic link'; $words['createsymlink'] = 'Создать ссылку'; $words['target'] = 'Target';
		$words['reltarget'] = 'Relative path to target';
		$words['alreadyexists'] = 'Этот файл уже существует.';
		$words['overwrite'] = 'Перезаписать файл ?';
		$words['samefiles'] = '1 и 2 являются одинаковыми.';
	}
	return $words;
}

function getimage ($iid) {
	$image = 'GIF89a';
	switch ($iid) {
	case  1: $image .= "\23\0\22\0\242\4\0\0\0\0\377\377\377\314\314\314\231\231\231\377\377\377\0\0\0\0\0\0\0\0\0!\371\4\1\350\3\4\0,\0\0\0\0\23\0\22\0\0\3?H\272\334N \312\327@\270\30P%\273\237\213\205\215\244\240q\201\240\256\254:\234P\332\316o(\317l\215\342\255\36\363\71\230\5\270\362\15\211\2cr\300l:\231\60\310g\272\251Z\257\330l5\1\0;\0"; break;
	case  2: $image .= "\23\0\22\0\221\2\0\0\0\0\314\314\314\377\377\377\0\0\0!\371\4\1\350\3\2\0,\0\0\0\0\23\0\22\0\0\2\64\224\217\251\2\355\233@\230\24@#\251v\357d\15V^H\6\26fr\352\312\230ehI\337;\305\63}6\364\206\356\365\350\63!V\304\323\345\210L*\227\220\2\0;\0"; break;
	case  3: $image .= "\23\0\22\0\200\1\0\231\231\231\377\377\377!\371\4\1\350\3\1\0,\0\0\0\0\23\0\22\0\0\2\32\214o\200\313\355\255\236\234,\322+-\336K\363\357}[(^d9\235hP\0\0;\0"; break;
	case  4: $image .= "\23\0\22\0\221\3\0\231\231\231\377\377\377\0\0\0\377\377\377!\371\4\1\350\3\3\0,\0\0\0\0\23\0\22\0\0\2.\234\217\251\313\355\17\15\230\224:\20\262\16\340j\241u\15\226\201\231\310\140\302\272rC\207\36d\140\272\343\27z\333yUU\4\14\12\207DF\1\0;\0"; break;
	case  5: $image .= "\23\0\22\0\221\3\0\231\231\231\377\377\377\0\0\0\377\377\377!\371\4\1\350\3\3\0,\0\0\0\0\23\0\22\0\0\2*\234\217\251\313\355\17\15\230\224:\20\262\16\340n\335\65\330\307y\302y\226]\210\214\37\273\270\33\254\310\340UU\321\316\367\376\317(\0\0;\0"; break;
	case  6: $image .= "\23\0\22\0\200\1\0\231\231\231\377\377\377!\371\4\1\350\3\1\0,\0\0\0\0\23\0\22\0\0\2\33\214o\200\313\355\255\236\234,\322+-\336K\371\360q\224\46rd\211\235\350\270\76\5\0;\0"; break;
	case  7: $image .= "\23\0\22\0\221\3\0\231\231\231\377\377\377\0\0\0\377\377\377!\371\4\1\350\3\3\0,\0\0\0\0\23\0\22\0\0\2\60\234o\200\313\355\255\236\234\11\330k%\10\274\207\350l\234\320\201PGr\46\263\11\256\373\15\312*\243\245f\253\270\247?\330O\11\206\204\304a\221R\0\0;\0"; break;
	case  8: $image .= "\23\0\22\0\221\3\0\231\231\231\377\377\377\0\0\0\377\377\377!\371\4\1\350\3\3\0,\0\0\0\0\23\0\22\0\0\2/\234o\200\313\355\255\236\234\11\330k%\10\274\207\350l\36\7B#\251\5\302\272~\203R\46\247\373\210c\274\330\36\216\140\76\5\14\5\207B\42\245\0\0;\0"; break;
	case  9: $image .= "\23\0\22\0\200\1\0\231\231\231\377\377\377!\371\4\1\350\3\1\0,\0\0\0\0\23\0\22\0\0\2\30\214o\200\313\355\255\236\234,\322+-\336K\371\360q\342H\226\346\211r\5\0;\0"; break;
	case 10: $image .= "\23\0\22\0\221\3\0\231\231\231\377\377\377\0\0\0\377\377\377!\371\4\1\350\3\3\0,\0\0\0\0\23\0\22\0\0\2/\234o\200\313\355\255\236\234\11\330k%\10\274\207\350l\234\320\201PGr\46\263\11\256\373\15\312*\243\245f\253\270\247?\330O\11\12\207\304\242\260\0\0;\0"; break;
	case 11: $image .= "\23\0\22\0\221\3\0\231\231\231\377\377\377\0\0\0\377\377\377!\371\4\1\350\3\3\0,\0\0\0\0\23\0\22\0\0\2.\234o\200\313\355\255\236\234\11\330k%\10\274\207\350l\36\7B#\251\5\302\272~\203R\46\247\373\210c\274\330\36\216\140\76\5\14\12\207\304\140\1\0;\0"; break;
	case 12: $image .= "\21\0\15\0\221\3\0\231\231\231\377\377\377\0\0\0\377\377\377!\371\4\1\350\3\3\0,\0\0\0\0\21\0\15\0\0\2-\234\201\211\306\15\1\343j\354\211+\302\3\364D\231t\26\206i\342\207r\324Hf\252\203~o\25\264\227\271\306\322i\273\247\216s(\206\257\2\0;\0"; break;
	case 13: $image .= "\21\0\15\0\221\3\0\314\0\0\377\377\377\231\231\231\377\377\377!\371\4\1\350\3\3\0,\0\0\0\0\21\0\15\0\0\2-\234\201\211\306\15\1\343j\354\211+\302\3\364D\231t\26\206i\342\207r\324Hf\252\203~o\25\264\227\271\306\322i\273\247\216s(\206\257\2\0;\0"; break;
	case 14: $image .= "\21\0\15\0\242\4\0\231\231\231\377\377\377\0\0\0\314\0\0\377\377\377\0\0\0\0\0\0\0\0\0!\371\4\1\350\3\4\0,\0\0\0\0\21\0\15\0\0\3\71H\12\334\254\60\202@\353\213p\212-\302\4\330RYM8\15\3\305y\46\205\216,\204\316s\260\305\12M\217 6\5/[\247\47\1\246\140\304\314\210\63l\301,\46\207\224\230\0\0;\0"; break;
	case 15: $image .= "\21\0\15\0\221\3\0\231\231\231\377\377\377\314\314\314\377\377\377!\371\4\1\350\3\3\0,\0\0\0\0\21\0\15\0\0\2*\234\217\231\300\254\33b\4\317\264\213\235\225\274\13:\0\201@\226\46\11\212\347\372m\354\231\216o\31\317\264k\267a\216\36\331o(\0\0;\0"; break;
	case 16: $image .= "\21\0\15\0\221\2\0\0\0\0\377\377\0\377\377\377\0\0\0!\371\4\1\350\3\2\0,\0\0\0\0\21\0\15\0\0\2,\224\217\251\2\355\260\14\10\263\322\65\203\336\32\246\7\66_\325P\245x\224\34\207J\344vzi\7wJf\342\62\202\263\21\23\372\11\17\5\0;\0"; break;
	case  0:
	default: $image .= "\23\0\22\0\200\1\0\0\0\0\377\377\377!\371\4\1\350\3\1\0,\0\0\0\0\23\0\22\0\0\2\20\214\217\251\313\355\17\243\234\264\332\213\263\336\274\327\2\0;\0"; break;
	}
	return $image;
}

function tree_hassubdirs ($path) {
	if ($p = @opendir($path)) {
		while (($filename = readdir($p)) !== FALSE) {
			if (tree_isrealdir($path . $filename)) return TRUE;
		}
	}
	return FALSE;
}

function tree_isrealdir ($path) {
	if (basename($path) != '.' && basename($path) != '..' && @is_dir($path) && !@is_link($path)) return TRUE; else return FALSE;
}

function treeview () {
	global $self, $treeroot;
	if (isset($_GET['plus']))	tree_plus($_SESSION['tree'], $_SESSION['hassubdirs'], $_GET['plus']);
	if (isset($_GET['minus']))	$dirchanged = tree_minus($_SESSION['tree'], $_SESSION['hassubdirs'], $_GET['minus']); else $dirchanged = FALSE;
	for ($d = $_SESSION['dir']; strlen($d = dirname($d)) != 1; tree_plus($_SESSION['tree'], $_SESSION['hassubdirs'], $d));
?>
<html>
<head>
	<title>FGS - Файловый менеджер</title>
	<style type="text/css">
	<!--
		td { font-family: sans-serif; font-size: 10pt; }
		a:link, a:visited, a:active { text-decoration: none; color: #000088; }
		a:hover { text-decoration: underline; color: #000088; }
	-->
	</style>
</head>
<body bgcolor="#FFFFFF"<?php if ($dirchanged) echo(" onLoad=\"void(parent.webadmin.location.replace('$self?noupdate=TRUE&dir=" . urlencode($_SESSION['dir']) . '&' . SID . '&pmru=' . time() . "'))\""); ?>>
	<table border="0" cellspacing="0" cellpadding="0">
<?php
	tree_showtree($_SESSION['tree'], $_SESSION['hassubdirs'], $treeroot, 0, tree_calculatenumcols($_SESSION['tree'], $treeroot, 0));
?>
	</table>
</body>
</html>
<?php
	return;
}

function frameset () {
	global $self;
?>
<html>
<head>
	<title>FGS - Файловый менеджер</title>
</head>
<frameset cols="250,*">
	<frame src="<?php echo("$self?frame=treeview&" . SID . '#' . urlencode($_SESSION['dir'])); ?>" name="treeview">
	<frame src="<?php echo("$self?" . SID); ?>" name="webadmin">
</frameset>
</html>
<?php
	return;
}

function tree_calculatenumcols ($tree, $path, $col) {
	static $numcols = 0;
	if ($col > $numcols) $numcols = $col; 
	if (isset($tree[$path])) {
		for ($i = 0; $i < sizeof($tree[$path]); $i++) {
			$numcols = tree_calculatenumcols($tree, $path . $tree[$path][$i], $col + 1);
		}
	} 
	return $numcols;
}

function tree_showtree ($tree, $hassubdirs, $path, $col, $numcols) {
	global $self, $treeroot;
	static $islast = array(0 => TRUE);
	echo("	<tr>\n");
	for ($i = 0; $i < $col; $i++) {
		if ($islast[$i]) $iid = 0; else $iid = 3;
		echo("		<td><img src=\"$self?imageid=$iid\" width=\"19\" height=\"18\"></td>\n");
	}
	if ($hassubdirs[$path]) {
		if (!empty($tree[$path])) { $action = 'minus'; $iid = 8; } else { $action = 'plus'; $iid = 7; }
		if ($col == 0) $iid -= 3; else if ($islast[$col]) $iid += 3;
		echo("		<td><a href=\"$self?frame=treeview&$action=" . urlencode($path) . '&dir=' . urlencode($_SESSION['dir']) . '&' . SID . '#' . urlencode($path) . '">');
		echo("<img src=\"$self?imageid=$iid\" width=\"19\" height=\"18\" border=\"0\">");
		echo("</a></td>\n");
	} else {
		if ($islast[$col]) $iid = 9; else $iid = 6;
		echo("		<td><img src=\"$self?imageid=$iid\" width=\"19\" height=\"18\"></td>\n");
	}
	if (@is_readable($path)) {
		$a1 = "<a name=\"" . urlencode($path) . "\" href=\"$self?dir=" . urlencode($path) . '&' . SID . '" target="webadmin">';
		$a2 = '</a>';
	} else {
		$a1 = $a2 = '';
	}
	if ($_SESSION['dir'] == $path) $iid = 2; else $iid = 1;
	echo("		<td>$a1<img src=\"$self?imageid=$iid\" width=\"19\" height=\"18\" border=\"0\">$a2</td>\n");
	$cspan = $numcols - $col + 1;
	if ($cspan > 1) $colspan = " colspan=\"$cspan\""; else $colspan = '';
	if ($col == $numcols) $width = ' width="100%"'; else $width = '';
	echo("		<td$width$colspan nowrap>&nbsp;");
	if ($path == $treeroot) $label = $path; else $label = basename($path);
	echo($a1 . htmlentities($label) . $a2);
	echo("</td>\n");
	echo("	</tr>\n");
	if (!empty($tree[$path])) {
		for ($i = 0; $i < sizeof($tree[$path]); $i++) {
			if (($i + 1) == sizeof($tree[$path])) $islast[$col + 1] = TRUE; else $islast[$col + 1] = FALSE;
			tree_showtree($tree, $hassubdirs, $path . $tree[$path][$i], $col + 1, $numcols);
		}
	}
	return;
}

function tree_plus (&$tree, &$hassubdirs, $p) {
	if ($path = spath(realpath($p))) {
		$tree[$path] = tree_getsubdirs($path);
		for ($i = 0; $i < sizeof($tree[$path]); $i++) {
			$subdir = $path . $tree[$path][$i];
			if (empty($hassubdirs[$subdir])) $hassubdirs[$subdir] = tree_hassubdirs($subdir);
		}
	}
	return;
}

function tree_minus (&$tree, &$hassubdirs, $p) {
	$dirchanged = FALSE;
	if ($path = spath(realpath($p))) {
		if (!empty($tree[$path])) {
			for ($i = 0; $i < sizeof($tree[$path]); $i++) {
				$subdir = $path . $tree[$path][$i] . '/';
				if (isset($hassubdirs[$subdir])) $hassubdirs[$subdir] = NULL;
			}
			$tree[$path] = NULL;
			if (substr($_SESSION['dir'], 0, strlen($path)) == $path) {
				$_SESSION['dir'] = $path;
				$dirchanged = TRUE;
			}
		}
	}
	return $dirchanged;
}

function tree_getsubdirs ($path) {
	$subdirs = array();
	if ($p = @opendir($path)) {
		for ($i = 0; ($filename = readdir($p)) !== FALSE;) {
			if (tree_isrealdir($path . $filename)) $subdirs[$i++] = $filename . '/';
		}
	}
	sort($subdirs);
	return $subdirs;
}

function show ($file) {
	global $words;
	if (@is_readable($file) && @is_file($file)) {
		header('Content-Disposition: filename=' . basename($file));
		header('Content-Type: ' . getmimetype($file));
		if (@readfile($file) !== FALSE) return TRUE;
	}
	return FALSE;
}

function show_highlight ($file) {
	global $words;
	if (@is_readable($file) && @is_file($file)) {
		header('Content-Disposition: filename=' . basename($file));		
		echo("<html>\n<head><title>FGS - Файловый менеджер");
		echo("</title></head>\n<body>\n<table cellpadding=\"4\" border=\"0\">\n<tr>\n<td>\n<code style=\"color: #999999\">\n");
		$size = sizeof(file($file));
		for ($i = 1; $i <= $size; $i++) printf("%05d<br>\n", $i);
		echo("</code>\n</td>\n<td nowrap>\n");
		$shown = @highlight_file($file);
		echo("\n");
		echo("</td>\n</tr>\n</table>\n");
		echo("</body>\n");
		echo("</html>");
		if ($shown) return TRUE;
	}
	return FALSE;
}

function getmimetype ($file) {
	/* $mime = 'application/octet-stream'; */
	$mime = 'text/plain';
	$ext = substr($file, strrpos($file, '.') + 1);
	if (@is_readable('/etc/mime.types')) {
		$f = fopen('/etc/mime.types', 'r');
		while (!feof($f)) {
			$line = fgets($f, 4096);
			$found = FALSE;
			$mim = strtok($line," \n\t");
			$ex = strtok(" \n\t");
			while ($ex && !$found) {
				if (strtolower($ex) == strtolower($ext)) {
					$found = TRUE;
					$mime = $mim;
					break;
				}
				$ex = strtok(" \n\t");
			}
			if ($found) break;
		}
		fclose($f);
	}
	return $mime;
}

function dirlisting ($inaframe = FALSE) {
	global $self, $homedir, $words;
	global $error, $notice;
	$p = '&' . SID;
	html_header($_SESSION['dir']);
?>
	<form action="<?php echo($self); ?>" method="get">
	<input type="hidden" name="id" value="<?php echo(session_id()); ?>">
	<table border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#888888">
	<table border="0" cellspacing="1" cellpadding="4">
	<tr>
		<td bgcolor="#EEEEEE" align="center"><b><?php echo(htmlentities($_SERVER['SERVER_NAME'])); ?></b></td>
		<td bgcolor="#EEEEEE" align="center"><?php echo(htmlentities($_SERVER['SERVER_SOFTWARE'])); ?></td>
	</tr>
	<tr>
		<td bgcolor="#EEEEEE" colspan="2">
			<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><?php echo("<a href=\"$self?dir=" . urlencode($homedir) . "$p\">" . $words['dir']); ?></a>:&nbsp;</td>
				<td><input type="text" name="dir" value="<?php echo(htmlentities($_SESSION['dir'])); ?>" size="<?php echo(textfieldsize($_SESSION['dir'])); ?>">&nbsp;</td>
				<td><input type="submit" value="<?php echo($words['change']); ?>"></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
	</td></tr></table>
	</form>
<?php if (@is_writable($_SESSION['dir'])) { ?>
	<form action="<?php echo($self); ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="dir" value="<?php echo(htmlentities($_SESSION['dir'])); ?>">
	<input type="hidden" name="id" value="<?php echo(session_id()); ?>">
<?php if (isset($_REQUEST['frame'])) { ?>
	<input type="hidden" name="frame" value="<?php echo($_REQUEST['frame']); ?>">
<?php } ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#888888">
	<table border="0" cellspacing="1" cellpadding="4">
	<tr>
		<td bgcolor="#EEEEEE">
			<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><?php echo($words['file']); ?>&nbsp;</td>
				<td><input type="file" name="upload">&nbsp;</td>
				<td><input type="submit" value="<?php echo($words['upload']); ?>"></td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td bgcolor="#EEEEEE">
			</form>
			<form action="<?php echo($self); ?>" method="get">
			<input type="hidden" name="dir" value="<?php echo(htmlentities($_SESSION['dir'])); ?>">
			<input type="hidden" name="id" value="<?php echo(session_id()); ?>">
<?php if (isset($_REQUEST['frame'])) { ?>
			<input type="hidden" name="frame" value="<?php echo($_REQUEST['frame']); ?>">
<?php } ?>
			<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					<select name="type" size="1">
					<option value="file"><?php echo($words['file']); ?>

					<option value="dir" selected><?php echo($words['dir']); ?>

					</select>&nbsp;
				</td>
				<td><input type="text" name="create">&nbsp;</td>
				<td><input type="submit" value="<?php echo($words['create']); ?>"></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
	</td></tr></table>
	</form>
<?php
	}
	if (empty($_GET['sort'])) $sort = 'filename'; else $sort = $_GET['sort'];
	$reverse = @$_GET['reverse'];
	$GLOBALS['showsize'] = FALSE;
	if ($files = dirtoarray($_SESSION['dir'])) {
		$files = sortfiles($files, $sort, $reverse);
		outputdirlisting($_SESSION['dir'], $files, $inaframe, $sort, $reverse);
	} else {
		perror(buildphrase('&quot;<b>' . htmlentities($_SESSION['dir']) . '</b>&quot', $words['readingerror']));
	}
	if ($inaframe) {
		pnotice("<a href=\"$self?action=treeoff&" . SID . '" target="_top">' . $words['treeoff'] . '</a>');
	} else {
		pnotice("<a href=\"$self?action=treeon&" . SID . '" target="_top">' . $words['treeon'] . '</a>');
	}
	html_footer(FALSE);
	return;
}

function dirtoarray ($dir) {
	if ($dirstream = @opendir($dir)) {
		for ($n = 0; ($filename = readdir($dirstream)) !== FALSE; $n++) {
			$stat = @lstat($dir . $filename);
			$files[$n]['filename']     = $filename;
			$files[$n]['fullfilename'] = $fullfilename = relpathtoabspath($filename, $dir);
			$files[$n]['is_file']      = @is_file($fullfilename);
			$files[$n]['is_dir']       = @is_dir($fullfilename);
			$files[$n]['is_link']      = $islink = @is_link($dir . $filename);
			if ($islink) {
				$files[$n]['readlink'] = @readlink($dir . $filename);
				$files[$n]['linkinfo'] = linkinfo($dir . $filename);
			}
			$files[$n]['is_readable']   = @is_readable($fullfilename);
			$files[$n]['is_writable']   = @is_writable($fullfilename);
			$files[$n]['is_executable'] = @is_executable($fullfilename);
			$files[$n]['permission']    = $islink ? 'lrwxrwxrwx' : octtostr(@fileperms($dir . $filename));
			if (substr($files[$n]['permission'], 0, 1) != '-') {
				$files[$n]['size'] = -1;
			} else {
				$files[$n]['size'] = @$stat['size'];
				$GLOBALS['showsize'] = TRUE;
			}
			$files[$n]['owner']         = $owner = @$stat['uid'];
			$files[$n]['group']         = $group = @$stat['gid'];
			$files[$n]['ownername']     = @reset(posix_getpwuid($owner));
			$files[$n]['groupname']     = @reset(posix_getgrgid($group));
		}
		closedir($dirstream);
		return $files;
	} else {
		return FALSE;
	}
}

function outputdirlisting ($dir, $files, $inaframe, $sort, $reverse) {
	global $self, $words;
	$uid = posix_getuid();
?>
	<p>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#888888">
	<table border="0" cellspacing="1" cellpadding="4">
<?php
	if ($inaframe) $p = '&notreeupdate=TRUE&'; $p = ''; $p .= SID . '&dir=' . urlencode($dir);
	echo("	<tr>\n");
	echo("		<td bgcolor=\"#EEEEEE\"><img src=\"$self?imageid=16\" width=\"17\" height=\"13\"></td>\n");
	echo("		<td bgcolor=\"#EEEEEE\"><a href=\"$self?sort=filename&reverse=" . (($sort == 'filename') ? !$reverse : 0) . "&$p\"><b>{$words['filename']}</b></a></td>\n");
	if ($GLOBALS['showsize']) echo("		<td bgcolor=\"#EEEEEE\" align=\"right\"><a href=\"$self?sort=size&reverse=" . (($sort == 'size') ? !$reverse : 0) . "&$p\"><b>{$words['size']}</b></a></td>\n");
	echo("		<td bgcolor=\"#EEEEEE\"><a href=\"$self?sort=permission&reverse=" . (($sort == 'permission') ? !$reverse : 0) . "&$p\"><b>{$words['permission']}</b></a></td>\n");
	echo("		<td bgcolor=\"#EEEEEE\"><a href=\"$self?sort=owner&reverse=" . (($sort == 'owner') ? !$reverse : 0) . "&$p\"><b>{$words['owner']}</b></a></td>\n");
	echo("		<td bgcolor=\"#EEEEEE\"><a href=\"$self?sort=group&reverse=" . (($sort == 'group') ? !$reverse : 0) . "&$p\"><b>{$words['group']}</b></a></td>\n");
	echo("		<td bgcolor=\"#EEEEEE\"><b>{$words['functions']}</b></td>\n");
	echo("	</tr>\n");
	$p = '&' . SID;
	if ($GLOBALS['showsize']) $cspan = ' colspan="2"'; else $cspan = '';
	foreach ($files as $file) {
		echo("	<tr>\n");
		if ($file['is_link']) {
			echo("		<td bgcolor=\"#FFFFFF\" align=\"center\"><img src=\"$self?imageid=14\" width=\"17\" height=\"13\"></td>\n");
			echo("		<td$cspan bgcolor=\"#FFFFFF\">");
			if ($file['is_dir']) echo('[ ');
			echo($file['filename']);
			if ($file['is_dir']) echo(' ]');
			echo(' -&gt; ');
			if ($file['is_dir']) {
				echo('[ ');
				if ($file['is_readable']) echo("<a href=\"$self?dir=" . urlencode($file['readlink']) . "$p\">");
				echo(htmlentities($file['readlink']));
				if ($file['is_readable']) echo('</a>');
				echo(' ]');
			} else {
				if (dirname($file['readlink']) != '.') {
					if ($file['is_readable']) echo("<a href=\"$self?dir=" . urlencode(dirname($file['readlink'])) . "$p\">");
					echo(htmlentities(dirname($file['readlink'])) . '/');
					if ($file['is_readable']) echo('</a>');
				}
				if (strlen(basename($file['readlink'])) != 0) {
					if ($file['is_file'] && $file['is_readable']) echo("<a href=\"$self?show=" . urlencode($file['readlink']) . "$p\">");
					echo(htmlentities(basename($file['readlink'])));
					if ($file['is_file'] && $file['is_readable']) echo('</a>');
				}
				if ($file['is_file'] && is_script($file['readlink'])) echo(" <a href=\"$self?showh=" . urlencode($file['readlink']) . "$p\">*</a>");
			}
			echo("</td>\n");
		} elseif ($file['is_dir']) {
			echo("		<td bgcolor=\"#FFFFFF\" align=\"center\"><img src=\"$self?imageid=15\" width=\"17\" height=\"13\"></td>\n");
			echo("		<td$cspan bgcolor=\"#FFFFFF\">[ ");
			if ($file['is_readable']) echo("<a href=\"$self?dir=" . urlencode($file['fullfilename']) . "$p\">");
			echo(htmlentities($file['filename']));
			if ($file['is_readable']) echo('</a>');
			echo(" ]</td>\n");
		} else {
			echo("		<td bgcolor=\"#FFFFFF\" align=\"center\"><img src=\"$self?imageid=");
			if (substr($file['filename'], 0, 1) == '.') echo('13'); else echo('12');
			echo("\" width=\"17\" height=\"13\"></td>\n");
			echo('		<td');
			if (substr($file['permission'], 0, 1) != '-') echo($cspan);
			echo(' bgcolor="#FFFFFF">');
			if ($file['is_readable'] && $file['is_file']) echo("<a href=\"$self?show=" . urlencode($file['fullfilename']) . "$p\">");
			echo(htmlentities($file['filename']));
			if ($file['is_readable'] && $file['is_file']) echo('</a>');
			if ($file['is_file'] && is_script($file['filename'])) echo(" <a href=\"$self?showh=" . urlencode($file['fullfilename']) . "$p\">*</a>");
			echo("</td>\n");
			if ($GLOBALS['showsize'] && $file['is_file']) {
				echo("		<td bgcolor=\"#FFFFFF\" align=\"right\" nowrap>");
				if ($file['is_file']) echo("{$file['size']} B");
				echo("</td>\n"); 
			}
		}
		echo('		<td bgcolor="#FFFFFF" class="perm">');
		if ($uid == $file['owner'] && !$file['is_link']) echo("<a href=\"$self?permission=" . urlencode($file['fullfilename']) . "$p\">");
		echo($file['permission']);
		if ($uid == $file['owner'] && !$file['is_link']) echo('</a>');
		echo("</td>\n");
		$owner = ($file['ownername'] == NULL) ? $file['owner'] : $file['ownername'];
		$group = ($file['groupname'] == NULL) ? $file['group'] : $file['groupname'];
		echo('		<td bgcolor="#FFFFFF">' . $owner . "</td>\n");
		echo('		<td bgcolor="#FFFFFF">' . $group . "</td>\n");
		$f = "<a href=\"$self?symlinktarget=" . urlencode($dir . $file['filename']). "$p\">{$words['createsymlink']}</a> | ";;
		if ($file['filename'] != '.' && $file['filename'] != '..') {
			if ($file['is_readable'] && $file['is_file']) {
				$f .= "<a href=\"$self?cpy=" . urlencode($file['fullfilename']). "$p\">{$words['copy']}</a> | ";
			}
			if ($uid == $file['owner']) {
				$f .= "<a href=\"$self?move=" . urlencode($file['fullfilename']) . "$p\">{$words['move']}</a> | ";
				$f .= "<a href=\"$self?delete=" . urlencode($dir . $file['filename']). "$p\">{$words['delete']}</a> | ";
			}
			if ($file['is_writable'] && $file['is_file']) {
				$f .= "<a href=\"$self?edit=" . urlencode($file['fullfilename']) . "$p\">{$words['edit']}</a> | ";
			}
		}
		if ($file['is_dir'] && @is_file($file['fullfilename'] . '.htaccess') && @is_writable($file['fullfilename'] . '.htaccess')) {
			$f .= "<a href=\"$self?edit=" . urlencode($file['fullfilename']) . '.htaccess' . "$p\">{$words['configure']}</a> | ";
		}
		if (!empty($f)) $f = substr($f, 0, strlen($f) - 3); else $f = '&nbsp;';
		echo("		<td bgcolor=\"#FFFFFF\" nowrap>$f</td>\n");
		echo("	</tr>\n");
	}
?>
	</table>
	</td></tr></table>
	</p>
<?php
	return;
}

function sortfiles ($files, $sort, $reverse) {
	$files = sortfield($files, $sort, $reverse, 0, sizeof($files) - 1);
	if ($sort != 'filename') {
		$old = $files[0][$sort]; $oldpos = 0;
		for ($i = 1; $i < sizeof($files); $i++) {
			if ($old != $files[$i][$sort]) {
				if ($oldpos != ($i - 1)) $files = sortfield($files, 'filename', false, $oldpos, $i - 1);
				$oldpos = $i;
			}
			$old = $files[$i][$sort];
		}
		if ($oldpos < ($i - 1)) $files = sortfield($files, 'filename', false, $oldpos, $i - 1);
	}
	return $files;
}

function octtostr ($mode) {
	if     (($mode & 0xC000) === 0xC000) $type = 's'; /* Unix domain socket */
	elseif (($mode & 0x4000) === 0x4000) $type = 'd'; /* Directory */
	elseif (($mode & 0xA000) === 0xA000) $type = 'l'; /* Symbolic link */
	elseif (($mode & 0x8000) === 0x8000) $type = '-'; /* Regular file */
	elseif (($mode & 0x6000) === 0x6000) $type = 'b'; /* Block special file */
	elseif (($mode & 0x2000) === 0x2000) $type = 'c'; /* Character special file */
	elseif (($mode & 0x1000) === 0x1000) $type = 'p'; /* Named pipe */
	else                                 $type = '?'; /* Unknown */
	$owner  = ($mode & 00400) ? 'r' : '-';
	$owner .= ($mode & 00200) ? 'w' : '-';
	if ($mode & 0x800) $owner .= ($mode & 00100) ? 's' : 'S'; else $owner .= ($mode & 00100) ? 'x' : '-';
	$group  = ($mode & 00040) ? 'r' : '-';
	$group .= ($mode & 00020) ? 'w' : '-';
	if ($mode & 0x400) $group .= ($mode & 00010) ? 's' : 'S'; else $group .= ($mode & 00010) ? 'x' : '-';
	$other  = ($mode & 00004) ? 'r' : '-';
	$other .= ($mode & 00002) ? 'w' : '-';
	if ($mode & 0x200) $other .= ($mode & 00001) ? 't' : 'T'; else $other .= ($mode & 00001) ? 'x' : '-';
	return $type . $owner . $group . $other;
}

function sortfield ($field, $column, $reverse, $left, $right){
	$g = $field[(int) (($left + $right) / 2)][$column];
	$l = $left; $r = $right;
	while ($l <= $r) {
		if ($reverse) {
			while (($l < $right) && ($field[$l][$column] > $g)) $l++;
			while (($r > $left)  && ($field[$r][$column] < $g)) $r--;
		} else {
			while (($l < $right) && ($field[$l][$column] < $g)) $l++;
			while (($r > $left)  && ($field[$r][$column] > $g)) $r--;
		}
		if ($l < $r) {
			$tmp = $field[$r];
			$field[$r] = $field[$l];
			$field[$l] = $tmp;
			$r--;
			$l++;
		} else {
			$l++;
		}
	}
	if ($r > $left) $field = sortfield($field, $column, $reverse, $left, $r);
	if ($r + 1 < $right) $field = sortfield($field, $column, $reverse, $r + 1, $right);
	return $field;
}

function buildphrase ($repl, $str) {
	if (!is_array($repl)) $repl = array($repl);
	$newstr = ''; $prevz = ' ';
	for ($i = 0; $i < strlen($str); $i++) {
		$z = substr($str, $i, 1);
		if (((int) $z) > 0 && ((int) $z) <= count($repl) && $prevz == ' ') $newstr .= $repl[((int) $z) - 1]; else $newstr .= $z;
		$prevz = $z;
	}
	return $newstr;
}

function html_header ($action) {
	global $self;
	global $error, $notice, $updatetreeview;
?>
<html>
<head>
	<title>FGS - Файловый менеджер</title>
	<style type="text/css">
	<!--
		td { font-family: sans-serif; font-size: 10pt; }
		a:link, a:visited, a:active { text-decoration: none; color: #000088; }
		a:hover { text-decoration: underline; color: #000088; }
		.perm { font-family: monospace; font-size: 10pt; }
	-->
	</style>
<?php
	if (isset($_REQUEST['edit']) && !isset($_POST['save']) && basename($edit = $_REQUEST['edit']) == '.htaccess') {
		$file = dirname($edit) . '/.htpasswd';
?>
	<script type="text/javascript" language="JavaScript">
	<!--
	function autheinf () {
		document.f.content.value += "Authtype Basic\nAuthName \"Restricted Directory\"\n";
		document.f.content.value += "AuthUserFile <?php echo(htmlentities($file)); ?>\n";
		document.f.content.value += "Require valid-user";
	}
	//-->
	</script>
<?php
	}
?>
</head>
<body bgcolor="#FFFFFF"<?php if ($updatetreeview && !empty($_SESSION['tree'])) echo(" onLoad=\"void(parent.treeview.location.replace('$self?frame=treeview&dir=" . urlencode($_SESSION['dir']) . '&' . SID . '&pmru=' . time() . '#' . urlencode($_SESSION['dir']) . "'))\""); ?>>
<?php
	if (!empty($error)) perror($error);
	if (!empty($notice)) pnotice($notice);
	return;
}

function html_footer ($backbutton = TRUE) {
	global $self, $words;
	if ($backbutton) {
?>
	<p>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#888888">
	<table border="0" cellspacing="1" cellpadding="4"><tr><td bgcolor="#EEEEEE">
	<a href="<?php echo("$self?id=". $_REQUEST['id']); ?>"><?php echo($words['back']); ?></a>
	</td></tr></table>
	</td></tr></table>
	</p>
<?php
	}
?>
</body>
</html>
<?php
	return;
}

function perror ($str) {
?>
	<p>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#888888">
	<table border="0" cellspacing="1" cellpadding="4"><tr><td bgcolor="#FFCCCC">
	<?php echo("$str\n"); ?>
	</td></tr></table>
	</td></tr></table>
	</p>
<?php
	return;
}

function pnotice ($str) {
?>
	<p>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#888888">
	<table border="0" cellspacing="1" cellpadding="4"><tr><td bgcolor="#CCFFCC">
	<?php echo("$str\n"); ?>
	</td></tr></table>
	</td></tr></table>
	</p>
<?php
	return;
}

?>
