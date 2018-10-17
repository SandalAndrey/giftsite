<?php echo $header; ?><?php echo $column_left; ?>

<div id="content" class="skin-blue"> <?php echo $topbar; ?> <?php echo $sidebar; ?>
  <div class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="pull-right">
        <a href="<?php echo $export; ?>" class="btn btn-flat btn-primary"><?php echo $button_export; ?></a>
      </div>
    </nav>
  </div>
  <div class="content-wrapper">
    <div class="content">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="form-group">
            <select name="package" id="sample-data-package" class="form-control">
              <?php foreach ($packages as $package) { ?>
              <option value="<?php echo $package; ?>"><?php echo $package; ?></option>
              <?php } ?>
            </select>
          </div>
          <table id="sample-data-module" class="table table-hover table-border">
            <thead>
              <tr>
                <td class="text-left"><?php echo $column_module; ?></td>
                <td class="text-right" style="width: 100px;"><?php echo $column_action; ?></td>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$(function() {
	var ajax;
	
	$('#sample-data-package').on('change', function(e) {
		if ($(this).val()) {
			if(ajax) ajax.abort();
			ajax = $.ajax({
				url: 'index.php?route=extension/bossthemes/sample_data/getPackage&user_token=<?php echo $user_token; ?>',
				data: {
					package: $(this).val()
				},
				type: 'POST',
				dataType: 'json',
				success: function(json) {
					if (json['modules']) {
						var html = '';
						
						for (i in json['modules']) {
							html += '<tr>';
							html += '  <td class="text-left"><p>' + json['modules'][i]['name'] + '</p>';
							if (json['modules'][i]['note']) {
								html += '    <div class="alert alert-warning alert-dismissible">';
								html += '      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
								html += '      <i class="icon fa fa-warning"></i> ' + json['modules'][i]['note'];
								html += '    </div>';
							}
							html += '  </td>';
							html += '  <td class="text-right"><a href="' + json['modules'][i]['import'] + '" class="btn btn-flat btn-success sample-data-import"><?php echo $button_import; ?></a></td>';
							html += '</tr>';
						}
						
						$('#sample-data-module tbody').html(html);
					}
				}
			});
		}
	});
	
	$('#sample-data-package').change();
	
	$('#sample-data-module').delegate('a.sample-data-import', 'click', function(e) {
		e.preventDefault();
		var _this = $(this);
		var _confirm = confirm('<?php echo $text_confirm; ?>');
		
		if (_confirm) {
			$.ajax({
				url: $(this).attr('href'),
				type: 'GET',
				dataType: 'json',
				success: function(json) {
					if (json['success']) {
						_this.parents('td').prev('td').append('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fa fa-check"></i> ' + json['success'] + '</div>');
					} else {
						_this.parents('td').prev('td').append('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fa fa-ban"></i> ' + json['error'] + '</div>');
					}
				}
			});
		}
	});
});
//-->
</script>
<?php echo $footer; ?>