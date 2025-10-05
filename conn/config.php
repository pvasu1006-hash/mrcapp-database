<?php

try {
  $conn = new PDO("sqlite:../db/mrcglp_app.db");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {

  print("exception " . $e->getMessage());
}
