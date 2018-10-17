<?php echo $header; ?><?php echo $column_left; ?>

<div id="content" class="skin-blue"> <?php echo $topbar; ?> <?php echo $sidebar; ?>
  <div class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="pull-right">
        <?php if ($installed) { ?>
        <a href="<?php echo $edit; ?>" class="btn btn-flat btn-success" target="_blank"><?php echo $button_add; ?></a> <a href="<?php echo $uninstall; ?>" class="btn btn-flat btn-danger" data-ajax="true" data-confirm="true"><?php echo $button_uninstall; ?></a>
        <?php } else { ?>
        <a href="<?php echo $install; ?>" class="btn btn-flat btn-primary" data-ajax="true" data-confirm="false"><?php echo $button_install; ?></a>
        <?php } ?>
      </div>
    </nav>
  </div>
  <div class="content-wrapper">
    <div class="content">
      <div class="panel panel-default">
        <div class="panel-body">
          <table id="module-list" class="table table-hover table-border">
            <thead>
              <tr>
                <td class="text-left"><?php echo $column_module; ?></td>
                <td class="text-right"><?php echo $column_action; ?></td>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($modules  as $module) { ?>
              <tr>
                <td class="text-left"><?php echo $module['name']; ?></td>
                <td class="text-right"><a href="<?php echo $module['edit']; ?>" class="btn btn-flat btn-success" target="_blank"><?php echo $button_edit; ?></a>
                  <?php if (isset($module['delete'])) { ?>
                  <a href="<?php echo $module['delete']; ?>" class="btn btn-flat btn-danger" data-ajax="true" data-confirm="true"><?php echo $button_delete; ?></a>
                  <?php } ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$(function() {
	$(document).delegate('a[data-ajax="true"]', 'click', function(e) {
		e.preventDefault();
		var _this = $(this);
		
		if ($(this).data('confirm') == true) {
			var _confirm = confirm('<?php echo $text_confirm; ?>');
		} else {
			_confirm = true;
		}
		
		if (_confirm) {
			$.ajax({
				url: $(this).attr('href'),
				type: 'GET',
				dataType: 'json',
				success: function(json) {
					if (json['success']) {
						$('#content .content').prepend('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fa fa-check"></i> ' + json['success'] + '</div>');
						
						location.reload(true);
					} else {
						$('#content .content').prepend('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fa fa-ban"></i> ' + json['error'] + '</div>');
					}
				}
			});
		}
	});
});
//--></script> 
<?php echo $footer; ?>