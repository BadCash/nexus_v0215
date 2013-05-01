	
	<p>
		<?php foreach($treeNavLinks as $val):?>
			/ <a href="<?=$val['href'];?>"> <?=$val['text'];?> </a>
		<?php endforeach;?>
	</p>
	
	<p>
		<ul class="filelist">
			<?php foreach($filesAndFolderLinks as $val):?>
				<li class="<?=$val['type'];?>"><a href="<?=$val['href'];?>"> <?=$val['text'];?> </a></li>
			<?php endforeach;?>
		</ul>
	</p>
	
	<?php if( !empty($fileInfo) ): ?>
		<p>
			<fieldset class="filecontents">
				<legend><a href="<?=$fileInfo['href'];?>"><?=$fileInfo['filename'];?></a></legend>
				<div><pre><?=$fileInfo['content']; ?></pre></div>
			</fieldset>
		</p>
	<?php endif; ?>