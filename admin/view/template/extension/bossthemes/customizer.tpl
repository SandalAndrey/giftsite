<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<script type="text/javascript">
    var wpColorPickerL10n = {"clear":"<?php echo $entry_clear; ?>","defaultString":"<?php echo $entry_default; ?>","pick":"<?php echo $entry_select_color; ?>","current":"<?php echo $entry_current_color; ?>"};
</script>
</head>
<body>
<div class="full-overlay expanded">
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <?php if ($error_data) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_data; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="customizer-controls" class="wrap full-overlay-sidebar">
    <div id="customizer-header-actions" class="full-overlay-header">
      <button type="button" name="reset" id="reset" class="btn btn-danger button-primary reset" data-toggle="tooltip" title="<?php echo $button_reset; ?>" data-original-title="Reset Customizer editing"> <i class="fa fa-trash-o"></i> </button>
      <button type="submit" name="save" id="save" class="btn btn-default button-primary save" data-toggle="tooltip" title="<?php echo $button_save; ?>" data-original-title="Save Customizer editing"> <i class="fa fa-save text-success"></i> </button>
      <a class="customizer-controls-close" href="<?php echo $button_back;?>"> <span class="screen-reader-text"><?php echo $entry_close; ?></span> </a
      ><span class="control-panel-back" tabindex="-1"> <span class="screen-reader-text"><?php echo $entry_back; ?></span> </span> </div>
    <div id="widgets-right">
      <div class="full-overlay-sidebar-content" tabindex="-1">
        <div id="customizer-theme-controls" class="module_accordion ds_accordion">
          <div id="accordion-section-themes" class="customize-themes">
            <h3 class="accordion-section-title nonecontent">
              <p class="description customizer-section-description"><?php echo $entry_store; ?></p>
              <select name="customizer_stores" id="customizer_stores" class="form-control">
                <?php foreach ($stores as $store) { ?>
                  <option value="<?php echo $store['edit']; ?>" <?php echo ($store['store_id'] == $store_id) ? 'selected="selected"' : ''; ?>><?php echo $store['name']; ?></option>
                <?php } ?>
              </select>
            </h3>
          </div>
          <ul id="customize-all-content">
            <?php $i = 0; ?>
            <?php foreach ($sections as $group) { ?>
            <li class="ds_heading accordion-section control-section control-section-default">
              <h3 class="accordion-section-title" tabindex="0"> <?php echo $group->title; ?> <span class="screen-reader-text"><?php echo $text_menu_description;?></span> </h3>
              <input type="hidden" name="xml[<?php echo $i;?>][title]" value='<?php echo($group->title); ?>' />
              <ul class="accordion-section-content ds_content">
                <?php foreach ($group->item as $item) { ?>
                <li class="customizer-control customizer-control-text">
                  <label><span class="customizer-control-title"><?php echo $item->text; ?></span></label>
                  <?php if ($item->type == 'font') { ?>
                  <select name="xml[<?php echo $i;?>][value][]" class="form-control" data-control="true">
                    <option value="">Inherit</option>
                    <?php foreach($fonts as $font_key => $font_value){ ?>
                    <?php $font_key = ($font_key == 'system') ? 'System Fonts' : 'Google Fonts'; ?>
                    <optgroup label="<?php echo $font_key; ?>">
                    <?php foreach($font_value as $font){ ?>
                    <option value="<?php echo $font['family']; ?>" data-category="<?php echo $font['category']; ?>" <?php echo ($item->value == $font['family']) ? 'selected="selected"' : '' ; ?>><?php echo $font['family']; ?></option>
                    <?php } ?>
                    </optgroup>
                    <?php } ?>
                  </select>
                  <?php } elseif ($item->type == 'select') { ?>
                    <select name="xml[<?php echo $i;?>][value][]" class="form-control" data-control="true">
                      <?php foreach (json_decode($item->ref, true) as $value => $name) { ?>
                        <option value="<?php echo $value; ?>" <?php echo ($value == $item->value) ? 'selected="selected"' : ''; ?>><?php echo $name; ?></option>
                      <?php } ?>
                    </select>
                  <?php } elseif ($item->type == 'color') { ?>
                  <div class="customizer-control-content">
                    <div class="picker-container"> <span class="picker-input-wrap">
                      <input type="text" name="xml[<?php echo $i;?>][value][]" class="color-picker-hex color-picker" maxlength="7" value="<?php echo $item->value; ?>" data-default-color="<?php echo $item->value; ?>" data-control="true" />
                      <input type="button" class="button button-small hidden picker-default" value="<?php echo $entry_default; ?>" />
                      </span>
                      <div class="picker-holder"></div>
                    </div>
                  </div>
                  <?php } elseif ($item->type == 'image') { ?>
                  <div class="image"><a href="javascript:void(0);" id="thumb-<?php echo($item->keyword); ?>" class="img-thumbnail" data-toggle="image"> <img src="<?php echo $_image->resize($item->value, 100, 100); ?>" id="src-<?php echo($item->keyword); ?>" width="100" height="100" data-placeholder="<?php echo $placeholder; ?>" alt="<?php echo($item->text); ?>" /> </a>
                    <input type="hidden" name="xml[<?php echo $i;?>][value][]" value="<?php echo($item->value); ?>" id="<?php echo($item->keyword); ?>" data-control="true" />
                  </div>
                  <?php } ?>
                  <input type="hidden" name="xml[<?php echo $i;?>][text][]" value="<?php echo($item->text); ?>" />
                  <input type="hidden" name="xml[<?php echo $i;?>][selector][]" value="<?php echo($item->selector); ?>" data-selector="<?php echo($item->selector); ?>" />
                  <input type="hidden" name="xml[<?php echo $i;?>][property][]" value="<?php echo($item->property); ?>" data-property="<?php echo($item->property); ?>" />
                  <input type="hidden" name="xml[<?php echo $i;?>][type][]" value="<?php echo($item->type); ?>" data-type="<?php echo($item->type); ?>" />
                  <input type="hidden" name="xml[<?php echo $i;?>][keyword][]" value="<?php echo($item->keyword); ?>" data-keyword="<?php echo($item->keyword); ?>" />
                  <input type="hidden" name="xml[<?php echo $i;?>][ref][]" value='<?php echo($item->ref); ?>' data-ref="<?php echo($item->ref); ?>" />
                  <a class="del-item"><i class="fa fa-times-circle"></i></a>
                </li>
                <?php } ?>
                <div class="add-item" data-index="<?php echo $i;?>"><i class="fa fa-plus"></i></div>
              </ul>
            </li>
            <?php $i++; ?>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
    <div id="customizer-footer-actions" class="full-overlay-footer"> <a href="javascript:void(0);" class="collapse-sidebar button-secondary" title="<?php echo $entry_collapse_sidebar; ?>"> <span class="collapse-sidebar-arrow"></span> <span class="collapse-sidebar-label"><?php echo $entry_collapse; ?></span> </a> </div>
  </form>
  <div id="customizer-footer-actions" style="display:none;" class="full-overlay-footer open-customizer"> <a href="javascript:void(0);" class="collapse-sidebar button-secondary" title=""> <span class="collapse-sidebar-arrow"></span> </a> </div>
  <div id="customizer-preview" class="full-overlay-main"></div>
</div>
<script type="text/javascript"><!--
$(function() {
    var collapse = 'open';
    $('.ds_accordion .ds_content').css('display', 'none');

    $('.ds_accordion .ds_heading').click(function() {
        if (!$(this).hasClass('active')) {
            $(this).addClass('active').siblings('.ds_heading').removeClass('active');
            var statsTemplate = $(this).children('.ds_content');
            $(statsTemplate).slideDown(350);
            $(this).siblings('.ds_heading').children('.ds_content').slideUp(350);
        }
    });

    $('.ds_accordion .ds_heading:first-child').each(function(dataAndEvents, deepDataAndEvents) {
        $(this).click();
    });

    $('.collapse-sidebar').click(function(){
        if(collapse == 'open'){
            $( "#customizer-controls" ).animate({marginLeft: "-320px"}, 1 );
            $( ".full-overlay.collapsed" ).animate({marginLeft: "0px"}, 1 );
            $( ".open-customizer" ).show();
            $( ".expanded" ).addClass('collapsed');
            $( ".expanded" ).removeClass('expanded');
            collapse = 'close';
        } else {
            $( "#customizer-controls" ).animate({marginLeft: "0px"}, 1 );
            $( ".full-overlay.expanded" ).animate({marginLeft: "300px"}, 1 );
            $( ".open-customizer" ).hide();
            $( ".collapsed" ).addClass('expanded');
            $( ".collapsed" ).removeClass('collapsed');
            collapse = 'open';
        }
    });
	
	$('.color-picker').wpColorPicker();
});

function getURLVar(key) {
    var value = [];

    var query = String(document.location).split('?');

    if (query[1]) {
        var part = query[1].split('&');

        for (i = 0; i < part.length; i++) {
            var data = part[i].split('=');

            if (data[0] && data[1]) {
                value[data[0]] = data[1];
            }
        }

        if (value[key]) {
            return value[key];
        } else {
            return '';
        }
    }
}

$(document).ready(function() {
	var system_fonts = [
		'',
		'Arial',
		'Verdana',
		'Helvetica',
		'Tahoma',
		'Georgia',
		'Courier',
		'Comic Sans MS',
		'Trebuchet MS',
		'Times New Roman',
		'Lucida Grande'
	];
	
	// Image Manager
	$(document).on('click', 'a[data-toggle="image"]', function(e) {
		var $element = $(this);
		var $popover = $element.data('bs.popover'); // element has bs popover?

		e.preventDefault();

		// destroy all image popovers
		$('a[data-toggle="image"]').popover('destroy');

		// remove flickering (do not re-add popover when clicking for removal)
		if ($popover) {
			return;
		}

		$element.popover({
			html: true,
			placement: 'right',
			trigger: 'manual',
			content: function() {
				return '<button type="button" id="button-image" class="btn btn-primary"><i class="fa fa-pencil"></i></button> <button type="button" id="button-clear" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>';
			}
		});

		$element.popover('show');

		$('#button-image').on('click', function() {
			var $button = $(this);
			var $icon   = $button.find('> i');

			$('#modal-image').remove();

			$.ajax({
				url: 'index.php?route=common/filemanager&user_token=' + getURLVar('user_token') + '&target=' + $element.parent().find('input').attr('id') + '&thumb=' + $element.attr('id'),
				dataType: 'html',
				beforeSend: function() {
					$button.prop('disabled', true);
					if ($icon.length) {
						$icon.attr('class', 'fa fa-circle-o-notch fa-spin');
					}
				},
				complete: function() {
					$button.prop('disabled', false);

					if ($icon.length) {
						$icon.attr('class', 'fa fa-pencil');
					}
				},
				success: function(html) {
					$('body').append('<div id="modal-image" class="modal">' + html + '</div>');

					$('#modal-image').modal('show');
					
					$('#modal-image').on('hidden.bs.modal', function () {
						$element.parent().find('input').trigger('change');
					});
				}
			});

			$element.popover('destroy');
		});

		$('#button-clear').on('click', function() {
			$element.find('img').attr('src', $element.find('img').attr('data-placeholder'));

			$element.parent().find('input').val('').trigger('change');

			$element.popover('destroy');
		});
	});

    $('#reset').on('click', function() {
        $.ajax({
            url: '<?php echo str_replace("&amp;", "&", $reset); ?>',
			data: {
				store_id: <?php echo $store_id; ?>
			},
			type: 'post',
            dataType: 'json',
            success: function(json) {
                window.location=("<?php echo str_replace('amp;', '', $action); ?>");
            }
        });
    });
	
	$(document).on('change', '[data-control]', function(e) {
		var selector = $(this).parents('.customizer-control').find('[data-selector]').val();
		var property = $(this).parents('.customizer-control').find('[data-property]').val();
		var type = $(this).parents('.customizer-control').find('[data-type]').val();
		var keyword = $(this).parents('.customizer-control').find('[data-keyword]').val();
		var value = $(this).val();
		
		if (!$('#custom-css-' + keyword, $('#customizer-preview iframe').contents()).length) {
			$('head', $('#customizer-preview iframe').contents()).append('<style type="text/css" id="custom-css-' + keyword + '"></style>');
		}
		
		var target = $('#custom-css-' + keyword, $('#customizer-preview iframe').contents());
		var rule = (value) ? selector + '{' + property + ':' +  value + '}' : '';
		
		if (type == 'font') {
			$('#custom-font-' + keyword, $('#customizer-preview iframe').contents()).remove();
			
			if (system_fonts.indexOf(value) == -1) {
				$('head', $('#customizer-preview iframe').contents()).append('<link href="//fonts.googleapis.com/css?family=' + encodeURI(value) + ':100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" id="custom-font-' + keyword + '" rel="stylesheet">');
			}
			
			rule = (value) ? selector + '{' + property + ':"' + value + '", ' + $('option:selected', this).data('category') + '}' : '';
		} else if (type == 'image') {
			if (property == 'src') {
				$(selector, $('#customizer-preview iframe').contents()).attr(property, (value) ? 'image/' + value : '');
				rule = '';
			} else {
				rule = (value) ? selector + '{' + property + ':' +  "url('image/" + value + "')}" : '';
			}
		}
		
		target.html("\n" + rule + "\n");
	});
	
	 $('.add-item').on('click', function(e) {
		var $element = $(this);
		var $popover = $element.data('bs.popover');
		
		e.preventDefault();
		
		$('.add-item').popover('destroy');
		
		if ($popover) {
			return;
		}
		
		$element.popover({
			html: true,
			placement: 'bottom',
			trigger: 'manual',
			content: function() {
				var html = '';
				
				html += '<div id="control-form">';
					html += '<div class="form-group">';
						html += '<div>';
							html += '<label><?php echo $entry_type; ?></label>';
							html += '<select name="type" class="form-control">';
								html += '<option value="color"><?php echo $text_color; ?></option>';
								html += '<option value="image"><?php echo $text_image; ?></option>';
								html += '<option value="select"><?php echo $text_select; ?></option>';
								html += '<option value="font"><?php echo $text_font; ?></option>';
							html += '</select>';
						html += '</div>';
						html += '<div>';
							html += '<label><?php echo $entry_tile; ?></label>';
							html += '<input name="text" class="form-control" />';
						html += '</div>';
						html += '<div>';
							html += '<label><?php echo $entry_selector; ?></label>';
							html += '<input name="selector" class="form-control" />';
						html += '</div>';
						html += '<div>';
							html += '<label><?php echo $entry_property; ?></label>';
							html += '<input name="property" class="form-control" />';
						html += '</div>';
						html += '<div>';
							html += '<label><?php echo $entry_value; ?></label>';
							html += '<input name="value" class="form-control" />';
						html += '</div>';
						html += '<div>';
							html += '<label><?php echo $entry_keyword; ?></label>';
							html += '<input name="keyword" class="form-control" />';
						html += '</div>';
						html += '<div>';
							html += '<label><?php echo $entry_ref; ?></label>';
							html += '<input name="ref" class="form-control" />';
						html += '</div>';
					html += '</div>';
					html += '<div class="form-group">';
						html += '<button type="button" id="button-add" class="btn btn-primary"><?php echo $button_add; ?></button> <button type="button" id="button-cancel" class="btn btn-danger"><?php echo $button_cancel; ?></button>';
					html += '</div>';
				html += '</div>';
				
				return html;
			}
		});

		$element.popover('show');
		
		$('#button-add').on('click', function() {
			var index = $element.data('index');
			var type = $('[name="type"]', '#control-form').val();
			var text = $('[name="text"]', '#control-form').val();
			var selector = $('[name="selector"]', '#control-form').val();
			var property = $('[name="property"]', '#control-form').val();
			var value = $('[name="value"]', '#control-form').val();
			var keyword = $('[name="keyword"]', '#control-form').val();
			var ref = $('[name="ref"]', '#control-form').val();
			
			$('.has-error', '#control-form').removeClass('has-error');
			
			if (text == '') {
				$('[name="text"]', '#control-form').parent().addClass('has-error');
				return false;
			}
			
			if (selector == '') {
				$('[name="selector"]', '#control-form').parent().addClass('has-error');
				return false;
			}
			
			if (property == '') {
				$('[name="property"]', '#control-form').parent().addClass('has-error');
				return false;
			}
			
			if (keyword == '') {
				$('[name="keyword"]', '#control-form').parent().addClass('has-error');
				return false;
			}
			
			if (type == 'select' && ref == '') {
				$('[name="ref"]', '#control-form').parent().addClass('has-error');
				return false;
			}
			
			if (type == 'select' && ref != '') {
				ref = JSON.parse(ref);
			} else {
				ref = '';
			}
			
			var html = '';
				html += '<li class="customizer-control customizer-control-text">';
					html += '<label><span class="customizer-control-title">' + text + '</span></label>';
					if (type == 'font') {
					html += '<select name="xml[<?php echo $i;?>][value][]" class="form-control" data-control="true">';
						html += '<option value="">Inherit</option>';
						<?php foreach($fonts as $font_key => $font_value){ ?>
						<?php $font_key = ($font_key == 'system') ? 'System Fonts' : 'Google Fonts'; ?>
						html += '<optgroup label="<?php echo $font_key; ?>">';
						<?php foreach($font_value as $font){ ?>
						html += '<option value="<?php echo $font['family']; ?>" data-category="<?php echo $font['category']; ?>"><?php echo $font['family']; ?></option>';
						<?php } ?>
						html += '</optgroup>';
						<?php } ?>
					html += '</select>';
					} else if (type == 'select') {
						html += '<select name="xml[' + index + '][value][]" class="form-control" data-control="true">';
							for (var i in ref) {
								html += '<option value="' + i + '">' + ref[i] + '</option>';
							}
						html += '</select>';
					} else if (type == 'color') {
						html += '<div class="customizer-control-content">';
							html += '<div class="picker-container"> <span class="picker-input-wrap">';
								html += '<input type="text" name="xml[' + index + '][value][]" class="color-picker-hex color-picker" maxlength="7" value="' + value + '" data-default-color="' + value + '" data-control="true" />';
								html += '<input type="button" class="button button-small hidden picker-default" value="<?php echo $entry_default; ?>" />';
								html += '</span>';
								html += '<div class="picker-holder"></div>';
							html += '</div>';
						html += '</div>';
					} else if (type == 'image') {
						html += '<div class="image"><a href="javascript:void(0);" id="thumb-' + keyword + '" class="img-thumbnail" data-toggle="image"> <img src="<?php echo $placeholder; ?>" id="src-' + keyword + '" width="100" height="100" data-placeholder="<?php echo $placeholder; ?>" alt="' + text + '" /> </a>';
							html += '<input type="hidden" name="xml[' + index + '][value][]" value="' + value + '" id="' + keyword + '" data-control="true" />';
						html += '</div>';
					}
					html += '<input type="hidden" name="xml[' + index + '][text][]" value="' + text + '" />';
					html += '<input type="hidden" name="xml[' + index + '][selector][]" value="' + selector + '" data-selector="' + selector + '" />';
					html += '<input type="hidden" name="xml[' + index + '][property][]" value="' + property + '" data-property="' + property + '" />';
					html += '<input type="hidden" name="xml[' + index + '][type][]" value="' + type + '" data-type="' + type + '" />';
					html += '<input type="hidden" name="xml[' + index + '][keyword][]" value="' + keyword + '" data-keyword="' + keyword + '" />';
					html += '<input type="hidden" name="xml[' + index + '][ref][]" value=\'' + ref + '\' data-ref="' + ref + '" />';
					html += '<a class="del-item"><i class="fa fa-times-circle"></i></a>';
				html += '</li>';
			
			$element.before(html);
			
			$('.color-picker').wpColorPicker();
			
			$element.popover('destroy');
		});
		
		$('#button-cancel').on('click', function() {
			$element.popover('destroy');
		});
	 });
	
	$(document).on('click', '.del-item', function(e) {
		var del = confirm('<?php echo $text_confirm; ?>');
		
		e.preventDefault();
		
		if (del){
			$(this).parent().remove();
		}
	});

	$.ajax({
		url: '<?php echo $frontend; ?>',
		type: 'post',
		beforeSend: function() {
			$('#customizer-preview').html('<div id="customizer-loading" class="text-center"><i class="fa fa-spinner fa-spin checkout-spin"></i></div>');
		},
		success: function(response) {
			$('#customizer-loading').remove();
			iframe = $('<iframe />').appendTo( $('#customizer-preview') );
			iframe[0].contentWindow.document.open();
			iframe[0].contentWindow.document.write( response );
			iframe[0].contentWindow.document.close();
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});

    $( "#customizer_stores" ).change(function() {
        window.location=($(this).val());
    });
});
//--></script>
</body>
</html>