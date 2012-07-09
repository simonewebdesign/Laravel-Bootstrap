<?=View::make('admin.inc.meta', get_defined_vars() )->render()?>
    <title><?=ADMIN_TITLE?></title>
  </head>
  <body>
    <?=View::make('admin.inc.header', get_defined_vars() )->render()?>
    <div class="container">

      <div class="row-fluid">

        <div class="span3"> <!-- Sidebar -->
          <div class="well">
            <?=View::make('admin.inc.sidebar', get_defined_vars() )->render()?>
          </div>
        </div> <!-- /Sidebar -->

        <div class="span9">
          <h1>Website Backend Dashboard</h1>
          <p>You can use this control panel to administer certain aspects of your website. If you get stuck there will always be a Help &amp; Support Button in the sidebar to the left.</p>
        </div>

      </div>
      <div class="row-fluid">
        <div class="span12">
          <p>You are logged in as: <?=$user->username?></p>
        </div>
      </div>
    </div> <!-- /container -->
    <?=View::make('admin.inc.scripts', get_defined_vars() )->render()?>
  </body>
</html>
