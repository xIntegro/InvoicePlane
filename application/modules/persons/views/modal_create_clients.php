<script type="text/javascript">
    $(function () {
        // Display the create quote modal
        $('#create-person').modal('show');

        $('#create-quote').on('shown', function () {
            $("#client_name").focus();
        });

        $("#client_id").select2({
            placeholder: "<?php echo lang('select_person'); ?>",
            allowClear: true
        });


        $('#person_create_confirm').click(function () {
            console.log('clicked');
            $.ajax({
                url     :   "<?php echo site_url('persons/ajax/create'); ?>",
                type    :   "POST",
                data    :   $('#form1').serialize(),
                success  :   function(data) {
                    console.log(data);
                    var response = JSON.parse(data);
                    if(response.success=='1')
                    {
                        $('#msgdiv').addClass("alert alert-success").fadeOut(2000);
                        $('#msg').text("Person add success");
                        setTimeout(function(){
                            $("#create-person").hide();
                        }, 3000);
                        location.reload(true); //refresh page using jquery
                    }
                    else if(response.success=='2')
                    {
                        $('#msgdiv').addClass("alert alert-danger");
                        $('#msg').text("Person already selected");

                    }
                    else
                    {
                        $('.control-group').removeClass('has-error');
                        for (var key in response.validation_errors) {
                            $('#' + key).parent().parent().addClass('has-error');
                        }
                    }




                },
                error    :   function()
                {
                    alert('fail');
                }
            });


        });


    });

</script>

<div id="create-person" class="modal col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2"
     role="dialog" aria-labelledby="client-create-person" aria-hidden="true">



    <form class="modal-content" id="form1" method="post">
        <div class="modal-header">

            <a data-dismiss="modal" class="close"><i class="fa fa-close"></i></a>

            <h3><?php echo lang('add_client'); ?></h3>

        </div>
        <div class="modal-body">
            <div class="form-group">
                <div id="msgdiv">
                    <strong id="msg"></strong>
                </div>

            </div>
            <div class="form-group">
                <label for="person_name"><?php echo lang('select_person_name');?></label>
                <select name="person_id" id="person_id" class="form-control" required>
                    <option></option>
                    <?php
                    foreach ($persons as $person)
                    {
                        echo "<option value='".htmlentities($person->id)."' ";
                        if ($person_name == $person->first_name) echo 'selected';
                        echo ">".htmlentities($person->first_name)."</option>";
                    }
                    ?>

                </select>
            </div>


            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="client_name"><?php echo lang('client'); ?></label>
                        <select name="client_id" id="client_id" class="form-control">
                            <option></option>
                            <?php
                                foreach ($clients as $client)
                                {
                                    ?>
                                        <option value="<?php echo $client->client_id;?>"><?php echo $client->client_name;?></option>
                                    <?php
                                }
                            ?>
                        </select>



                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="email"><?php echo lang('email')?></label>
                        <input type="email" name="email" id="email" data-validation="email" required class="form-control">
                        <label id="person_email" style="color:red"></label>
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
