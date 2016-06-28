<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th><?php echo lang('category_name'); ?></th>


            <th><?php echo lang('options'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($records as $category) : ?>

            <tr>
                <td><?php echo $category->category_name?></td>


                <td>
                    <div class="options btn-group">
                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-cog"></i> <?php echo lang('options'); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('categories/form/' . $category->id); ?>">
                                    <i class="fa fa-edit fa-margin"></i> <?php echo lang('edit'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('categories/delete/' . $category->id); ?>"
                                   onclick="return confirm('<?php echo lang('delete_category_warning'); ?>');">
                                    <i class="fa fa-trash-o fa-margin"></i> <?php echo lang('delete'); ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>