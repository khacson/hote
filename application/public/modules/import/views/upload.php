<script src="<?= url_tmpl() ?>js/jquery-1.7.2.min.js"></script>
<form id="frmForm" target="upload_target" action="<?=base_url()?>import/readexcel" method="post" enctype="multipart/form-data">
	<table>
		<tr>
			<td><input  name="myfile" id="myfile" type="file"/></td>
			<td><input type="submit" id="buttom" value="Import" /></td>
		</tr>
	</table>
</form>

<script type="text/javascript">
	$(function(){
		$("#buttom").click(function(){
			var myfile = $("#myfile");
			console.log(myfile);
			console.log(document.getElementById("myfile").path);
		});
		$("#myfile").change(function(evt){
			var files = evt.target.files[0];
			var reader = new FileReader();
			 reader.onload = (function (theFile) {
				 return function (e) { //size e = e.tatal
					console.log(e);	 
				 };
			 })(files);
			 reader.readAsDataURL(files);
		});
		/*
		//S Load Am thanh
		var url = "<?=base_url()?>files/beep-02.mp3";
		var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', url);
        audioElement.setAttribute('autoplay', 'autoplay');
        //audioElement.load()
        $.get();
        audioElement.addEventListener("load", function() {
            audioElement.play();
        }, true);
		setInterval(function(){
			audioElement.play();
		}, 1000);
		//E Load Am thanh
		*/
	});
</script>