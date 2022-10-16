<?php
$bdd = new PDO("mysql:host=database; port=3306; dbname=data;", "root", "root");
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
