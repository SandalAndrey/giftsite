<?php echo $header; ?><?php echo $column_left; ?>

<div id="content" class="skin-blue"> <?php echo $topbar; ?> <?php echo $sidebar; ?>
  <div class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="pull-right">
        <button class="btn btn-flat btn-primary" form="bt-header"><?php echo $button_save; ?></button>
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
      <form action="<?php echo $action; ?>" enctype="multipart/form-data" method="post" id="bt-header" class="form-horizontal">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab" aria-expanded="true"><?php echo $tab_general; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-header-mega-menu"><?php echo $entry_mega_menu; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_header[mega_menu]" value="1" id="boss-header-mega-menu" <?php echo (isset($boss_header['mega_menu'])) ? 'checked="checked"' : ''; ?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-header-link-logo"><?php echo $entry_link_logo; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_header[link][logo]" value="1" id="boss-header-link-logo" <?php echo (isset($boss_header['link']['logo'])) ? 'checked="checked"' : ''; ?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-header-link-language"><?php echo $entry_link_language; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_header[link][language]" value="1" id="boss-header-link-language" <?php echo (isset($boss_header['link']['language'])) ? 'checked="checked"' : ''; ?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-header-link-currency"><?php echo $entry_link_currency; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_header[link][currency]" value="1" id="boss-header-link-currency" <?php echo (isset($boss_header['link']['currency'])) ? 'checked="checked"' : ''; ?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-header-link-mini-cart"><?php echo $entry_link_mini_cart; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_header[link][mini_cart]" value="1" id="boss-header-link-mini-cart" <?php echo (isset($boss_header['link']['mini_cart'])) ? 'checked="checked"' : ''; ?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-header-link-search"><?php echo $entry_link_search; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_header[link][search]" value="1" id="boss-header-link-search" <?php echo (isset($boss_header['link']['search'])) ? 'checked="checked"' : ''; ?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-header-link-phone"><?php echo $entry_link_phone; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_header[link][phone]" value="1" id="boss-header-link-phone" <?php echo (isset($boss_header['link']['phone'])) ? 'checked="checked"' : ''; ?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-header-link-account"><?php echo $entry_link_account; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_header[link][account]" value="1" id="boss-header-link-account" <?php echo (isset($boss_header['link']['account'])) ? 'checked="checked"' : ''; ?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-header-link-wishlist"><?php echo $entry_link_wishlist; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_header[link][wishlist]" value="1" id="boss-header-link-wishlist" <?php echo (isset($boss_header['link']['wishlist'])) ? 'checked="checked"' : ''; ?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-header-link-shopping-cart"><?php echo $entry_link_shopping_cart; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_header[link][shopping_cart]" value="1" id="boss-header-link-shopping-cart" <?php echo (isset($boss_header['link']['shopping_cart'])) ? 'checked="checked"' : ''; ?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-header-link-checkout"><?php echo $entry_link_checkout; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_header[link][checkout]" value="1" id="boss-header-link-checkout" <?php echo (isset($boss_header['link']['checkout'])) ? 'checked="checked"' : ''; ?> />
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>