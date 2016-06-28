<script>
    $(function(){
        $('#category_name').focus();
    });
</script>

<form method="post">
    <div id="headerbar">
        <h1><?php echo lang('category_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>
    <div id="content">
        <?php $this->layout->load_view('layout/alerts'); ?>
        <input class="hidden" name="is_update" type="hidden" value="<?php echo $record[0]['id'];?>">

        <div class="col-xs-12 col-sm-12">
            <fieldset>
                <legend><?php echo lang('category_information'); ?></legend>
                <div class="form-group">
                    <label class="checkbox-inline">
                        <input type="checkbox" name="is_active" id="person_active" value="1" <?php if ($record[0]['is_active'] == 1
                            or !is_numeric($record[0]['is_active'])                                    ) {
                            echo 'checked="checked"';
                        } ?>>Active
                    </label>
                </div>
                <div class="form-group">
                    <label><?php echo lang('category_name')?></label>
                    <div class="controls">
                       <input type="text" id="category_name" name="category_name" value="<?php echo $record[0]['category_name'];?>" class="form-control">
                    </div>
                </div>




            </fieldset>
        </div>


    </div>
</form>