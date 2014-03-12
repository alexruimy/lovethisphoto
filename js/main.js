$(function() {
	var next;
	var prev;
	var cur;

	$('#prev').click(function() {
		getPrevImage();
	});

	$('#next').click(function() {
		getNextImage();
	});

	$('#voteUp').click(function() {
		if (!$(this).hasClass('voted')) {
			voteUp();
		}
	});

	$('#voteDown').click(function() {
		if (!$(this).hasClass('voted')) {
			voteDown();
		}
	});

	getImageById(0);

	function getImageById(id) {
		$.getJSON("getimage.php?id=" + id,function(data) {

			//console.log(data);

			$('#image').attr("src",data.file);
			$('#ratingUp').empty().html(data.thumbsup + "%");
			$('#ratingDown').empty().html(data.thumbsdown + "%");

			if (data.voted == true) {
				$('.vote').addClass("voted");	
			}
			else {
				$('.vote').removeClass("voted");				
			}

			prev = data.prev;
			next = data.next;
			cur = data.id;

		});

	}

	function getPrevImage() {
		getImageById(prev)

	}

	function getNextImage() {
		getImageById(next);
	}

	function voteUp() {
		$.get("vote.php?id=" + cur + "&v=up",function(data) {
			getNextImage();
		});
	}

	function voteDown() {
		$.get("vote.php?id=" + cur + "&v=down",function(data) {
			getNextImage();
		});
	}

});