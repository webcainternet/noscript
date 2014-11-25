<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="button" onclick="$('#form-cmenu').attr('action', '<?php echo $action; ?>'); $('#form-cmenu').submit();" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <button type="button" onclick="$('#form-cmenu').attr('action', '<?php echo $action_exit; ?>'); $('#form-cmenu').submit();" data-toggle="tooltip" title="<?php echo $button_save_exit; ?>" class="btn btn-primary"><i class="fa fa-floppy-o"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
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
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-cmenu" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
            <?php foreach ($languages as $language) { ?>
              <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                <input type="text" name="cmenu_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($cmenu_description[$language['language_id']]) ? $cmenu_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" />
              </div>
              <?php if (isset($error_name[$language['language_id']])) { ?>
              <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
              <?php } ?>
            <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-link"><span data-toggle="tooltip" title="<?php echo $help_link; ?>"><?php echo $entry_link; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="link" value="<?php echo $link; ?>" placeholder="<?php echo $entry_link; ?>" id="input-link" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
              <table class="table">
                <tr>
                  <td><strong><?php echo $entry_route; ?></strong></td>
                  <td><select id="route">
                      <option value="http://"><?php echo $text_select; ?></option>
                      <?php foreach ($routes as $val => $route) { ?>
                      <option value="<?php echo $route; ?>"><?php echo $val; ?></option>
                      <?php } ?>
                    </select></td>
                </tr>
                <tr>
                  <td><strong><?php echo $entry_information; ?></strong></td>
                  <td><select id="information">
                      <option value="http://"><?php echo $text_select; ?></option>
                      <?php foreach ($informations as $val => $route) { ?>
                      <option value="<?php echo $route; ?>"><?php echo $val; ?></option>
                      <?php } ?>
                    </select></td>
                </tr>
                <tr>
                  <td><strong><?php echo $entry_category; ?></strong></td>
                  <td>
                    <select id="category">
                      <option value="http://"><?php echo $text_select; ?></option>
                      <?php foreach ($categories as $category) { ?>
                      <option value="<?php echo $http_catalog; ?>index.php?route=product/category&path=<?php echo $category['path']; ?>"><?php echo $category['name']; ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><strong><?php echo $entry_product; ?></strong></td>
                  <td>
                    <select id="product-category">
                      <option value="http://"><?php echo $text_select; ?></option>
                      <?php foreach ($categories as $category) { ?>
                      <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                      <?php } ?>
                    </select>
                    <br /><br />
                    <select id="product"><option value="http://"><?php echo $text_select; ?></option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><strong><?php echo $entry_manufacturer; ?></strong></td>
                  <td>
                    <select id="manufacturer">
                      <option value="http://"><?php echo $text_select; ?></option>
                      <?php foreach ($manufacturers as $manufacturer => $route) { ?>
                      <option value="<?php echo $route; ?>"><?php echo $manufacturer; ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-parent-cmenu"><?php echo $entry_parent_cmenu; ?></label>
            <div class="col-sm-10">
              <select name="parent_cmenu_id" id="input-parent-cmenu" class="form-control">
                <option value="0"><?php echo $text_none; ?></option>
                <?php foreach ($cmenus as $cmenu) { ?>
                <?php if($cmenu['cmenu_id'] != $cmenu_id) { ?>
                <option value="<?php echo $cmenu['cmenu_id']; ?>"<?php if ($cmenu['cmenu_id'] == $parent_cmenu_id) { ?> selected="selected"<?php } ?>><?php echo $cmenu['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-parent-category"><?php echo $entry_parent_category; ?></label>
            <div class="col-sm-10">
              <select name="parent_category_id" id="input-parent-category" class="form-control">
                <option value="0"><?php echo $text_none; ?></option>
                <?php foreach ($categories as $category) { ?>
                <option value="<?php echo $category['category_id']; ?>"<?php if ($category['category_id'] == $parent_category_id) { ?> selected="selected"<?php } ?>><?php echo $category['name']; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-column"><span data-toggle="tooltip" title="<?php echo $help_column; ?>"><?php echo $entry_column; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="column" value="<?php echo $column; ?>" placeholder="<?php echo $entry_column; ?>" id="input-column" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_popup; ?></label>
            <div class="col-sm-10">
              <label class="radio-inline">
                <input type="radio" name="popup" value="1"<?php if ($popup) { ?> checked="checked"<?php } ?> />
                <?php echo $text_yes; ?>                    
              </label>
              <label class="radio-inline">
                <input type="radio" name="popup" value="0"<?php if (!$popup) { ?> checked="checked"<?php } ?> />
                <?php echo $text_no; ?>                    
              </label>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_top; ?></label>
            <div class="col-sm-10">
              <label class="radio-inline">
                <input type="radio" name="top" value="1"<?php if ($top) { ?> checked="checked"<?php } ?> />
                <?php echo $text_yes; ?>                    
              </label>
              <label class="radio-inline">
                <input type="radio" name="top" value="0"<?php if (!$top) { ?> checked="checked"<?php } ?> />
                <?php echo $text_no; ?>                    
              </label>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_in_module; ?></label>
            <div class="col-sm-10">
              <label class="radio-inline">
                <input type="radio" name="in_module" value="1"<?php if ($in_module) { ?> checked="checked"<?php } ?> />
                <?php echo $text_yes; ?>                    
              </label>
              <label class="radio-inline">
                <input type="radio" name="in_module" value="0"<?php if (!$in_module) { ?> checked="checked"<?php } ?> />
                <?php echo $text_no; ?>                    
              </label>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_login; ?></label>
            <div class="col-sm-10">
              <label class="radio-inline">
                <input type="radio" name="login" value="1"<?php if ($login) { ?> checked="checked"<?php } ?> />
                <?php echo $text_yes; ?>                    
              </label>
              <label class="radio-inline">
                <input type="radio" name="login" value="0"<?php if (!$login) { ?> checked="checked"<?php } ?> />
                <?php echo $text_no; ?>                    
              </label>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_customer; ?></label>
            <div class="col-sm-10">
              <div class="well well-sm" style="height: 150px; overflow: auto;">
                <?php foreach ($customer_groups as $customer_group) { ?>
                <div class="checkbox">
                  <label>
                    <?php if (!empty($cmenu_customer_groups) && in_array($customer_group['customer_group_id'], $cmenu_customer_groups)) { ?>
                    <input type="checkbox" name="customer_group[]" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
                    <?php echo $customer_group['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="customer_group[]" value="<?php echo $customer_group['customer_group_id']; ?>" />
                    <?php echo $customer_group['name']; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
            <div class="col-sm-10">
              <div class="well well-sm" style="height: 150px; overflow: auto;">
                <div class="checkbox">
                  <label>
                    <?php if ((!empty($cmenu_stores) && in_array('0', $cmenu_stores)) || empty($cmenu_description)) { ?>
                    <input type="checkbox" name="store[]" value="0" checked="checked" />
                    <?php echo $text_default; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="store[]" value="0" />
                    <?php echo $text_default; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php foreach ($stores as $store) { ?>
                <div class="checkbox">
                  <label>
                    <?php if (!empty($cmenu_stores) && in_array($store['store_id'], $cmenu_stores)) { ?>
                    <input type="checkbox" name="store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                    <?php echo $store['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="store[]" value="<?php echo $store['store_id']; ?>" />
                    <?php echo $store['name']; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><span data-toggle="tooltip" title="<?php echo $help_sort; ?>"><?php echo $entry_sort; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                
                <option value="1"<?php if ($status) { ?> selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
                <option value="0"<?php if (!$status) { ?> selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
              </select>
            </div>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-12"><?php echo $myoc_copyright; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $("select#route").change(function() {
      $("input#input-link").val($(this).val());
    });
    $("select#information").change(function() {
      $("input#input-link").val($(this).val());
    });
    $("select#category").change(function() {
      $("input#input-link").val($(this).val());
    });
    $("select#manufacturer").change(function() {
      $("input#input-link").val($(this).val());
    });
    var category_products = [];
    <?php foreach ($category_products as $category_id => $products) { ?>
    category_products[<?php echo $category_id; ?>] = [];
    <?php foreach ($products as $product_id => $product) { ?>
    category_products[<?php echo $category_id; ?>][<?php echo $product_id; ?>] = "<?php echo $product; ?>";
    <?php } ?>
    <?php } ?>
    $("select#product-category").change(function() {
      $("select#product option").remove();
      $('<option value="http://"><?php echo $text_select; ?></option>').appendTo($("select#product"));
      for(var product_id in category_products[$(this).val()])
      {
        $('<option value="<?php echo $http_catalog; ?>index.php?route=product/product&product_id=' + product_id + '">' + category_products[$(this).val()][product_id] + '</option>').appendTo($("select#product"));
      }
      $("select#product").change(function() {
        $("input#input-link").val($(this).val());
      });
    });
});
</script>
<?php echo $footer; ?>