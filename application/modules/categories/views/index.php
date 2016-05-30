<div id="headerbar">

    <h1><?php echo lang('category_title'); ?></h1>

    <div class="pull-right">
        <button type="button" class="btn btn-default btn-sm submenu-toggle hidden-lg"
                data-toggle="collapse" data-target="#ip-submenu-collapse">
            <i class="fa fa-bars"></i> <?php echo lang('submenu'); ?>
        </button>
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('categories/form'); ?>">
            <i class="fa fa-plus"></i> <?php echo lang('new'); ?>
        </a>
    </div>

    <div class="pull-right visible-lg">
        <?php echo pager(site_url('categories/status/' . $this->uri->segment(3)), 'category_model'); ?>

    </div>

    <div class="pull-right visible-lg">
        <ul class="nav nav-pills index-options">
            <li <?php if ($this->uri->segment(3) == 'active' or !$this->uri->segment(3)) : ?>class="active"<?php endif; ?>>
                <a href="<?php echo site_url('categories/status/active'); ?>"><?php echo lang('active'); ?></a>
            </li>
            <li <?php if ($this->uri->segment(3) == 'inactive') : ?>class="active"<?php endif; ?>>
                <a href="<?php echo site_url('categories/status/inactive'); ?>"><?php echo lang('inactive'); ?></a>
            </li>
            <li <?php if ($this->uri->segment(3) == 'all') : ?>class="active"<?php endif; ?>>
                <a href="<?php echo site_url('categories/status/all'); ?>"><?php echo lang('all'); ?></a>
            </li>
        </ul>
    </div>

</div>

<?php if ($this->session->flashdata('alert_success')) { ?>
    <div class="alert alert-success"><?php echo $this->session->flashdata('alert_success'); ?></div>
<?php } ?>

<div id="submenu">
    <div class="collapse clearfix" id="ip-submenu-collapse">

        <div class="submenu-row">
            <?php echo pager(site_url('categories/status/' . $this->uri->segment(3)), 'category_model'); ?>
        </div>

        <div class="submenu-row">
            <ul class="nav nav-pills index-options">
                <li <?php if ($this->uri->segment(3) == 'active' or !$this->uri->segment(3)) : ?>class="active"<?php endif; ?>>
                    <a href="<?php echo site_url('categories/status/active'); ?>"><?php echo lang('active'); ?></a>
                </li>
                <li <?php if ($this->uri->segment(3) == 'inactive') : ?>class="active"<?php endif; ?>>
                    <a href="<?php echo site_url('categories/status/inactive'); ?>"><?php echo lang('inactive'); ?></a>
                </li>
                <li <?php if ($this->uri->segment(3) == 'all') : ?>class="active"<?php endif; ?>>
                    <a href="<?php echo site_url('categories/status/all'); ?>"><?php echo lang('all'); ?></a>
                </li>
            </ul>
        </div>

    </div>
</div>
<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div id="filter_results">
        <?php $this->layout->load_view('categories/partial_category_table'); ?>
    </div>

</div>
