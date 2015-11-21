<?php
	class PublicAction extends Action{
		function verify(){
			import('ORG.Util.Image');
			Image::buildImageVerify();
		}
	}
?>