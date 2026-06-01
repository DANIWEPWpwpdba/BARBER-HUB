<?php
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "OPCache cleared.<br>";
}
apcu_clear_cache();
echo "Cache cleared.";
