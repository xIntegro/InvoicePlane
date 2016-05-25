<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th><?php echo lang('client_name'); ?></th>
            <th><?php echo lang('phone'); ?></th>
            <th><?php echo lang('mobile'); ?></th>
            <th><?php echo lang('fax'); ?></th>
            <th><?php echo lang('office_address');?></th>
            <th><?php echo lang('options')?></th>

        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($clients as $client)
        {
            ?>
            <tr>

                <td>
                    <?php echo $client->client_name;?>
                </td>
                <td><?php echo $client->telephone_number;?></td>
                <td><?php echo $client->mobile_number;?></td>
                <td><?php echo $client->email;?></td>
                <td><?php echo $client->office_address;?></td>
                <td>
                    <div class="options btn-group">
                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-cog"></i> <?php echo lang('options'); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('persons/clientEdit/'.$client->person_id.'/'.$client->client_id);?>" >
                                    <i class="fa fa-edit fa-margin"></i> <?php echo lang('edit'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('persons/clientDelete/' . $client->person_id.'/'.$client->client_id); ?>"
                                   onclick="return confirm('<?php echo lang('delete_client_warning'); ?>');">
                                    <i class="fa fa-trash-o fa-margin"></i> <?php echo lang('delete'); ?>
                                </a>
                            </li>
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