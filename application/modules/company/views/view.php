<div style="margin-top:30px;">
    <ul id="settings-tabs" class="nav nav-tabs nav-tabs-noborder">
        <li class="active"><a data-toggle="tab" href="#companylist"><?php echo lang('companies'); ?></a></li>
        <li><a data-toggle="tab" href="#userAccount"><?php echo lang('useraccounts'); ?></a></li>
    </ul>
</div>
<div class="tabbable tabs-below">

    <div class="tab-content">
        <div id="companylist" class="tab-pane tab-info active">
            <div class="col-xs-12">
                <div class="pull-left">
                    <?php echo lang('companies'); ?>
                </div>
                <div class="pull-right" style="margin-bottom:5px;">
                    <a href="<?php echo site_url('company/form') ?>" class="btn btn-primary"><span
                            class="fa fa-plus"></span>
                        <?php echo lang('new'); ?></a>
                </div>
            </div>
            <div id="filter_results">
                <?php $this->layout->load_view('company/partial_company_table'); ?>
            </div>


        </div>
        <div id="userAccount" class="tab-pane table-content">
            <div class="col-xs-12">
                <div class="pull-left">
                    <?php echo lang('user'); ?>
                </div>
                <div class="pull-right">
                    <a href="<?php echo site_url('users/form') ?>" class="btn btn-primary"><span
                            class="fa fa-plus"></span>
                        <?php echo lang('new'); ?></a>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th><?php echo lang('name'); ?></th>
                    <th><?php echo lang('user_type'); ?></th>
                    <th><?php echo lang('email_address'); ?></th>
                    <th><?php echo lang('options'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($users as $user) {
                    ?>
                    <tr>
                        <td><?php echo $user->user_name; ?></td>
                        <td><?php echo $user_types[$user->user_type]; ?></td>
                        <td><?php echo $user->user_email; ?></td>
                        <td>
                            <div class="options btn-group">
                                <a class="btn btn-sm btn-default dropdown-toggle"
                                   data-toggle="dropdown" href="#">
                                    <i class="fa fa-cog"></i> <?php echo lang('options'); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo site_url('users/form/' . $user->user_id); ?>">
                                            <i class="fa fa-edit fa-margin"></i> <?php echo lang('edit'); ?>
                                        </a>
                                    </li>
                                    <?php if ($user->user_id <> 1) { ?>
                                        <li>
                                            <a href="<?php echo site_url('users/delete/' . $user->user_id); ?>"
                                               onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');">
                                                <i class="fa fa-trash-o fa-margin"></i> <?php echo lang('delete'); ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>

            </table>
        </div>
    </div>
</div>