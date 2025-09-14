<?php
function is_admin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
}

function is_seller() {
    return isset($_SESSION['is_seller']) && $_SESSION['is_seller'] == 1;
}
?>