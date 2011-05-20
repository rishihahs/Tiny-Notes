<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<?php require 'database/Settings.php'; ?>
	<title><?php echo pagetitle; ?></title>
	<link rel="stylesheet" type="text/css" href="styles/main.css" />
</head>

<body>
<div id="wrapper">

	<?php
		require 'database/Database.php';
		
		// Define constants
		define (CREATE, 1);
		define (VIEW, 2);
		
		$database = new Database();
		
		// Write note to the database if exists
		if (isset($_POST['title'])) {
			$nid = $database->add($_POST['title'], $_POST['note']);
			echo '<a id="notelink" href="'. $_SERVER['PHP_SELF'] .'?do=view&note='. $nid .'">Your Note</a>';
			echo '<br />';
		}
		
		$op = CREATE;
		
		if (isset($_GET['do']) && strcasecmp($_GET['do'], 'create') == 0 || strcasecmp($_GET['do'], 'view') == 0) {
			$do = $_GET['do'];
			
			if (strcasecmp($do, 'create') == 0)
				$op = CREATE;
			else
				$op = VIEW;
		}
		
		// Render page depending on mode of operation
		switch ($op) {
			
			case CREATE:
				echo '<div id="create">';
				echo '<h2 class="heading">Create Note</h2>';
				echo '<form action="'. $_SERVER['PHP_SELF'] .'" method="post">';
				echo '<input type="text" name="title" />';
				echo '<br />';
				echo '<textarea rows="30" name="note"></textarea>';
				echo '<br />';
				echo '<input type="submit" value="Create" />';
				echo '</form>';
				echo '</div>';
				break;
				
			case VIEW:
				$nid = getNID();
				
				echo '<div id="view">';
				echo '<h2 class="heading">View Note</h2>';
				echo '<span id="date">'. $database->get($nid, Database::DATE) .'</span>';
				echo '<br />';
				echo '<p id="title">'. $database->get($nid, Database::TITLE) .'</p>';
				echo '<br />';
				echo '<p id="note">'. $database->get($nid, Database::NOTE) .'</p>';
				echo '</div>';
				break;
				
			default:
				echo '<p>TinyNotes</p>';
				break;
			
		}
		
		function getNID() {
			$nid;
			if (isset($_GET['note']))
				$nid = (int)$_GET['note'];
			else
				$nid = 1;
			
			return $nid;
		} 
		
	?>
	
</div>
</body>

</html>