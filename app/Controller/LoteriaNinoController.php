<?php
class LoteriaNinoController extends AppController{

	public function index(){
		$this->layout = "empty";
		$this->render("index","empty");
	}
}
?>