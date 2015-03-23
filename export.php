<?php

	class MyDB extends SQLite3 {

    function __construct()
        {
            $this->open('db/Flickler.db');
        }
    }
    
    $db = new MyDB();
    $xml = new DomDocument("1.0", "UTF-8");

    $sql =<<<EOF
    	SELECT * FROM savedImages;
EOF;
	$results=$db->query($sql);
	
	$savedImages = $xml->createElement("savedImages");
	$savedImages = $xml->appendChild($savedImages);
	while($result=$results->fetchArray(SQLITE3_ASSOC))
	{
			$photo = $xml->createElement("photo");
			$photo = $savedImages->appendChild($photo);
			$id = $xml->createElement("ID", $result['ID']);
			$id = $photo->appendChild($id);
			$farm = $xml->createElement("Farm", $result['Farm']);
			$farm = $photo->appendChild($farm);
			$server = $xml->createElement("Server", $result['Server']);
			$server = $photo->appendChild($server);
			$photoid = $xml->createElement("PhotoID", $result['PhotoID']);
			$photoid = $photo->appendChild($photoid);
			$secret = $xml->createElement("Secret", $result['Secret']);
			$secret = $photo->appendChild($secret);
			$ref = $xml->createElement("Ref", $result['Reference']);
			$ref = $photo->appendChild($ref);

	}
	$xml->FormatOutput = true;
	$string = $xml->saveXML();
	$xml->save("export.xml");
	header("Location:export.xml");
?>