<table class="table table-striped">
    <tr>
        <th><?php echo lang('company_name');?></th>
    </tr>
    <?php
    foreach ($companies as $company) {
        ?>
        <tr>
            <td>
                <?php echo $company->name; ?>
            </td>
        </tr>
        <?php
    }
    ?>

</table>