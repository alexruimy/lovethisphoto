<?php
/*
Don't You Love This Photo?
Code Test: Alex Ruimy
March 11, 2014

hello. you're probably wondering why i called this meeting.

what we have here is a class to store vote data on images, 
kind of like a hotornot script.

there is a super simple database wrapper that i'm using (i 
wrote it) for familiarity and speed. its methods are 
i = insert, d = delete, a = fetch assoc, q = query, etc

*/
session_start();

require_once("lib/mysql.php");

class Images {
	
	private $dir = "gallery/"; //location of image files. make sure to add trailing slash
	private $db = "ratings"; //name of database

	public function __construct() {
		/*
		creates the session array to store images we have voted on
		*/

		if (!isset($_SESSION['voted'])) $_SESSION['voted'] = array();
	}

	public function vote($image_id,$vote) {
		/*
		$vote can be 'up' or 'down'
		returns 1 if a vote is successful ($vote), or if we have already voted
		*/

		//check the session to see if we've voted on this image
		if (!in_array($image_id,$_SESSION['voted'])) {

			if (!is_numeric($image_id)) exit();

			$db = new Db($this->db);
			$field = ($vote == "up") ? "votesUp" : "votesDown";
			$q = "UPDATE `image` SET {$field} = {$field} + 1 WHERE id = \"$image_id\" LIMIT 1";

			if ($db->q($q)) {
				$_SESSION['voted'][] = $image_id;
				return "1";
			}
			else {
				return "0";
			}
		}

		else {
			return "1";
		}
	}

	public function getImageById($image_id=false) {
		/*
		returns json with the image id, full path,
		number of votes up and down,
		those same numbers as percentages
		and the next and previous image to load
		*/

		if ($image_id && !is_numeric($image_id)) exit("invalid image id");

		$db = new Db($this->db);
		
		$q = "SELECT *,
		FORMAT(( votesUp / (votesUp + votesDown)) * 100,0) as thumbsup,
		FORMAT(( votesDown / (votesUp + votesDown)) * 100,0) as thumbsdown
		FROM `image` ";

		//get the first image in the db if no id is specified
		if ($image_id) $q.= "WHERE id = \"{$image_id}\"";
		else $q.= "ORDER BY id LIMIT 1";

		$a = $db->a($q);

		if (count($a) == 0) exit("image not found");

		$a = current($db->a($q));

		if (!$image_id) $image_id = $a['id'];

		$a['file'] = $this->dir . $a['file'];

		$prevNext = $this->getPrevNext($image_id);
		$a['prev'] = $prevNext['prev'];
		$a['next'] = $prevNext['next'];

		if ($a['thumbsup'] == "") $a['thumbsup'] = "0";
		if ($a['thumbsdown'] == "") $a['thumbsdown'] = "0";

		list($a['width'], $a['height']) = getimagesize($a['file']);

		$a['voted'] = (in_array($image_id,$_SESSION['voted'])) ? true : false;

		return json_encode($a);
	}

	public function scan() {
		/*
		scans the directory set in the class' property,
		adds images files to the database
		*/

		$this->removeMissing();

		if ($handle = opendir($this->dir)) {
			
			$rc = 0;

			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != "..") {
					$path_parts = pathinfo($this->dir . $entry);

					//make sure we're only adding image files
					switch (strtolower($path_parts['extension'])) {
						case "jpeg":
						case "jpg":
						case "gif":
						case "png":

						$this->addToDb($entry);
						$rc++;

						break;
					}
				}
			}
			closedir($handle);
		}

		$s = ($rc == "1") ? "" : "s";
		return "Scanned {$rc} file{$s}";;
	}

	private function removeMissing() {
		/*
		an extension of the scan method, this will 
		remove images that are listed in the db but not 
		in the folder
		*/

		$db = new Db($this->db);
		$q = "SELECT id,file FROM `image`";
		$a = $db->a($q);

		foreach ($a as $row) {
			extract($row);
			if (!file_exists($this->dir . $file)) {
				$del['id'] = $id;
				$db->d("image",$del);
			}
		}
	}

	private function getPrevNext($image_id) {
		/*
		given an image id, this method returns the 
		previous and next images in line.
		*/
		$db = new Db($this->db);

		//prev
		$q = "SELECT id FROM `image` WHERE id < \"$image_id\" ORDER BY id DESC LIMIT 1";

		$a = $db->a($q);

		//if we're at the first image, return the id of the last image
		if (count($a) == 0) {
			$q = "SELECT id FROM `image` ORDER BY id DESC LIMIT 1";
			$a = $db->a($q);
		}

		$ret['prev'] = $a[0]['id'];

		//next
		$q = "SELECT id FROM `image` WHERE id > \"$image_id\" ORDER BY id LIMIT 1";

		$a = $db->a($q);

		//if we're at the last image, return the id of the first image
		if (count($a) == 0) {
			$q = "SELECT id FROM `image` ORDER BY id LIMIT 1";
			$a = $db->a($q);
		}

		$ret['next'] = $a[0]['id'];

		return $ret;
	}

	private function addToDb($file) {
		/*
		adds an image path to the database.
		`file` is a unique field
		*/
		$db = new Db($this->db);

		$insert['file'] = $file;

		//the third parameter is for ignore
		if ($db->i("image",$insert,true)) return true;
	}

}