<?php
require_once 'vendor/autoload.php';
require_once 'lib/images.php';

class ImageTest extends PHPUnit_Framework_TestCase {

	public function randomData() {
		for ($i=0;$i<=1000;$i++) {
			@session_start();
			@session_destroy();

			$images = new Images();
			$image_id = sprintf('%02d', rand(1,15));

			$vote = rand(1,2);

			if ($vote == "1") $vote = "down";
			else $vote = "up";

			$images->vote($image_id,$vote);
		}

	}

	public function testPercentages() {
		for ($i=1;$i<=15;$i++) {
			$images = new Images();
			extract (json_decode($images->getImageById($i),true));

			$testUp = round(($votesUp / ($votesUp + $votesDown) * 100),0);
			$testDown = round(($votesDown / ($votesUp + $votesDown) * 100),0);

			$this->assertEquals($testUp,$thumbsup);
			$this->assertEquals($testDown,$thumbsdown);

		}

	}

	public function testDuplicateVotes() {

		//makes sure that only one vote per image per session is allowed

		@session_start();
		@session_destroy();

		$image_id = sprintf('%02d', rand(1,15));
		$images = new Images();

		$imageData = json_decode($images->getImageById($image_id),true);

		$numVotes = $imageData['votesUp'] + $imageData['votesDown'];

		for ($i=0;$i<=100;$i++) {
			$images->vote($image_id,"up");
		}

		$newImageData = json_decode($images->getImageById($image_id),true);
		$newNumVotes = $newImageData['votesUp'] + $newImageData['votesDown'];

		$this->assertEquals($newNumVotes,($numVotes + 1));

	}

	public function clearTable() {
		$db = new Db("ratings");
		$q = "UPDATE `image` SET votesUp = 0, votesDown = 0";
		$db->q($q);
	}

}

$test = new ImageTest();

// $test->clearTable();

// $test->testDuplicateVotes();

// $test->randomData();

// $test->testPercentages();
?>