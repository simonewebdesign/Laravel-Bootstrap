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

        <div class="span9">
          <h1>Images</h1>
          <p>You can create your images here.</p>
          <?php echo Messages::get_html()?>
          <?php
            if($galleries){
              foreach($galleries as $gallery){
                echo '<h2>'.$gallery->title.'</h2>';
                if($gallery->image){
                  echo '<ul class="gallery_images thumbnails">';
                  foreach($gallery->image as $img){
                    if($img->uploads){
                      foreach($img->uploads as $up){
                        echo '<li class="span2" rel="'.$img->id.'">
                        <div class="thumbnail">
                          <img src="'.asset('uploads/'.$up->small_filename).'" />
                          <div class="caption">
                            <p>'.$img->title.'</p>
                            <div class="action_buttons"><a class="label label-info" href="'.action('admin.images@edit', array($img->id)).'">Edit</a> <a class="delete_toggler label label-important" rel="'.$img->id.'">Delete</a></div>
                            <p><small>Drag To Order</small></p>
                            
                          </div>
                        </div></li>';
                      }
                    }
                  }
                  echo '</ul>';
                }else{
                  echo '<div class="well">No images for this gallery. Add one using the "Add Image" button.</div>';
                }
              }
            }else{
          ?>
            <div class="well">No galleries today. Why not create one using the button below.</div>
          <?php
            }
          ?>
          <a href="<?php echo action('admin.images@create')?>" class="btn btn-primary right">New Image</a>
        </div>

      </div>

    </div> <!-- /container -->
    <div class="modal hide fade" id="delete_image">
      <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>Are You Sure?</h3>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this image?</p>
      </div>
      <div class="modal-footer">
        <?php echo Form::open('admin/images/delete', 'POST')?>
          <a data-toggle="modal" href="#delete_image" class="btn">Keep</a>
          <input type="hidden" name="id" id="postvalue" value="" />
          <input type="submit" class="btn btn-danger" value="Delete" />
        <?php echo Form::close()?>
      </div>
    </div>
    <?php echo View::make('admin.inc.scripts', get_defined_vars() )->render()?>
    <script>

    $( "ul.gallery_images" ).sortable({
      update: function(event, ui) {
        var order = new Array();
        $('ul.gallery_images li').each(function(index,elem) {
          order[index] = $(elem).attr('rel');
        });
        $.ajax({
          type: 'POST',
          url: "<?php echo action('admin.images@update_order')?>",
          data: 'data='+JSON.stringify(order),
        });
      }
    });
    $( "ul.gallery_images" ).disableSelection();

      $('#delete_image').modal({
        show:false
      }); // Start the modal

      // Populate the field with the right data for the modal when clicked
      $('.delete_toggler').each(function(index,elem) {
          $(elem).click(function(){
            $('#postvalue').attr('value',$(elem).attr('rel'));
            $('#delete_image').modal('show');
          });
      });
    </script>
  </body>
</html>
