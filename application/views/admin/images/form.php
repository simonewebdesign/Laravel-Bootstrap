<?php echo View::make('admin.inc.meta', get_defined_vars() )->render()?>
    <title><?php echo ADMIN_TITLE?></title>
  </head>
  <body>
    <?php echo View::make('admin.inc.header', get_defined_vars() )->render()?>
    <div class="container">

      <div class="row-fluid">

        <div class="span3"> <!-- Sidebar -->
          <div class="well">
            <?php echo View::make('admin.inc.sidebar', get_defined_vars() )->render()?>
          </div>
        </div> <!-- /Sidebar -->

        <div class="span9 crud">
          <h1><?php echo ( $create ? 'New Image' : 'Edit Image' )?></h1>
          <?php echo Messages::get_html()?>
          <?php echo Form::open_for_files('admin/images/'.( $create ? 'create' : 'edit' ), 'POST', array('class'=>'form-horizontal'));?>
          <?php if(!$create): ?> <input type="hidden" name="id" value="<?php echo $image->id?>" /> <?php endif; ?>
           
          <fieldset>
            <legend>Basic Information</legend>

            <div class="control-group">
              <?php echo Form::label('gallery_id', 'Belongs To Gallery',array('class'=>'control-label'))?>
              <div class="controls">
                <?php
                $dataset[''] = 'Please Select A Gallery';
                if($galleries){
                  foreach($galleries as $gallery){
                    $dataset[$gallery->id] = $gallery->title;
                  }
                }
                echo Form::select('gallery_id', $dataset, $create || !$image->gallery ? false : $image->gallery->id )?>
              </div>
            </div>

            <div class="control-group">
              <?php echo Form::label('title', 'Image Title',array('class'=>'control-label'))?>
              <div class="controls">
                <?php echo Form::text('title',  ( Input::old('title') || $create ? Input::old('title') : $image->title ),array('placeholder'=>'Enter Image Title...'))?>
              </div>
            </div>


          </fieldset>
          <fieldset>
            <legend>Images</legend>
            <div class="row">
              <div class="span5">
                <div class="control-group">
                  <?php echo Form::label('image', 'Upload Image',array('class'=>'control-label'))?>
                  <div class="controls">
                    <input type="file" name="image" value="<?php echo Input::old('file')?>" />
                  </div>
                </div>
              </div>
              <div class="span3">
                <?php
                  if(!$create && $image->uploads){
                ?>
                <ul class="thumbnails">
                  <?php foreach($image->uploads as $upload){ ?>
                  <li>
                    <div class="thumbnail">
                      <img src="<?php echo asset('uploads/'.$upload->small_filename)?>" alt="">
                      <div class="caption">
                        <p><strong>User:</strong> '<?php echo $upload->user->username?>'</p>
                        <p><strong>Uploaded:</strong> '<?php echo $upload->created_at?>'</p>
                      </div>
                    </div>
                  </li>
                  <?php } ?>
                </ul>
                <?php } ?>
              </div>
          </fieldset>
          <div class="form-actions">
            <a class="btn" href="<?php echo url('admin/images')?>">Go Back</a>
            <input type="submit" class="btn btn-primary" value="<?php echo ($create ? 'Create Image' : 'Save Image')?>" />
          </div>
          <?php echo Form::close()?>
        </div>

      </div>

    </div> <!-- /container -->

    <?php echo View::make('admin.inc.scripts', get_defined_vars() )->render()?>
  </body>
</html>
