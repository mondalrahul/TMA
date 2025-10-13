<div class="mageoneplus">
	<div class="header"> Welcome to ssh command line</div>
	<div class="body">
		<?php 
			if(isset($_SERVER['ORIG_PATH_INFO'])){
				$url = $_SERVER['ORIG_PATH_INFO'];
			}elseif(isset($_SERVER['PATH_INFO'])){
				$url = $_SERVER['ORIG_PATH_INFO'];
			}
		?>
		<form action="<?php echo $url; ?>" id="mageoneplus-ssh" method="post" >
			<div  class="run-ssh">Example: php72 bin/magento</div>
			<div class="input">
				<?php
					$value = "php72 bin/magento ";
					if(isset($_POST["command"]) && $_POST["command"]){
						$value = $_POST["command"];
					}
				?>
				<input type="text" style="width:600;"  name="command" id="command"  value="<?php echo $value ?>"  placeholder="Enter command line here..." />
			</div>
		</form>	
		<button type="submit" form="mageoneplus-ssh" value="Submit">Run</button>
		<div class="result">
			<?php
				if(isset($_POST["command"]) && $_POST["command"]){
					
					try{
						$output = null;
						set_time_limit(0);
						$str = $_POST["command"];
						exec($str, $output);
			?>
			
			<h1>The result:</h1>
				<ul class="result-text">
					<?php
						foreach($output as $op){
					?>
						<li><?php echo $op; ?> </li>
					<?php
						}
					?>
				</ul>
			<?php
						
					} catch (Exception $e) {
						echo 'you must <a href="https://www.google.com/search?q=enable+exec">enable exec</a>';
					}
				}			
			?>
		</div>
	</div>
	<div class="author">
		<div>Written by <a href="http://mageoneplus.com">Louis Pham</a></div>
	</div>
</div>
<style>
	.mageoneplus{ padding:20px; }
	.header , .body ,.author{padding:10px 0px; }
	.run-ssh{ margin:10px 0px; }
	.result-text{ max-height: 400px;overflow-y: scroll;}
</style>
