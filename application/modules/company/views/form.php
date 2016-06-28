<form method="post">
    <div id="headerbar">
        <!--        <h1>--><?php //echo lang('client_form'); ?><!--</h1>-->
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>
    <div id="content">
        <?php $this->layout->load_view('layout/alerts'); ?>
        <input class="hidden" name="is_update" type="hidden"
            <?php if ($this->mdl_company->form_value('is_update')) {
                echo 'value="1"';
            } else {
                echo 'value="0"';
            } ?>
        >
        <div class="col-xs-12 col-sm-12">
            <fieldset>
                <legend><?php echo lang('company_information'); ?></legend>
                <div class="form-group">
                    <label><?php echo lang('company_name')?></label>
                    <div class="controls">
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($this->mdl_company->form_value('name'))?>" class="form-control">
                    </div>
                </div>
            </fieldset>
        </div>
    </div>


</form>