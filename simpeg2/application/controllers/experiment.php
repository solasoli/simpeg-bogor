<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Experiment extends CI_Controller{

		function Index(){
			$this->load->library('email');
			
			$this->email->from('noreply@simpeg.kotabogor.go.id', 'noreply-simpeg');
			$this->email->to('vicky.vitriandi@gmail.com');
			//$this->email->cc('another@another-example.com');
			//$this->email->bcc('them@their-example.com');

			$this->email->subject('Email Test');
			$this->email->message('Testing the email class.');

			$this->email->send();

			echo $this->email->print_debugger();
			
		}
}
