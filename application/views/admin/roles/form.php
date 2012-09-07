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
          <h1><?php echo ( $create ? 'New Role' : 'Edit Role' )?></h1>
          <?php echo Messages::get_html()?>
          <?php echo Form::open('admin/roles/'.( $create ? 'create' : 'edit' ), 'POST', array('class'=>'form-horizontal'));?>
          <?php if(!$create): ?> <input type="hidden" name="id" value="<?php echo $role->id?>" /> <?php endif; ?>
           
          <fieldset>
            <legend>Basic Information</legend>

            <div class="control-group">
              <?php echo Form::label('name', 'Role Name',array('class'=>'control-label'))?>
              <div class="controls">
                <?php echo Form::text('name',  ( Input::old('name') || $create ? Input::old('name') : $role->name ),array('placeholder'=>'Enter Role Name...'))?>
              </div>
            </div>
          </fieldset>
          <?php
            if($users){
              echo '<fieldset><legend>Users Assigned To This Role</legend><div class="control-group">';
              echo Form::label('user_list','Role\'s Users', array('class'=>'control-label'));
              foreach($users as $user){
          ?>
              <div class="controls">
                <label class="checkbox">
                  <?php echo Form::checkbox('users['.$user->id.']', '1', ( Input::old('users['.$user->id.']') || $create ? Input::old('users['.$user->id.']') : Koki::has_role($user,$role->id) ) );?>
                  <?php echo $user->fullname?>
                </label>
              </div>
            </div>
          <?php
              }
              echo '</fieldset>';
            }
          ?>

          <div class="form-actions">
            <a class="btn" href="<?php echo url('admin/roles')?>">Go Back</a>
            <input type="submit" class="btn btn-primary" value="<?php echo ($create ? 'Create Role' : 'Save Role')?>" />
          </div>
          <?php echo Form::close()?>
        </div>

      </div>

    </div> <!-- /container -->

    <?php echo View::make('admin.inc.scripts', get_defined_vars() )->render()?>
  </body>
</html>
