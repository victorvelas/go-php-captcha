<?php

if (!is_dir('../tmp_sessions')) {
    mkdir('/../tmp_sessions', 0777);
}
session_save_path(__DIR__ . '/../tmp_sessions');
session_id("GOPHPSESSION");
session_start();