<script type="text/javascript">
    $(function()
    {
        $("#person_id").select2({
            placeholder: "<?php echo lang('select_person'); ?>",
            allowClear: true
        });
        $("#client_id").select2({
            allowClear: true
        });
    });
</script>
<form method="post">

    <div id="headerbar">
        <h1><?php echo lang('edit_person'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>
    <div id="content">
        <?php $this->layout->load_view('layout/alerts'); ?>
        <fieldset>
            <legend><?php echo lang('personal_information'); ?></legend>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                        <label><?php echo lang('client'); ?></label>
                        <select class="form-control" id="client_id" name="client_name">
                            <option></option>
                            <?php
                                foreach ($clients as $client)
                                {
                                    if($records->client_id==$client->client_id)
                                    {
                                        ?>
                                        <option value="<?php echo $client->client_id?>" selected><?php echo $client->client_name?></option>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <option value="<?php echo $client->client_id?>"><?php echo $client->client_name?></option>
                                        <?php
                                    }

                                }
                            ?>
                        </select>

                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php echo lang('select_person_name'); ?></label>
                            <select class="form-control" id="person_id" name="person_id">
                                <option></option>
                                <?php
                                    foreach ($persons as $person)
                                    {
                                        if($records->person_id==$person->id)
                                        {
                                            ?>
                                            <option value="<?php echo  $person->id;?>" selected><?php echo  $person->first_name;?></option>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <option value="<?php echo  $person->id;?>"><?php echo  $person->first_name;?></option>
                                            <?php
                                        }

                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email"><?php echo lang('email')?></label>
                            <input type="email" name="email" id="email" value="<?php echo $records->email?>" required class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="telephone"><?php echo lang('phone')?></label>
                            <input type="text" name="telephone_number" value="<?php echo $records->telephone_number?>" id="telephone_number" required class="form-control">
                        </div>

                    </div>
                </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="mobile"><?php echo lang('mobile')?></label>
                        <input type="text" name="mobile_number" value="<?php echo $records->mobile_number?>"  id="mobile_number" required maxlength="10" class="form-control">
                    </div>

                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="fax"><?php echo lang('fax')?></label>
                        <input type="text" name="fax" id="fax" value="<?php echo $records->fax?>" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="address"><?php echo lang('office_address')?></label>
                        <textarea name="office_address" id="office_address" class="form-control"><?php echo $records->office_address?></textarea>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</form>