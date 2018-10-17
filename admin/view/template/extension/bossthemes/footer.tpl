<?php echo $header; ?><?php echo $column_left; ?>

<div id="content" class="skin-blue"> <?php echo $topbar; ?> <?php echo $sidebar; ?>
  <div class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="pull-right">
        <button class="btn btn-flat btn-primary" form="bt-footer"><?php echo $button_save; ?></button>
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
      <form action="<?php echo $action; ?>" enctype="multipart/form-data" method="post" id="bt-footer" class="form-horizontal">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab" aria-expanded="true"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-about-us" data-toggle="tab" aria-expanded="true"><?php echo $tab_about_us; ?></a></li>
            <li><a href="#tab-powered" data-toggle="tab" aria-expanded="true"><?php echo $tab_powered; ?></a></li>
            <li><a href="#tab-embed" data-toggle="tab" aria-expanded="true"><?php echo $tab_embed; ?></a></li>
            <li><a href="#tab-social" data-toggle="tab" aria-expanded="true"><?php echo $tab_social; ?></a></li>
            <li><a href="#tab-payment" data-toggle="tab" aria-expanded="true"><?php echo $tab_payment; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-footer-link-information"><?php echo $entry_information; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_footer[link][information]" value="1" id="boss-footer-link-information" <?php echo (isset($boss_footer['link']['information'])) ? 'checked="checked"' : '';?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-footer-link-contact-us"><?php echo $entry_contact_us; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_footer[link][contact_us]" value="1" id="boss-footer-link-contact-us" <?php echo (isset($boss_footer['link']['contact_us'])) ? 'checked="checked"' : '';?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-footer-link-site-map"><?php echo $entry_site_map; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_footer[link][site_map]" value="1" id="boss-footer-link-site-map" <?php echo (isset($boss_footer['link']['site_map'])) ? 'checked="checked"' : '';?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-footer-link-brands"><?php echo $entry_brands; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_footer[link][brands]" value="1" id="boss-footer-link-brands" <?php echo (isset($boss_footer['link']['brands'])) ? 'checked="checked"' : '';?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-footer-link-specials"><?php echo $entry_specials; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_footer[link][specials]" value="1" id="boss-footer-link-specials" <?php echo (isset($boss_footer['link']['specials'])) ? 'checked="checked"' : '';?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-footer-link-account"><?php echo $entry_account; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_footer[link][account]" value="1" id="boss-footer-link-account" <?php echo (isset($boss_footer['link']['account'])) ? 'checked="checked"' : '';?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-footer-link-return"><?php echo $entry_return; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_footer[link][return]" value="1" id="boss-footer-link-return" <?php echo (isset($boss_footer['link']['return'])) ? 'checked="checked"' : '';?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-footer-link-order"><?php echo $entry_order; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_footer[link][order]" value="1" id="boss-footer-link-order" <?php echo (isset($boss_footer['link']['order'])) ? 'checked="checked"' : '';?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-footer-link-wishlist"><?php echo $entry_wishlist; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_footer[link][wishlist]" value="1" id="boss-footer-link-wishlist" <?php echo (isset($boss_footer['link']['wishlist'])) ? 'checked="checked"' : '';?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-footer-link-gift-vouchers"><?php echo $entry_gift_vouchers; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_footer[link][gift_vouchers]" value="1" id="boss-footer-link-gift-vouchers" <?php echo (isset($boss_footer['link']['gift_vouchers'])) ? 'checked="checked"' : '';?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-footer-link-affiliates"><?php echo $entry_affiliates; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_footer[link][affiliates]" value="1" id="boss-footer-link-affiliates" <?php echo (isset($boss_footer['link']['affiliates'])) ? 'checked="checked"' : '';?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-footer-link-newsletter"><?php echo $entry_newsletter; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_footer[link][newsletter]" value="1" id="boss-footer-link-newsletter" <?php echo (isset($boss_footer['link']['newsletter'])) ? 'checked="checked"' : '';?> />
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-about-us">
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-footer-about-us-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_footer[about_us][status]" id="boss-footer-about-us-status" <?php echo (isset($boss_footer['about_us']['status'])) ? 'checked="checked"' : '';?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-footer-about-us-image"><?php echo $entry_image; ?></label>
                <div class="col-sm-9"> <a href="" id="thumb-about-us-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo (isset($boss_footer['about_us']['thumb'])) ? $boss_footer['about_us']['thumb'] : $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                  <input type="hidden" name="boss_footer[about_us][image]" id="boss-footer-about-us-image" value="<?php echo isset($boss_footer['about_us']['image']) ? $boss_footer['about_us']['image']:''; ?>" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-footer-about-us-link"><?php echo $entry_link; ?></label>
                <div class="col-sm-9">
                  <input type="text" name="boss_footer[about_us][link]" id="boss-footer-about-us-link" value="<?php echo isset($boss_footer['about_us']['link']) ? $boss_footer['about_us']['link'] : 'javascript:void(0)'; ?>" class="form-control" />
                </div>
              </div>
              <ul class="nav nav-tabs">
                <?php foreach ($languages as $language) { ?>
                <li><a data-toggle="tab" href="#tab-about-us-<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div id="tab-about-us-<?php echo $language['language_id']; ?>" class="tab-pane">
                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="boss-footer-about-us-title-<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
                    <div class="col-sm-9">
                      <input type="text" name="boss_footer[about_us][title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($boss_footer['about_us']['title'][$language['language_id']]) ? $boss_footer['about_us']['title'][$language['language_id']]:''; ?>" placeholder="<?php echo $entry_title; ?>" id="boss-footer-about-us-title-<?php echo $language['language_id']; ?>" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="boss-footer-about-us-content-<?php echo $language['language_id']; ?>"><?php echo $entry_content; ?></label>
                    <div class="col-sm-9">
                      <textarea name="boss_footer[about_us][content][<?php echo $language['language_id']; ?>]" placeholder="<?php echo $entry_content; ?>"  id="boss-footer-about-us-content-<?php echo $language['language_id']; ?>" data-toggle="summernote"><?php echo isset($boss_footer['about_us']['content'][$language['language_id']]) ? $boss_footer['about_us']['content'][$language['language_id']]:''; ?></textarea>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
            <div class="tab-pane" id="tab-powered">
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-footer-powered-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_footer[powered][status]" id="boss-footer-powered-status" <?php echo (isset($boss_footer['powered']['status'])) ? 'checked="checked"' : '';?> />
                </div>
              </div>
              <ul class="nav nav-tabs">
                <?php foreach ($languages as $language) { ?>
                <li><a data-toggle="tab" href="#tab-powered-<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div id="tab-powered-<?php echo $language['language_id']; ?>" class="tab-pane">
                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="boss-footer-powered-content-<?php echo $language['language_id']; ?>"><?php echo $entry_content; ?></label>
                    <div class="col-sm-9">
                      <textarea name="boss_footer[powered][content][<?php echo $language['language_id']; ?>]" placeholder="<?php echo $entry_content; ?>"  id="boss-footer-powered-content-<?php echo $language['language_id']; ?>" data-toggle="summernote"><?php echo isset($boss_footer['powered']['content'][$language['language_id']]) ? $boss_footer['powered']['content'][$language['language_id']]:''; ?></textarea>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
            <div class="tab-pane" id="tab-embed">
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-footer-embed-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_footer[embed][status]" id="boss-footer-embed-status" <?php echo (isset($boss_footer['embed']['status'])) ? 'checked="checked"' : '';?> />
                </div>
              </div>
              <ul class="nav nav-tabs">
                <?php foreach ($languages as $language) { ?>
                <li><a data-toggle="tab" href="#tab-embed-<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div id="tab-embed-<?php echo $language['language_id']; ?>" class="tab-pane">
                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="boss-footer-embed-title-<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
                    <div class="col-sm-9">
                      <input type="text" name="boss_footer[embed][title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($boss_footer['embed']['title'][$language['language_id']]) ? $boss_footer['embed']['title'][$language['language_id']]:''; ?>" placeholder="<?php echo $entry_title; ?>" id="boss-footer-embed-title-<?php echo $language['language_id']; ?>" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="boss-footer-embed-content-<?php echo $language['language_id']; ?>"><?php echo $entry_content; ?></label>
                    <div class="col-sm-9">
                      <textarea name="boss_footer[embed][content][<?php echo $language['language_id']; ?>]" placeholder="<?php echo $entry_content; ?>"  id="boss-footer-embed-content-<?php echo $language['language_id']; ?>" data-toggle="summernote"><?php echo isset($boss_footer['embed']['content'][$language['language_id']]) ? $boss_footer['embed']['content'][$language['language_id']]:''; ?></textarea>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
            <div class="tab-pane" id="tab-social">
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-footer-social-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_footer[social][status]" value="1" id="boss-footer-social-status" <?php echo (isset($boss_footer['social']['status'])) ? 'checked="checked"' : '';?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-footer-social-title-<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
                <div class="col-sm-9">
                  <?php foreach ($languages as $language) { ?>
                  <?php $language_id = $language['language_id']; ?>
                  <div class="input-group"> <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                    <input type="text" name="boss_footer[social][title][<?php echo $language_id; ?>]" value="<?php echo (isset($boss_footer['social']['title'][$language_id])) ? $boss_footer['social']['title'][$language_id] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="boss-footer-social-title-<?php echo $language_id; ?>" class="form-control" />
                  </div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-payment">
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-footer-payment-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_footer[payment][status]" value="1" id="boss-footer-payment-status" <?php echo (isset($boss_footer['payment']['status'])) ? 'checked="checked"' : '';?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-footer-payment-title-<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
                <div class="col-sm-9">
                  <?php foreach ($languages as $language) { ?>
                  <?php $language_id = $language['language_id']; ?>
                  <div class="input-group"> <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                    <input type="text" name="boss_footer[payment][title][<?php echo $language_id; ?>]" value="<?php echo (isset($boss_footer['payment']['title'][$language_id])) ? $boss_footer['payment']['title'][$language_id] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="boss-footer-payment-title-<?php echo $language_id; ?>" class="form-control" />
                  </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/summernote/summernote-image-attributes.js"></script> 
<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script> 
<script type="text/javascript"><!--
$('.nav-tabs li:first-child a').tab('show');
//--></script> 
<?php echo $footer; ?>