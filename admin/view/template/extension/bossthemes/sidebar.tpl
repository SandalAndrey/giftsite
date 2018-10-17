<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu">
      <li class="header"><?php echo $text_main; ?></li>
      <?php foreach ($menus as $menu) { ?>
      <li id="<?php echo $menu['id']; ?>" class="<?php echo ($menu['children']) ? 'treeview' : ''; ?> <?php echo ($menu['route'] == $route) ? 'active' : ''; ?>">
        <?php if ($menu['href']) { ?>
        <a href="<?php echo $menu['href']; ?>"><span><?php echo $menu['name']; ?></span>
        <?php if ($menu['children']) { ?>
        <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
        <?php } ?>
        </a>
        <?php }  else { ?>
        <a><span><?php echo $menu['name']; ?></span>
        <?php if ($menu['children']) { ?>
        <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
        <?php } ?>
        </a>
        <?php } ?>
        <?php if ($menu['children']) { ?>
        <ul class="treeview-menu">
          <?php foreach ($menu['children'] as $children_1) { ?>
          <li>
            <?php if ($children_1['href']) { ?>
            <a href="<?php echo $children_1['href']; ?>"><?php echo $children_1['name']; ?>
            <?php if ($children_1['children']) { ?>
            <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
            <?php } ?>
            </a>
            <?php } else { ?>
            <a><?php echo $children_1['name']; ?>
            <?php if ($children_1['children']) { ?>
            <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
            <?php } ?>
            </a>
            <?php } ?>
            <?php if ($children_1['children']) { ?>
            <ul class="treeview-menu">
              <?php foreach ($children_1['children'] as $children_2) { ?>
              <?php if ($children_2['href']) { ?>
              <a href="<?php echo $children_2['href']; ?>"><span><?php echo $children_2['name']; ?></span>
              <?php if ($children_2['children']) { ?>
              <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
              <?php } ?>
              </a>
              <?php } else { ?>
              <a><span><?php echo $children_2['name']; ?></span>
              <?php if ($children_2['children']) { ?>
              <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
              <?php } ?>
              </a>
              <?php } ?>
              <?php if ($children_2['children']) { ?>
              <ul class="treeview-menu">
                <?php foreach ($children_2['children'] as $children_3) { ?>
                <li><a href="<?php echo $children_3['href']; ?>"><?php echo $children_3['name']; ?></a></li>
                <?php } ?>
              </ul>
              <?php } ?>
              <?php } ?>
            </ul>
            <?php } ?>
          </li>
          <?php } ?>
        </ul>
        <?php } ?>
      </li>
      <?php } ?>
      <li class="header"><?php echo $text_module; ?></li>
      <?php foreach ($modules as $module) { ?>
      <li id="<?php echo $module['id']; ?>"> <a href="<?php echo $module['edit']; ?>"><span><?php echo $module['name']; ?></span></a> </li>
      <?php } ?>
    </ul>
  </section>
</aside>
