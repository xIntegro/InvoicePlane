<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th><?php echo lang('person_name'); ?></th>
            <th><?php echo lang('email_address'); ?></th>
            <th><?php echo lang('mobile_number'); ?></th>
            <th><?php echo lang('phone_number'); ?></th>
            <th ><?php echo lang('bank_name'); ?></th>

            <th><?php echo lang('options'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($records as $person) : ?>

            <tr>
                <td><a href="<?php echo site_url('persons/view/'.$person->id);?>"><?php echo $person->first_name?></a></td>
                <td><?php echo $person->email_1?></td>
                <td><?php echo $person->mobile; ?></td>
                <td><?php echo $person->phone_number; ?></td>
                <td><?php echo $person->bank_name?></td>

                <td>
                    <div class="options btn-group">
                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-cog"></i> <?php echo lang('options'); ?>
                        </a>
                        <ul class="dropdown-menu">
<!--                            <li>-->
<!--                                <a href="--><?php //echo site_url('persons/view/' . $person->id); ?><!--">-->
<!--                                    <i class="fa fa-eye fa-margin"></i> --><?php //echo lang('view'); ?>
<!--                                </a>-->
<!--                            </li>-->
                            <li>
                                <a href="<?php echo site_url('persons/form/' . $person->id); ?>">
                                    <i class="fa fa-edit fa-margin"></i> <?php echo lang('edit'); ?>
                                </a>
                            </li>
<!--                            <li>-->
<!--                                <a href="#" class="client-create-quote"-->
<!--                                   data-client-name="--><?php //echo $client->client_name; ?><!--">-->
<!--                                    <i class="fa fa-file fa-margin"></i> --><?php //echo lang('create_quote'); ?>
<!--                                </a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a href="#" class="client-create-invoice"-->
<!--                                   data-client-name="--><?php //echo $client->client_name; ?><!--">-->
<!--                                    <i class="fa fa-file-text fa-margin"></i> --><?php //echo lang('create_invoice'); ?>
<!--                                </a>-->
<!--                            </li>-->
                            <li>
                                <a href="<?php echo site_url('persons/delete/' . $person->id); ?>"
                                   onclick="return confirm('<?php echo lang('delete_person_warning'); ?>');">
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