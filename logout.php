<?php
  unset($_SESSION['id']);
  unset($_SESSION['type']);
  redirect("?p=login");
