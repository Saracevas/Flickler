<?php
  /* Getting variable */
  $id = $_POST['id'];

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
	  DELETE FROM savedImages WHERE ID ='$id';
EOF;

   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   }
   $db->close();
?>