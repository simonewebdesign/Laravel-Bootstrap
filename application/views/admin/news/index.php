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
          <h1>News Articles</h1>
          <p>You can use this control panel to administer certain aspects of your website. If you get stuck there will always be a Help &amp; Support Button in the sidebar to the left.</p>
          <?php echo Messages::get_html()?>
          <?php
            if($news){
              echo '<table class="table table-striped table-bordered table-condensed">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Content Exerpt</th>
                  <th>Created</th>
                  <th>Actions</th>
                </tr>
              </thead><tbody>
              ';
              foreach($news as $article){
                echo '<tr>
                  <td>'.$article->id.'</td>
                  <td>'.$article->title.'</td>
                  <td>'.Str::limit(strip_tags($article->content), 40).'</td>
                  <td>'.$article->created_at.'</td>
                  <td><a class="btn btn-primary" href="'.action('admin.news@edit', array($article->id)).'">Edit</a> <a class="delete_toggler btn btn-danger" rel="'.$article->id.'">Delete</a></td>
                </tr>';
              }
              echo '</tbody></table>';
            }else{
          ?>
            <div class="well">No news articles today. Why not create one using the button below.</div>
          <?php
            }
          ?>
          <a href="<?php echo action('admin.news@create')?>" class="btn btn-primary right">New Article</a>
        </div>

      </div>

    </div> <!-- /container -->
    <div class="modal hide fade" id="delete_article">
      <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>Are You Sure?</h3>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this post?</p>
      </div>
      <div class="modal-footer">
        <?php echo Form::open('admin/news/delete', 'POST')?>
        <a data-toggle="modal" href="#delete_article" class="btn">Keep</a>
        <input type="hidden" name="id" id="postvalue" value="" />
        <input type="submit" class="btn btn-danger" value="Delete" />
        <?php echo Form::close()?>
      </div>
    </div>
    <?php echo View::make('admin.inc.scripts', get_defined_vars() )->render()?>
    <script>
      $('#delete_article').modal({
        show:false
      }); // Start the modal

      // Populate the field with the right data for the modal when clicked
      $('.delete_toggler').each(function(index,elem) {
          $(elem).click(function(){
            $('#postvalue').attr('value',$(elem).attr('rel'));
            $('#delete_article').modal('show');
          });
      });
    </script>
  </body>
</html>
