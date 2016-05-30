<script type="text/javascript">
    $(function () {
        // Display the create quote modal
        $('#create-person').modal('show');

        $('#create-quote').on('shown', function () {
            $("#client_name").focus();
        });
        $().ready(function () {
            $("[name='client_name']").select2();
            $("#client_name").focus();
        });

        $("#person_id").select2({
            placeholder: "<?php echo lang('select_person'); ?>",
            allowClear: true
        });
    });

</script>

<div id="create-person" class="modal col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2"
     role="dialog" aria-labelledby="client-create-person" aria-hidden="true">



    <form class="modal-content" id="form1" method="post">
        <div class="modal-header">

            <a data-dismiss="modal" class="close"><i class="fa fa-close"></i></a>

            <h3><?php echo lang('edit_person'); ?></h3>

        </div>
        <div class="modal-body">
            <div class="form-group">
                <div id="msgdiv">
                    <strong id="msg"></strong>
                </div>

            </div>
            <div class="form-group">
                <input type="text" value="<?php echo $person_id;?>">
            </div>
            <div class="form-group">
                <label for="client_name"><?php echo lang('client'); ?></label>
                <select name="client_name" id="client_name" class="form-control" autofocus="autofocus">
                    <?php
                    foreach ($clients as $client){
                        echo "<option value='".htmlentities($client->client_id)."' ";
                        if ($client_name == $client->client_name) echo 'selected';
                        echo ">".htmlentities($client->client_name)."</option>";
                    }
                    ?>
                </select>
            </div>


            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="person_name"><?php echo lang('select_person_name');?></label>
                        <select name="person_id" id="person_id" class="form-control" required>
                            <option></option>
                            <?php
                            foreach ($persons as $person)
                            {
                                ?>
                                <option value="<?php echo  $person->id?>"><?php echo $person->first_name;?></option>
                                <?php
                            }
                            ?>

                        </select>

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="email"><?php echo lang('email')?></label>
                        <input type="email" name="email" id="email" required class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="telephone"><?php echo lang('phone')?></label>
                        <input type="text" name="telephone_number" id="telephone_number" required class="form-control">
                    </div>

                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="mobile"><?php echo lang('mobile')?></label>
                        <input type="text" name="mobile_number" id="mobile_number" required maxlength="10" class="form-control">
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="fax"><?php echo lang('fax')?></label>
                        <input type="text" name="fax" id="fax" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="address"><?php echo lang('office_address')?></label>
                        <textarea name="office_address" id="office_address" class="form-control"></textarea>
                    </div>
                </div>
            </div>



        </div>

        <div class="modal-footer">
            <div class="btn-group">
                <button class="btn btn-danger" type="button" data-dismiss="modal">
                    <i class="fa fa-times"></i> <?php echo lang('cancel'); ?>
                </button>
                <button class="btn btn-success ajax-loader" name="s" id="person_create_confirm" type="button">
                    <i class="fa fa-check"></i> <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>

    </form>

</div>
