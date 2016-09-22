<?php

class TestController extends Q_Controller_Smarty{
	
	public function  indexAction(){
		
		$this->view->assign("id", 1234);
		
		echo $this->view->render("test/wap.tpl");
	}
	
}


?>