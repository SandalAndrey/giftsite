<?php echo $header; ?><?php echo $column_left; ?>

<div id="content" class="skin-blue"> <?php echo $topbar; ?> <?php echo $sidebar; ?>
  <div class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="pull-right"> </div>
    </nav>
  </div>
  <div class="content-wrapper">
    <div class="content">
      <?php if($error_warning) { ?>
      <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
      <?php } ?>
      <?php if ($success) { ?>
      <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
      <?php } ?>
      <div class="panel panel-default">
        <div class="panel-body">
          <form class="form-horizontal">
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="button-upload"><span data-toggle="tooltip" title="<?php echo $help_upload; ?>"><?php echo $entry_upload; ?></span></label>
              <div class="col-sm-10">
                <button type="button" id="button-upload" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-flat btn-primary"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                <?php if ($error_temporary) { ?>
                <button type="button" id="button-clear" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-flat btn-danger"><i class="fa fa-eraser"></i> <?php echo $button_clear; ?></button>
                <?php } else { ?>
                <button type="button" id="button-clear" data-loading-text="<?php echo $text_loading; ?>" disabled="disabled" class="btn btn-flat btn-danger"><i class="fa fa-eraser"></i> <?php echo $button_clear; ?></button>
                <?php } ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo $entry_progress; ?></label>
              <div class="col-sm-10">
                <div class="progress active">
                  <div id="progress-bar" class="progress-bar progress-bar-primary progress-bar-striped" style="width: 0%;"></div>
                </div>
                <div id="progress-text"></div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-body">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-log" data-toggle="tab"><?php echo $tab_log; ?></a></li>
            <div class="pull-right"><a href="<?php echo $refresh; ?>" data-toggle="tooltip" title="<?php echo $button_refresh; ?>" class="btn btn-flat btn-info"><i class="fa fa-refresh"></i></a>
              <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-flat btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-modification').submit() : false;"><i class="fa fa-trash-o"></i></button>
            </div>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-modification">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                        <td class="text-left"><?php if ($sort == 'name') { ?>
                          <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                          <?php } else { ?>
                          <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                          <?php } ?></td>
                        <td class="text-left"><?php if ($sort == 'author') { ?>
                          <a href="<?php echo $sort_author; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_author; ?></a>
                          <?php } else { ?>
                          <a href="<?php echo $sort_author; ?>"><?php echo $column_author; ?></a>
                          <?php } ?></td>
                        <td class="text-left"><?php if ($sort == 'version') { ?>
                          <a href="<?php echo $sort_version; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_version; ?></a>
                          <?php } else { ?>
                          <a href="<?php echo $sort_version; ?>"><?php echo $column_version; ?></a>
                          <?php } ?></td>
                        <td class="text-left"><?php if ($sort == 'status') { ?>
                          <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                          <?php } else { ?>
                          <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                          <?php } ?></td>
                        <td class="text-left"><?php if ($sort == 'date_added') { ?>
                          <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                          <?php } else { ?>
                          <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                          <?php } ?></td>
                        <td class="text-right"><?php echo $column_action; ?></td>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if ($modifications) { ?>
                      <?php foreach ($modifications as $modification) { ?>
                      <tr>
                        <td class="text-center"><?php if (in_array($modification['modification_id'], $selected)) { ?>
                          <input type="checkbox" name="selected[]" value="<?php echo $modification['modification_id']; ?>" checked="checked" />
                          <?php } else { ?>
                          <input type="checkbox" name="selected[]" value="<?php echo $modification['modification_id']; ?>" />
                          <?php } ?></td>
                        <td class="text-left"><?php echo $modification['name']; ?></td>
                        <td class="text-left"><?php echo $modification['author']; ?></td>
                        <td class="text-left"><?php echo $modification['version']; ?></td>
                        <td class="text-left"><?php echo $modification['status']; ?></td>
                        <td class="text-left"><?php echo $modification['date_added']; ?></td>
                        <td class="text-right"><?php if ($modification['link']) { ?>
                          <a href="<?php echo $modification['link']; ?>" data-toggle="tooltip" title="<?php echo $button_link; ?>" class="btn btn-info" target="_blank"><i class="fa fa-link"></i></a>
                          <?php } else { ?>
                          <button type="button" class="btn btn-info" disabled="disabled"><i class="fa fa-link"></i></button>
                          <?php } ?>
                          <?php if (!$modification['enabled']) { ?>
                          <a href="<?php echo $modification['enable']; ?>" data-toggle="tooltip" title="<?php echo $button_enable; ?>" class="btn btn-flat btn-success"><i class="fa fa-plus-circle"></i></a>
                          <?php } else { ?>
                          <a href="<?php echo $modification['disable']; ?>" data-toggle="tooltip" title="<?php echo $button_disable; ?>" class="btn btn-flat btn-danger"><i class="fa fa-minus-circle"></i></a>
                          <?php } ?></td>
                      </tr>
                      <?php } ?>
                      <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="7"><?php echo $text_no_results; ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </form>
              <div class="row">
                <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
                <div class="col-sm-6 text-right"><?php echo $results; ?></div>
              </div>
            </div>
            <div class="tab-pane" id="tab-log">
              <p>
                <textarea wrap="off" rows="15" class="form-control"><?php echo $log; ?></textarea>
              </p>
              <div class="text-right"><a href="<?php echo $clear_log; ?>" class="btn btn-danger"><i class="fa fa-eraser"></i> <?php echo $button_clear; ?></a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
var step = new Array();
var total = 0;

$('#button-upload').on('click', function() {
	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			// Reset everything
			$('.alert').remove();
			$('#progress-bar').css('width', '0%');
			$('#progress-bar').removeClass('progress-bar-danger progress-bar-success');
			$('#progress-text').html('');

			$.ajax({
				url: 'index.php?route=extension/bossthemes/xml/upload&user_token=<?php echo $user_token; ?>',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('#button-upload').button('loading');
				},
				complete: function() {
					$('#button-upload').button('reset');
				},
				success: function(json) {
					if (json['error']) {
						$('#progress-bar').addClass('progress-bar-danger');
						$('#progress-text').html('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['step']) {
						step = json['step'];
						total = step.length;
						next();
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});

$('#button-continue').on('click', function() {
	next();

	$('#button-continue').prop('disabled', true);
});

function next() {
	data = step.shift();

	if (data) {
		$('#progress-bar').css('width', (100 - (step.length / total) * 100) + '%');
		$('#progress-text').html('<span class="text-info">' + data['text'] + '</span>');

		$.ajax({
			url: data.url,
			type: 'post',
			dataType: 'json',
			data: 'path=' + data.path,
			success: function(json) {
				if (json['error']) {
					$('#progress-bar').addClass('progress-bar-danger');
					$('#progress-text').html('<div class="text-danger">' + json['error'] + '</div>');
					$('#button-clear').prop('disabled', false);
				}

				if (json['success']) {
					$('#progress-bar').addClass('progress-bar-success');
					$('#progress-text').html('<span class="text-success">' + json['success'] + '</span>');
					
					if (step.length == 0) window.location.href = '<?php echo html_entity_decode($refresh); ?>';
				}

				if (!json['error'] && !json['success']) {
					next();
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}

$('#button-clear').bind('click', function() {
	$.ajax({
		url: 'index.php?route=extension/bossthemes/xml/clear&user_token=<?php echo $user_token; ?>',
		dataType: 'json',
		beforeSend: function() {
			$('#button-clear').button('loading');
		},
		complete: function() {
			$('#button-clear').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('#button-clear').prop('disabled', true);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
//--></script> 
<?php echo $footer; ?>