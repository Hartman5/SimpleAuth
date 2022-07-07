<?php
$conn = new mysqli("localhost", "Username", "Password", "DB_Name");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}