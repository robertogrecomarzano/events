<?php
User::logout();
header("Location: " . Config::$urlRoot);
die();