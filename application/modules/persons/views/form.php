<script>
    $(function(){
        $("#Country").select2({
            placeholder: "<?php echo lang('country'); ?>",
            allowClear: true
        });
    });

</script>
<form method="post">
    <div id="headerbar">
        <h1><?php echo lang('person_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>
    <div class="content">
        <?php $this->layout->load_view('layout/alerts'); ?>
        <input class="hidden" name="is_update" type="hidden" value="<?php echo $record[0]['id']; ?>">

        <div class="col-xs-12 col-sm-6">
            <fieldset>
                <legend><?php echo lang('personal_information'); ?></legend>
                <div class="form-group">
                    <label class="checkbox-inline">
                        <input type="checkbox" name="person_active" id="person_active"
                               value="1" <?php if ($record[0]['person_active'] == 1
                            or !is_numeric($record[0]['person_active'])
                        ) {
                            echo 'checked="checked"';
                        } ?>>Active
                    </label>
                </div>
                <div class="form-group">
                    <label><?php echo lang('title') ?></label>
                    <div class="controls">
                        <select name="title" class="form-control">
                            <?php
                            $person_title = array('Mr', 'Miss', 'Mrs');
                            foreach ($person_title as $p_title) {
                                if ($record[0]['title'] == $p_title) {
                                    ?>
                                    <option value="<?php echo $p_title ?>"
                                            selected="selected"><?php echo $p_title ?></option>
                                    <?php
                                } else {
                                    ?>
                                    <option value="<?php echo $p_title ?>"><?php echo $p_title ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label><?php echo lang('first_name') ?></label>
                            <div class="controls">
                                <input type="text" name="first_name" value="<?php echo $record[0]['first_name'] ?>"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label><?php echo lang('middle_name') ?></label>
                            <div class="controls">
                                <input type="text" name="middle_name" value="<?php echo $record[0]['middle_name'] ?>"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label><?php echo lang('last_name') ?></label>
                            <div class="controls">
                                <input type="text" name="last_name" value="<?php echo $record[0]['last_name'] ?>"
                                       class="form-control">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label><?php echo lang('birthday') ?></label>
                            <div class="controls">
                                <input type="text" name="Birthday" value="<?php echo $record[0]['birthday'] ?>"
                                       class="form-control datepicker">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label><?php echo lang('city_birthday') ?></label>
                            <div class="controls">
                                <input type="text" name="Birth_Place" value="<?php echo $record[0]['birth_place'] ?>"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label><?php echo lang('nationality') ?></label>
                            <div class="controls">
                                <input type="text" name="Nationality" value="<?php echo $record[0]['nationality'] ?>"
                                       class="form-control">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label><?php echo lang('gender') ?></label>
                            <div class="controls">
                                <select name="gender" class="form-control">
                                    <?php
                                    $genders = array('Male', 'Female');
                                    foreach ($genders as $gender) {
                                        if ($record[0]['gender'] == $gender) {
                                            ?>
                                            <option name="<?php echo $gender ?>"
                                                    selected="selected"><?php echo $gender ?></option>
                                            <?php
                                        } else {
                                            ?>
                                            <option name="<?php echo $gender ?>"><?php echo $gender ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-xs-12 col-sm-6">
            <fieldset>
                <legend><?php echo lang('contact_information'); ?></legend>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label><?php echo lang('home_no') ?></label>
                            <div class="controls">
                                <input type="text" name="Home_No" value="<?php echo $record[0]['home_no'] ?>"
                                       class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label><?php echo lang('home_address') ?></label>
                            <div class="controls">
                                <input type="text" name="home_address" value="<?php echo $record[0]['home_address'] ?>"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label><?php echo lang('street_address') ?></label>
                            <div class="controls">
                                <input type="text" name="street_address"
                                       value="<?php echo $record[0]['street_address'] ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label><?php echo lang('city') ?></label>
                            <div class="controls">
                                <input type="text" name="City" value="<?php echo $record[0]['city'] ?>"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label><?php echo lang('country') ?></label>
                            <div class="controls">
                                <select name="Country" id="Country" class="form-control">
                                    <option></option>
                                    <?php foreach ($countries as $cldr => $country) { ?>
                                        <option value="<?php echo $cldr; ?>"
                                            <?php if ($record[0]['country'] == $cldr) {
                                                echo 'selected="selected"';
                                            } ?>
                                        ><?php echo $country ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label><?php echo lang('zip') ?></label>
                            <div class="controls">
                                <input type="text" name="zipcode" value="<?php echo $record[0]['zipcode'] ?>"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label><?php echo lang('email1') ?></label>
                            <div class="controls">
                                <input type="text" name="Email_1" value="<?php echo $record[0]['email_1'] ?>"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label><?php echo lang('email2') ?></label>
                            <div class="controls">
                                <input type="text" name="Email_2" value="<?php echo $record[0]['email_2'] ?>"
                                       class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label><?php echo lang('fax') ?></label>
                            <div class="controls">
                                <input type="text" name="Fax" class="form-control"
                                       value="<?php echo $record[0]['fax'] ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php echo lang('mobile') ?></label>
                            <div class="controls">
                                <input type="text" name="Mobile" value="<?php echo $record[0]['mobile'] ?>"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php echo lang('phone') ?></label>
                            <div class="controls">
                                <input type="text" name="phone_number" value="<?php echo $record[0]['phone_number'] ?>"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-xs-12 col-sm-12">
            <fieldset>
                <legend><?php echo lang('bank_information'); ?></legend>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php echo lang('bank_name') ?></label>
                            <div class="controls">
                                <input type="text" name="bank_name" value="<?php echo $record[0]['bank_name'] ?>"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php echo lang('bank_no') ?></label>
                            <div class="controls">
                                <input type="text" name="account_number"
                                       value="<?php echo $record[0]['account_number'] ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php echo lang('bic') ?></label>
                            <div class="controls">
                                <input type="text" name="bic" value="<?php echo $record[0]['bic'] ?>"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php echo lang('swift_code') ?></label>
                            <div class="controls">
                                <input type="text" name="swift_code" value="<?php echo $record[0]['swift_code'] ?>"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php echo lang('bank_short') ?></label>
                            <div class="controls">
                                <input type="text" name="bank_short_code"
                                       value="<?php echo $record[0]['bank_short_code'] ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php echo lang('routing') ?></label>
                            <div class="controls">
                                <input type="text" name="routing_number"
                                       value="<?php echo $record[0]['routing_number'] ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>

        </div>

    </div>
</form>