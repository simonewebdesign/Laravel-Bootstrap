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
          <h1><?php echo ( $create ? 'New Gallery' : 'Edit Gallery' )?></h1>
          <?php echo Messages::get_html()?>
          <?php echo Form::open('admin/gallery/'.( $create ? 'create' : 'edit' ), 'POST', array('class'=>'form-horizontal'));?>
          <? if(!$create): ?> <input type="hidden" name="id" value="<?php echo $gallery->id?>" /> <? endif; ?>
           
          <fieldset>
            <legend>Basic Information</legend>

            <div class="control-group">
              <?php echo Form::label('title', 'Gallery Title',array('class'=>'control-label'))?>
              <div class="controls">
                <?php echo Form::text('title',  ( Input::old('title') || $create ? Input::old('title') : $gallery->title ),array('placeholder'=>'Enter Gallery Title...'))?>
              </div>
            </div>

            <div class="control-group">
              <?php echo Form::label('description', 'Gallery Description',array('class'=>'control-label'))?>
              <div class="controls">
                <?php echo Form::textarea('description',( Input::old('description') || $create ? Input::old('description') : $gallery->description ),array('class'=>'editable_text','placeholder'=>'Enter Gallery Description...'))?>
              </div>
            </div>

          </fieldset>

          <div class="form-actions">
            <a class="btn" href="<?php echo url('admin/gallery')?>">Go Back</a>
            <input type="submit" class="btn btn-primary" value="<?php echo ($create ? 'Create Gallery' : 'Save Gallery')?>" />
          </div>
          <?php echo Form::close()?>
        </div>

      </div>

    </div> <!-- /container -->

    <?php echo View::make('admin.inc.scripts', get_defined_vars() )->render()?>
  </body>
</html>
