<?php echo $header; ?><?php echo $column_left; ?>

<div id="content" class="skin-blue"> <?php echo $topbar; ?> <?php echo $sidebar; ?>
  <div class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="pull-right">
        <button class="btn btn-flat btn-primary" form="bt-custom"><?php echo $button_save; ?></button>
      </div>
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
      <form action="<?php echo $action; ?>" enctype="multipart/form-data" method="post" id="bt-custom" class="form-horizontal">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-welcome" data-toggle="tab" aria-expanded="true"><?php echo $tab_welcome; ?></a></li>
            <li><a href="#tab-javascript" data-toggle="tab" aria-expanded="true"><?php echo $tab_javascript; ?></a></li>
            <li><a href="#tab-css" data-toggle="tab" aria-expanded="true"><?php echo $tab_css; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-welcome">
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-custom-welcome-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_custom[welcome][status]" id="boss-custom-welcome-status" <?php echo (isset($boss_custom['welcome']['status'])) ? 'checked="checked"' : '';?> />
                </div>
              </div>
              <ul class="nav nav-tabs">
                <?php foreach ($languages as $language) { ?>
                <li><a data-toggle="tab" href="#tab-welcome-<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div id="tab-welcome-<?php echo $language['language_id']; ?>" class="tab-pane">
                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="boss-custom-welcome-content-<?php echo $language['language_id']; ?>"><?php echo $entry_content; ?></label>
                    <div class="col-sm-9">
                      <textarea name="boss_custom[welcome][content][<?php echo $language['language_id']; ?>]" placeholder="<?php echo $entry_content; ?>"  id="boss-custom-welcome-content-<?php echo $language['language_id']; ?>" data-toggle="summernote"><?php echo isset($boss_custom['welcome']['content'][$language['language_id']]) ? $boss_custom['welcome']['content'][$language['language_id']]:''; ?></textarea>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
            <div class="tab-pane" id="tab-javascript">
              <textarea name="boss_custom[javascript]" id="javascript" class="form-control code" data-lang="javascript"><?php echo (isset($boss_custom['javascript'])) ? $boss_custom['javascript'] : ''; ?></textarea>
            </div>
            <div class="tab-pane" id="tab-css">
              <textarea name="boss_custom[css]" id="css" class="form-control code" data-lang="css"><?php echo (isset($boss_custom['css'])) ? $boss_custom['css'] : ''; ?></textarea>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>

<link href="view/javascript/codemirror/lib/codemirror.css" rel="stylesheet" />
<link href="view/javascript/codemirror/theme/monokai.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/codemirror/lib/codemirror.js"></script> 
<script type="text/javascript" src="view/javascript/codemirror/lib/xml.js"></script> 
<script type="text/javascript" src="view/javascript/codemirror/lib/formatting.js"></script> 
<script src="view/javascript/bossthemes/theme-manager/codemirror/mode/javascript/javascript.js"></script>
<script src="view/javascript/bossthemes/theme-manager/codemirror/mode/css/css.js"></script>
<script type="text/javascript"><!--
$(function() {
	$('.code').each(function(index, element) {
		$(this).parent().addClass('active');
		var editor = CodeMirror.fromTextArea(this, {
			mode: $(this).data('lang'),
			tabSize: 4,
			indentUnit: 4,
			indentWithTabs: true,
			lineNumbers: true,
			autofocus: true,
			theme: 'monokai'
		});
		editor.setSize(null, 768);
		$(this).parent().removeClass('active');
    });
});
//--></script>
<script type="text/javascript"><!--
$('.nav-tabs li:first-child a').tab('show');
//--></script> 
<?php echo $footer; ?>