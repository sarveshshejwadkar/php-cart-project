<?php
include_once 'config.php';
$config_obj = new Configuration();
$configurations = $config_obj->customConfig();
?>
<script>
var MIN_PASSWORD_LENGTH = '<?php echo $configurations['MIN_PASSWORD']; ?>';
var MAX_PASSWORD_LENGTH = '<?php echo $configurations['MAX_PASSWORD']; ?>';
var NULL = '<?php echo $configurations['NULL']; ?>';
var ONE = '<?php echo $configurations['ONE']; ?>';
</script>