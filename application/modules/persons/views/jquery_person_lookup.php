<script>
    $(function () {
        // Performs the lookup against current personss in the database
        $('#client_name').keypress(function () {
            var self = $(this);

            $.post('<?php echo site_url('persons/ajax/name_query'); ?>', {
                query: self.val()
            }, function (data) {
                var json_response = eval('(' + data + ')');
                self.data('typeahead').source = json_response;
            });
        });
    });
</script>