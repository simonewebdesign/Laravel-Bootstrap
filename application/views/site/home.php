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
	Test
	<?
	echo Form::open('/');
	echo Form::token();
	echo '<p>'.Form::label('your_name','Your Name').Form::text('your_name',Input::old('your_name')).'</p>';
	echo '<p>'.Form::label('email','Your Email').Form::text('email',Input::old('email')).'</p>';
	echo '<p>'.Form::label('number','Your Number').Form::text('number',Input::old('number')).'</p>';
	echo '<p>'.Form::label('enquiry','Your Message').Form::textarea('enquiry',Input::old('enquiry')).'</p>';
	echo '<p>'.Form::submit('Send Message').'</p>';
	echo Form::close();
	?>

	<footer>
		<?=View::make('site.inc.footer')->render()?>
	</footer>
	<?=View::make('site.inc.scripts')->render()?>
</body>
</html>