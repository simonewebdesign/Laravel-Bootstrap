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
          <h1><?php echo ( $create ? 'New Page' : 'Edit Page' )?></h1>
          <?php echo Messages::get_html()?>
          <?php echo Form::open('admin/pages/'.( $create ? 'create' : 'edit' ), 'POST', array('class'=>'form-horizontal'));?>
          <? if(!$create): ?> <input type="hidden" name="id" value="<?php echo $page->id?>" /> <? endif; ?>
           
          <fieldset>
            <legend>Basic Information</legend>

            <div class="control-group">
              <?php echo Form::label('title', 'Page Title',array('class'=>'control-label'))?>
              <div class="controls">
                <?php echo Form::text('title',  ( Input::old('title') || $create ? Input::old('title') : $page->title ),array('placeholder'=>'Enter Page Title...'))?>
              </div>
            </div>
          </fieldset>

          <fieldset>
            <legend>SEO Information</legend>
            <div class="control-group">
              <?php echo Form::label('meta_title', 'Meta Title',array('class'=>'control-label'))?>
              <div class="controls">
                <?php echo Form::text('meta_title',  ( Input::old('meta_title') || $create ? Input::old('meta_title') : $page->meta_title ),array('placeholder'=>'Enter Meta Title...'))?>
              </div>
            </div>

            <div class="control-group">
              <?php echo Form::label('meta_description', 'Meta Description',array('class'=>'control-label'))?>
              <div class="controls">
                <?php echo Form::text('meta_description',  ( Input::old('meta_description') || $create ? Input::old('meta_description') : $page->meta_description ),array('placeholder'=>'Enter Meta Description...'))?>
              </div>
            </div>

            <div class="control-group">
              <?php echo Form::label('meta_keywords', 'Meta Keywords',array('class'=>'control-label'))?>
              <div class="controls">
                <?php echo Form::text('meta_keywords',  ( Input::old('meta_keywords') || $create ? Input::old('meta_keywords') : $page->meta_keywords ),array('placeholder'=>'Enter Meta Keywords...'))?>
              </div>
            </div>

          </fieldset>

          <div class="form-actions">
            <a class="btn" href="<?php echo url('admin/pages')?>">Go Back</a>
            <input type="submit" class="btn btn-primary" value="<?php echo ($create ? 'Create Page' : 'Save Page')?>" />
          </div>
          <?php echo Form::close()?>
        </div>

      </div>

    </div> <!-- /container -->

    <?php echo View::make('admin.inc.scripts', get_defined_vars() )->render()?>
  </body>
</html>
