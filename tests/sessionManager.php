<?php

session_save_path(__DIR__ . '/../tmp_sessions');
session_id("GOPHPSESSION");
session_start();