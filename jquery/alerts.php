<!--ÉXITOSO-->
<script>
    $(function() {
        <?php
        if(isset($_SESSION['success']))
        {
        echo  $_SESSION['success']; ;
        }?>
    });
    <?php unset($_SESSION['success']); ?>

</script>

<!-- ERROR-->
<script>
    $(function() {
        <?php
        if(isset($_SESSION['error']))
        {
        echo  $_SESSION['error']; ;
        }?>
    });
    <?php unset($_SESSION['error']); ?>

</script>

<script>
    $(function() {
        <?php
        if(isset($_SESSION['log_out']))
        {
        echo  $_SESSION['log_out']; ;
        }?>
    });
    <?php unset($_SESSION['log_out']); ?>

</script>
