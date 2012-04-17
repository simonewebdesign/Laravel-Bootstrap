<?=View::make('site.inc.meta')->render()?>
  	<? if($page): ?>
		<title><?=$page->title." &lt; ".$page->meta_title?></title>
		<meta name="description" content="<?=$page->meta_description?>" />
		<meta name="keywords" content="<?=$page->meta_keywords?>" />
	<? else: ?>
		<title><?=COMPANY_NAME?></title>
		<meta name="description" content="<?=COMPANY_NAME?>" />
		<meta name="keywords" content="<?=COMPANY_NAME?>" />
	<? endif; ?>
</head>
<body>
	<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
	<?
		if($page){
			if($page->section){
				$i = 0;
				foreach($page->section as $section){
					echo $i == 0 ? '<h1>'.$section->title.'</h1>' : '<h2>'.$section->title.'</h2>' ;
					if($section->uploads){
						foreach($section->uploads as $up){
							echo '<a rel="shadowbox" href="'.asset('uploads/').$up->filename.'"><img class="section_image" src="'.asset('uploads/').$up->thumb_filename.'" /></a>';
						}
					}
					echo '<p>'.$section->content.'</p>';
				}
			}
		}
	?>
	<footer>
		<?=View::make('site.inc.footer')->render()?>
	</footer>
	<?=View::make('site.inc.scripts')->render()?>
</body>
</html>