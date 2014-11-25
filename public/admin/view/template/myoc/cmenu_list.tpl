<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_insert; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" onclick="$('#form-cmenu').attr('action', '<?php echo $copy; ?>'); $('#form-cmenu').submit();" data-toggle="tooltip" title="<?php echo $button_copy; ?>" class="btn btn-default"><i class="fa fa-copy"></i></button>
        <button type="button" onclick="$('#form-cmenu').attr('action', '<?php echo $delete; ?>'); confirm('<?php echo $text_confirm; ?>') ? $('#form-cmenu').submit() : false;" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
        <button type="submit" form="form-cmenu" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
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
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $save; ?>" method="post" enctype="multipart/form-data" id="form-cmenu">
    	    <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
                <td class="text-left"><?php if ($sort == 'cd.name') { ?>
                  <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                  <?php } ?></td>
                <td class="text-right"><?php if ($sort == 'c.sort_order') { ?>
                  <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a>
                  <?php } ?></td>
                <td class="text-right"><?php echo $column_status; ?></td>
                <td class="text-right"><?php echo $column_action; ?></td>
              </tr>
            </thead>
            <tbody>
              <?php if ($cmenus) { ?>
              <?php foreach ($cmenus as $cmenu) { ?>
              <tr>
                <td class="text-center">
                  <input type="checkbox" name="selected[]" value="<?php echo $cmenu['cmenu_id']; ?>"<?php if ($cmenu['selected']) { ?> checked="checked"<?php } ?> />
                  </td>
                <td class="text-left"><?php echo $cmenu['name']; ?></td>
                <td class="text-right"><input type="text" name="cmenu[<?php echo $cmenu['cmenu_id']; ?>][sort_order]" value="<?php echo $cmenu['sort_order']; ?>" size="4" /></td>
                <td class="text-right"><?php echo $cmenu['status']; ?></td>
                <td class="text-right"><a href="<?php echo $cmenu['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
              </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
                <td class="text-center" colspan="5"><?php echo $text_no_results; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
        <div class="row">
          <div class="col-sm-12 text-left"><?php echo $myoc_copyright; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>