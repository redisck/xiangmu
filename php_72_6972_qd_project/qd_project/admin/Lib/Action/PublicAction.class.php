<?php
	class PublicAction extends Action{
		public function verify(){
			import('ORG.Util.Image');
			Image::buildImageVerify();

		}
	
	}