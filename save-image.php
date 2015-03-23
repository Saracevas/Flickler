<?php
  /* Getting variables */
  $farm = $_POST['farm'];
  $server = $_POST['server'];
  $photoID = $_POST['id'];
  $secret = $_POST['secret'];
  $reference = $_POST['reference'];

class MyDB extends SQLite3 {

    function __construct()
        {
            $this->open('db/Flickler.db');
        }
    }
    
    $db = new MyDB();

    if(!$db){
        echo $db->lastErrorMsg();
    }
    /* If table doesn't exist, create one, afterwards populate it with provided values */
    $sql =<<<EOF
      CREATE TABLE IF NOT EXISTS savedImages
      (ID       INTEGER PRIMARY KEY  NOT NULL,
      Farm      INTEGER              NOT NULL,
      Server    INTEGER              NOT NULL,
      PhotoID   INTEGER              NOT NULL,
      Secret    VARCHAR(60)          NOT NULL,
      Reference VARCHAR(60)
      );
	    INSERT INTO savedImages VALUES (null, '$farm', '$server', '$photoID', '$secret', '$reference');
EOF;

   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   }
   $db->close();
?>