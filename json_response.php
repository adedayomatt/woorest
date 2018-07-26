<?php
/*
@Author: Adedayo Matthews
@Created: 26/07/2018
@Last Modified: 26/07/2018
*/
class Response{
	private $json_cards = array(); 
	
	//To check if functions that require array as param	
	private function is_param_array($param){
		if(!is_array($param)){
			$this->text("Invalid parameter, cannot reply with appropriate message");
			return false;
		}else{
			return true;
		}
	}
	
	//Print the JSON message
	public function send(){
		echo json_encode(array("messages" => $this->json_cards));
	}
	private function append_card($card){
		$this->json_cards[] = $card;
	}
	
	private function prepared_file($type,$url){
			$prepared_file = array("attachment" => 
										array("type" => $type,"payload" => 
												array("url" => $url)));
												return $prepared_file;
	}
	private function extract_buttons($buttons){
					$btns = array();
					foreach($buttons as $button){
						if($button['type'] == 'web_url'){
							$btn = array("type" => "web_url","url" => $button['url'],"title" => $button['title']);
						}else if($button['type'] == 'show_block'){
							$btn = array("type" => "show_block","block_names" => $button['block'],"title" => $button['title']);
						}else if($button['type'] == 'phone_number'){
							$btn = array("type" => "phone_number","phone_number" => $button['phone'],"title" => $button['title']);
						}
						$btns[] = $btn;
					}
			return $btns;
	}
	

	//Text	
	public function text($msg){
		$this->append_card(array("text" => $msg));
		}
		
	//Text with Button
	public function text_button($text,$buttons){
		$text_button = array("attachment" => 
								array("type" => "template","payload" => 
									array("template_type" => "button","text" => $text,"buttons" => $this->extract_buttons($buttons))));
									$this->append_card($text_button);
	}
		
	//Image
	public function image($url){
			$this->append_card($this->prepared_file('image',$url));
	}

	//Image
	public function video($url){
			$this->append_card($this->prepared_file('video',$url));
			}
	
	//Audio
	public function audio($url){
			$this->append_card($this->prepared_file('audio',$url));			
			}
			
	//Document
	public function file($url){
			$this->append_card($this->prepared_file('file',$url));			
			}
	
	//Gallery
	public function gallery($data){
		$gallery_elements = array();
		foreach($data as $datum){
			$gallery_elements[] = array("title" => $datum['title'],"subtitle" => $datum['subtitle'],"image_url" => $datum['image'], "buttons" => $this->extract_buttons($datum['buttons']));
		}
		
		$gallery = array("attachment" =>
							array("type" => "template", "payload" => 
								array("template_type" => "generic","image_aspect_ratio" => "square", "elements" => 
									$gallery_elements )));
									$this->append_card($gallery);
	}
	//List
	public function listing($data){
		$list_elements = array();
		
		foreach($data as $datum){
			$list_elements[] = array("title" => $datum['title'],"subtitle" => $datum['subtitle'],"image_url" => $datum['image'], "default_action"=>$datum['default_action'],"buttons" => $this->extract_buttons($datum['buttons']));
		}
		
		$list = array("attachment" =>
							array("type" => "template", "payload" => 
								array("template_type" => "list","top_element_style" => "large", "elements" => 
									$list_elements )));
									$this->append_card($list);	
									}
		
	
}



function test(){

$sample_buttons = array(
					array("title"=>"Sample Button1","type"=>"web_url","url"=>"https://rockets.chatfuel.com/assets/welcome.png"),
					array("title"=>"Sample Button2","type"=>"phone_number","phone"=>"08139004572"),
					array("title"=>"Sample Button3","type"=>"show_block","block"=>["live chat"]));
					
$response = new Response();
$response->text("This is a single response");
//$response->text("This is a multiple response 1");
//$response->text("This is a multiple response 2");
//$response->text("This is a multiple response 3");
$response->text_button('This is a text with buttons',$sample_buttons);
$response->image('https://rockets.chatfuel.com/assets/welcome.png');
$response->video('https://rockets.chatfuel.com/assets/video.mp4');
$response->audio('https://rockets.chatfuel.com/assets/hello.mp3');
$response->file('https://rockets.chatfuel.com/assets/ticket.pdf');

$gallery = array(array("title"=>"G1","subtitle"=>"subtitle for G1","image"=>"http://rockets.chatfuel.com/assets/shirt.jpg",
				"default_action"=>array("type"=>"web_url","url"=>"https://rockets.chatfuel.com/store","messenger_extentions"=>true),
				"buttons"=>array(
					array("title"=>"G1 Button1","type"=>"web_url","url"=>"https://rockets.chatfuel.com/assets/welcome.png"),
					array("title"=>"G1 Button2","type"=>"phone_number","phone"=>"08139004572"),
					array("title"=>"G1 Button3","type"=>"show_block","block"=>["live chat"]))),
				//
				array("title"=>"G2","subtitle"=>"subtitle for G2","image"=>"http://rockets.chatfuel.com/assets/shirt.jpg",
				"default_action"=>array("type"=>"web_url","url"=>"https://rockets.chatfuel.com/store","messenger_extentions"=>true),
				"buttons"=>array(
					array("title"=>"G2 Button1","type"=>"web_url","url"=>"https://rockets.chatfuel.com/assets/welcome.png"),
					array("title"=>"G2 Button2","type"=>"phone_number","phone"=>"08139004572"),
					array("title"=>"G2 Button3","type"=>"show_block","block"=>["live chat"]))));

					$response->gallery($gallery);
					$response->text("Same gallery in List format....");
					
					$response->listing($gallery);

					$response->send();

}

