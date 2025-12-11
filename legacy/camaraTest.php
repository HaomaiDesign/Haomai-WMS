<video id="video" width="640" height="480" autoplay></video>

			
			<script type = "text/javascript">  
							
			
				window.onload = function(){ 
				  var video = document.getElementById('video');
					if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
					 navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
					 video.src = window.URL.createObjectURL(stream);
					 video.play();
					 });
					}
				}
					
			</script>