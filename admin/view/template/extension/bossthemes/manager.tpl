<?php echo $header; ?><?php echo $column_left; ?>

<div id="content" class="skin-blue"> <?php echo $topbar; ?> <?php echo $sidebar; ?>
  <div class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="pull-right">
        <button class="btn btn-flat btn-primary" form="bt-manager"><?php echo $button_save; ?></button>
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
      <form action="<?php echo $action; ?>" enctype="multipart/form-data" method="post" id="bt-manager" class="form-horizontal">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab" aria-expanded="true"><?php echo $tab_general; ?></a></li>
            <li class=""><a href="#tab-product" data-toggle="tab" aria-expanded="false"><?php echo $tab_product; ?></a></li>
            <li class=""><a href="#tab-category" data-toggle="tab" aria-expanded="false"><?php echo $tab_category; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-manager-responsive"><?php echo $entry_responsive; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_manager[responsive]" value="1" id="boss-manager-responsive" <?php echo (isset($boss_manager['responsive'])) ? 'checked="checked"' : ''; ?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-manager-loading"><?php echo $entry_loading; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_manager[loading]" value="1" id="boss-manager-loading" <?php echo (isset($boss_manager['loading'])) ? 'checked="checked"' : ''; ?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-manager-animation"><?php echo $entry_animation; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_manager[animation]" value="1" id="boss-manager-animation" <?php echo (isset($boss_manager['animation'])) ? 'checked="checked"' : ''; ?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-manager-sticky-menu"><?php echo $entry_sticky_menu; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_manager[sticky_menu]" value="1" id="boss-manager-sticky-menu" <?php echo (isset($boss_manager['sticky_menu'])) ? 'checked="checked"' : ''; ?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-manager-button-to-top"><?php echo $entry_button_to_top; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_manager[button_to_top]" value="1" id="boss-manager-button-to-top" <?php echo (isset($boss_manager['button_to_top'])) ? 'checked="checked"' : ''; ?> />
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-product">
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-product-sharing"><?php echo $entry_sharing; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_product[sharing]" value="1" id="boss-product-sharing" <?php echo (isset($boss_product['sharing'])) ? 'checked="checked"' : ''; ?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-product-description"><?php echo $entry_description; ?></label>
                <div class="col-sm-3">
                  <select name="boss_product[description]" id="boss-product-description" class="form-control">
                    <option value="tab" <?php echo (isset($boss_product['description']) && $boss_product['description'] == 'tab') ? 'selected="selected"' : ''; ?>><?php echo $text_tab; ?></option>
                    <option value="collapse" <?php echo (isset($boss_product['description']) && $boss_product['description'] == 'collapse') ? 'selected="selected"' : ''; ?>><?php echo $text_collapse; ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-product-related"><?php echo $entry_related; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_product[related]" value="1" id="boss-product-related" <?php echo (isset($boss_product['related'])) ? 'checked="checked"' : ''; ?> />
                </div>
              </div>
              <div class="panel-group">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title"> <a data-toggle="collapse" href="#product-layout"> <?php echo $entry_product_layout; ?></a> </h4>
                  </div>
                  <div id="product-layout" class="panel-collapse collapse">
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="image"> <img src="view/image/bossthemes/product_layout/product_1.png" class="img-responsive" alt="Product 1"> </div>
                        <div class="text-center">
                          <input type="radio" name="boss_product[layout]" value="product_1" id="boss-product-related" <?php echo (isset($boss_product['layout']) && $boss_product['layout'] == 'product_1') ? 'checked="checked"' : ''; ?> />
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="image"> <img src="view/image/bossthemes/product_layout/product_2.png" class="img-responsive" alt="Product 2"> </div>
                        <div class="text-center">
                          <input type="radio" name="boss_product[layout]" value="product_2" id="boss-product-related" <?php echo (isset($boss_product['layout']) && $boss_product['layout'] == 'product_2') ? 'checked="checked"' : ''; ?> />
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="image"> <img src="view/image/bossthemes/product_layout/product_3.png" class="img-responsive" alt="Product 3"> </div>
                        <div class="text-center">
                          <input type="radio" name="boss_product[layout]" value="product_3" id="boss-product-related" <?php echo (isset($boss_product['layout']) && $boss_product['layout'] == 'product_3') ? 'checked="checked"' : ''; ?> />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="image"> <img src="view/image/bossthemes/product_layout/product_4.png" class="img-responsive" alt="Product 4"> </div>
                        <div class="text-center">
                          <input type="radio" name="boss_product[layout]" value="product_4" id="boss-product-related" <?php echo (isset($boss_product['layout']) && $boss_product['layout'] == 'product_4') ? 'checked="checked"' : ''; ?> />
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="image"> <img src="view/image/bossthemes/product_layout/product_5.png" class="img-responsive" alt="Product 5"> </div>
                        <div class="text-center">
                          <input type="radio" name="boss_product[layout]" value="product_5" id="boss-product-related" <?php echo (isset($boss_product['layout']) && $boss_product['layout'] == 'product_5') ? 'checked="checked"' : ''; ?> />
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="image"> <img src="view/image/bossthemes/product_layout/product_6.png" class="img-responsive" alt="Product 6"> </div>
                        <div class="text-center">
                          <input type="radio" name="boss_product[layout]" value="product_6" id="boss-product-related" <?php echo (isset($boss_product['layout']) && $boss_product['layout'] == 'product_6') ? 'checked="checked"' : ''; ?> />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-category">
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-category-info"><?php echo $entry_category_info; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_category[info]" value="1" id="boss-category-info" <?php echo (isset($boss_category['info'])) ? 'checked="checked"' : ''; ?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-category-refine_search"><?php echo $entry_refine_search; ?></label>
                <div class="col-sm-9">
                  <input type="checkbox" name="boss_category[refine_search]" value="1" id="boss-category-refine_search" <?php echo (isset($boss_category['refine_search'])) ? 'checked="checked"' : ''; ?> />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="boss-category-layout"><?php echo $entry_category_layout; ?></label>
                <div class="col-sm-3">
                  <select name="boss_category[layout]" id="boss-category-layout" class="form-control">
                    <option value="grid" <?php echo (isset($boss_category['layout']) && $boss_category['layout'] == 'grid') ? 'selected="selected"' : ''; ?>><?php echo $text_grid; ?></option>
                    <option value="list" <?php echo (isset($boss_category['layout']) && $boss_category['layout'] == 'list') ? 'selected="selected"' : ''; ?>><?php echo $text_list; ?></option>
                    <option value="table" <?php echo (isset($boss_category['layout']) && $boss_category['layout'] == 'table') ? 'selected="selected"' : ''; ?>><?php echo $text_table; ?></option>
                    <option value="grid_2" <?php echo (isset($boss_category['layout']) && $boss_category['layout'] == 'grid_2') ? 'selected="selected"' : ''; ?>><?php echo $text_grid_2; ?></option>
                    <option value="grid_3" <?php echo (isset($boss_category['layout']) && $boss_category['layout'] == 'grid_3') ? 'selected="selected"' : ''; ?>><?php echo $text_grid_3; ?></option>
                    <option value="grid_4" <?php echo (isset($boss_category['layout']) && $boss_category['layout'] == 'grid_4') ? 'selected="selected"' : ''; ?>><?php echo $text_grid_4; ?></option>
                    <option value="grid_6" <?php echo (isset($boss_category['layout']) && $boss_category['layout'] == 'grid_6') ? 'selected="selected"' : ''; ?>><?php echo $text_grid_6; ?></option>
                  </select>
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