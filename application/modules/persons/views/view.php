<div id="headerbar">
    <div class="pull-left">
        <h1><?php echo $persons[0]['first_name']; ?></h1>
    </div>
    <div class="pull-right">
        <a href="#" class="btn btn-sm btn-default person-create-client"
           data-person-name="<?php echo $persons[0]['first_name']; ?>">
            <i class="fa fa-user"></i> <?php echo lang('add_client'); ?>
        </a>
    </div>


</div>

<ul id="settings-tabs" class="nav nav-tabs nav-tabs-noborder">
    <li class="active"><a data-toggle="tab" href="#clientDetails"><?php echo lang('details'); ?></a></li>
    <li><a data-toggle="tab" href="#clientpersons"><?php echo lang('clients'); ?></a></li>

</ul>

<div class="tabbable tabs-below">

    <div class="tab-content">

        <div id="clientDetails" class="tab-pane tab-info active">

            <?php $this->layout->load_view('layout/alerts'); ?>

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
                    <h3><?php echo  $persons[0]['first_name'] ?></h3>

                    <p>
                        <?php echo ($persons[0]['home_no']) ? $persons[0]['home_no'] . '<br>' : ''; ?>
                        <?php echo ($persons[0]['home_address']) ? $persons[0]['home_address'] . '<br>' : ''; ?>
                        <?php echo ($persons[0]['street_address'])      ? $persons[0]['street_address'].'<br>' : ''; ?>
                        <?php echo ($persons[0]['city'])     ? $persons[0]['city'] : ''; ?>
                        <?php echo ($persons[0]['zipcode'])       ? $persons[0]['zipcode'] : ''; ?>
                        <?php echo ($persons[0]['country'])   ? '<br>' . $persons[0]['country'] : ''; ?>
                    </p>
                </div>

            </div>

            <hr>

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <h4><?php echo lang('contact_information'); ?></h4>
                    <br>
                    <table class="table table-condensed table-striped">
                        <?php if ($persons[0]['email_1']) : ?>
                            <tr>
                                <th><?php echo lang('email1'); ?></th>
                                <td><?php echo auto_link($persons[0]['email_1'], 'email'); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($persons[0]['email_2']) : ?>
                            <tr>
                                <th><?php echo lang('email2'); ?></th>
                                <td><?php echo auto_link($persons[0]['email_2'], 'email'); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($persons[0]['phone_number']) : ?>
                            <tr>
                                <th><?php echo lang('phone'); ?></th>
                                <td><?php echo $persons[0]['phone_number']; ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($persons[0]['mobile']) : ?>
                            <tr>
                                <th><?php echo lang('mobile'); ?></th>
                                <td><?php echo $persons[0]['mobile']; ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($persons[0]['fax']) : ?>
                            <tr>
                                <th><?php echo lang('fax'); ?></th>
                                <td><?php echo $persons[0]['fax']; ?></td>
                            </tr>
                        <?php endif; ?>

                    </table>
                </div>
                <div class="col-xs-12 col-md-6">
                    <h4><?php echo lang('bank_information'); ?></h4>
                    <br/>
                    <table class="table table-condensed table-striped">
                        <?php if ($persons[0]['bank_name']) : ?>
                            <tr>
                                <th><?php echo lang('bank_name'); ?></th>
                                <td><?php echo$persons[0]['bank_name']; ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($persons[0]['account_number']) : ?>
                            <tr>
                                <th><?php echo lang('bank_no'); ?></th>
                                <td><?php echo $persons[0]['account_number']; ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($persons[0]['bic']) : ?>
                            <tr>
                                <th><?php echo lang('bic'); ?></th>
                                <td><?php echo $persons[0]['bic']; ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($persons[0]['swift_code']) : ?>
                            <tr>
                                <th><?php echo lang('swift_code'); ?></th>
                                <td><?php echo $persons[0]['swift_code']; ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($persons[0]['bank_short_code']) : ?>
                            <tr>
                                <th><?php echo lang('bank_short'); ?></th>
                                <td><?php echo $persons[0]['bank_short_code']; ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($persons[0]['routing_number']) : ?>
                            <tr>
                                <th><?php echo lang('routing'); ?></th>
                                <td><?php echo $persons[0]['routing_number']; ?></td>
                            </tr>
                        <?php endif; ?>

                    </table>
                </div>
            </div>
        </div>
        <div id="clientpersons" class="tab-pane table-content">
            <?php echo $client_person_table; ?>
        </div>


    </div>

</div>