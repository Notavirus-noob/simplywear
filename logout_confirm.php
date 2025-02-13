<?php
echo '<script>
    if (confirm("Please Logout first")) {
        window.location.href = "logout.php";
    } else {
        window.history.back();
    }
</script>';
?>
