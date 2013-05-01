<!DOCTYPE html>
<html lang='en'> 
<head>
  <meta charset='utf-8'/>
  <title><?=$title?></title>
	<link rel='shortcut icon' href='<?=$favicon?>'/>
  <link rel='stylesheet' href='<?=$stylesheet?>'/>
</head>
<body>
		<div id="page">

			<header>
				<div id="logo">
					MAWI13
				</div>
				
				<div id="menu">
					<a href="<?php echo CNexus::Instance()->request->base_url; ?>me/hem">Om mig</a> &nbsp;
					<a href="<?php echo CNexus::Instance()->request->base_url; ?>me/redovisning">Redovisning</a> &nbsp;
					<a href="<?php echo CNexus::Instance()->request->base_url; ?>">Nexus (MVC-ramverk)</a> &nbsp;
					<a href="<?php echo CNexus::Instance()->request->base_url; ?>source/display">Källkod</a>
				</div>
			</header>
			
			<div id="pagecontent">
					<div id='main' role='main'>
					  <?=get_messages_from_session()?>
					  <?=@$main?>
					  <?=render_views()?>
					</div>
	  </div>
  </div>
  <footer>
	  <?=$footer?>
	  <div id='debug'>
		<?=get_debug()?>
	  </div>
  </footer>
</body>
</html>