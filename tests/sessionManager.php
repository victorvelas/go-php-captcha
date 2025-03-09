<?php

if (!is_dir(__DIR__.'../tmp_sessions')) {
    mkdir(__DIR__.'/../tmp_sessions', 0777);
}
session_save_path(__DIR__ . '/../tmp_sessions');
session_id("GOPHPSESSION");
session_start();