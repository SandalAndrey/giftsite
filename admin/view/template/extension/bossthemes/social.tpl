<?php echo $header; ?><?php echo $column_left; ?>

<div id="content" class="skin-blue"> <?php echo $topbar; ?> <?php echo $sidebar; ?>
  <div class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="pull-right">
        <button class="btn btn-flat btn-primary" form="bt-social"><?php echo $button_save; ?></button>
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
      <form action="<?php echo $action; ?>" enctype="multipart/form-data" method="post" id="bt-social" class="form-horizontal">
        <div class="panel panel-default">
          <div class="panel-body">
            <table id="social-value" class="table table-bordered table-hover dataTable">
              <thead>
                <tr>
                  <td class="text-left required"><?php echo $entry_name; ?></td>
                  <td class="text-left"><?php echo $entry_image; ?></td>
                  <td class="text-left"><?php echo $entry_icon; ?></td>
                  <td class="text-left"><?php echo $entry_link; ?></td>
                  <td class="text-left"><?php echo $entry_sort_order; ?></td>
                  <td></td>
                </tr>
              </thead>
              <tbody>
                <?php $boss_social_row = 0; ?>
                <?php foreach ($boss_socials as $boss_social) { ?>
                <tr id="social-value-row<?php echo $boss_social_row; ?>">
                  <td class="text-left"><?php foreach ($languages as $language) { ?>
                    <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                      <input type="text" name="boss_social[<?php echo $boss_social_row; ?>][name][<?php echo $language['language_id']; ?>]" value="<?php echo isset($boss_social['name'][$language['language_id']]) ? $boss_social['name'][$language['language_id']] : ''; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" />
                    </div>
                    <?php if (isset($error_boss_social[$boss_social_row][$language['language_id']])) { ?>
                    <div class="text-danger"><?php echo $error_boss_social[$boss_social_row][$language['language_id']]; ?></div>
                    <?php } ?>
                    <?php } ?></td>
                  <td class="text-left"><a href="" id="thumb-image<?php echo $boss_social_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $boss_social['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                    <input type="hidden" name="boss_social[<?php echo $boss_social_row; ?>][image]" value="<?php echo $boss_social['image']; ?>" id="input-image<?php echo $boss_social_row; ?>" /></td>
                  <td class="text-left"><div class="input-group"><span class="input-group-addon"></span><input type="text" name="boss_social[<?php echo $boss_social_row; ?>][icon]" value="<?php echo $boss_social['icon']; ?>" class="form-control icon-picker" /></div></td>
                  <td class="text-left"><input type="text" name="boss_social[<?php echo $boss_social_row; ?>][link]" value="<?php echo $boss_social['link']; ?>" class="form-control" /></td>
                  <td class="text-left"><input type="text" name="boss_social[<?php echo $boss_social_row; ?>][sort_order]" value="<?php echo $boss_social['sort_order']; ?>" class="form-control" /></td>
                  <td class="text-right"><button type="button" onclick="$('#social-value-row<?php echo $boss_social_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                </tr>
                <?php $boss_social_row++; ?>
                <?php } ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="5"></td>
                  <td class="text-right"><button type="button" onclick="addSocialValue();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
var boss_social_row = <?php echo $boss_social_row; ?>;

function addSocialValue() {
	html  = '<tr id="social-value-row' + boss_social_row + '">';
	html += '  <td class="text-left">';
	<?php foreach ($languages as $language) { ?>
	html += '    <div class="input-group">';
	html += '      <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span><input type="text" name="boss_social[' + boss_social_row + '][name][<?php echo $language['language_id']; ?>]" value="" placeholder="<?php echo $entry_name; ?>" class="form-control" />';
    html += '    </div>';
	<?php } ?>
	html += '  </td>';
    html += '  <td class="text-left"><a href="" id="thumb-image' + boss_social_row + '" data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="boss_social[' + boss_social_row + '][image]" value="" id="input-image' + boss_social_row + '" /></td>';
	html += '  <td class="text-left"><div class="input-group"><span class="input-group-addon"></span><input type="text" name="boss_social[' + boss_social_row + '][icon]" value="" placeholder="<?php echo $entry_icon; ?>" class="form-control icon-picker" /></div></td>';
	html += '  <td class="text-left"><input type="text" name="boss_social[' + boss_social_row + '][link]" value="" placeholder="<?php echo $entry_link; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><input type="text" name="boss_social[' + boss_social_row + '][sort_order]" value="0" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
	html += '  <td class="text-right"><button type="button" onclick="$(\'#social-value-row' + boss_social_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';	
	
	$('#social-value tbody').append(html);
	$('.icon-picker').iconpicker();
	
	boss_social_row++;
}

$(function() {
	$('.icon-picker').iconpicker();
});
//--></script> 
<?php echo $footer; ?>