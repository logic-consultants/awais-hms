<?php
// Check GD functions
if (function_exists('gd_info')) {
    print_r(gd_info());
} else {
    echo "GD extension is not working.";
}
?>
