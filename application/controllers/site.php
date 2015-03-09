<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_Controller 
{
	public function __construct( )
	{
		parent::__construct();
		
		$this->is_logged_in();
	}
	function is_logged_in( )
	{
		$is_logged_in = $this->session->userdata( 'logged_in' );
		if ( $is_logged_in !== 'true' || !isset( $is_logged_in ) ) {
			redirect( base_url() . 'index.php/login', 'refresh' );
		} //$is_logged_in !== 'true' || !isset( $is_logged_in )
	}
	function checkaccess($access)
	{
		$accesslevel=$this->session->userdata('accesslevel');
		if(!in_array($accesslevel,$access))
			redirect( base_url() . 'index.php/site?alerterror=You do not have access to this page. ', 'refresh' );
	}
	public function index()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$data[ 'page' ] = 'dashboard';
		$data[ 'title' ] = 'Welcome';
		$this->load->view('template', $data);	
	}
	public function createuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
//        $data['category']=$this->category_model->getcategorydropdown();
		$data[ 'page' ] = 'createuser';
		$data[ 'title' ] = 'Create User';
		$this->load->view( 'template', $data );	
	}
	function createusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
            $data['category']=$this->category_model->getcategorydropdown();
            $data[ 'page' ] = 'createuser';
            $data[ 'title' ] = 'Create User';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $password=$this->input->post('password');
            $accesslevel=$this->input->post('accesslevel');
            $status=$this->input->post('status');
            $socialid=$this->input->post('socialid');
            $logintype=$this->input->post('logintype');
            $json=$this->input->post('json');
//            $category=$this->input->post('category');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
            
			if($this->user_model->create($name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json)==0)
			$data['alerterror']="New user could not be created.";
			else
			$data['alertsuccess']="User created Successfully.";
			$data['redirect']="site/viewusers";
			$this->load->view("redirect",$data);
		}
	}
    function viewusers()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewusers';
        $data['base_url'] = site_url("site/viewusersjson");
        
		$data['title']='View Users';
		$this->load->view('template',$data);
	} 
    function viewusersjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`user`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`user`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`user`.`email`";
        $elements[2]->sort="1";
        $elements[2]->header="Email";
        $elements[2]->alias="email";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`user`.`socialid`";
        $elements[3]->sort="1";
        $elements[3]->header="SocialId";
        $elements[3]->alias="socialid";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`logintype`.`name`";
        $elements[4]->sort="1";
        $elements[4]->header="Logintype";
        $elements[4]->alias="logintype";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`user`.`json`";
        $elements[5]->sort="1";
        $elements[5]->header="Json";
        $elements[5]->alias="json";
       
        $elements[6]=new stdClass();
        $elements[6]->field="`accesslevel`.`name`";
        $elements[6]->sort="1";
        $elements[6]->header="Accesslevel";
        $elements[6]->alias="accesslevelname";
       
        $elements[7]=new stdClass();
        $elements[7]->field="`statuses`.`name`";
        $elements[7]->sort="1";
        $elements[7]->header="Status";
        $elements[7]->alias="status";
       
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `user` LEFT OUTER JOIN `logintype` ON `logintype`.`id`=`user`.`logintype` LEFT OUTER JOIN `accesslevel` ON `accesslevel`.`id`=`user`.`accesslevel` LEFT OUTER JOIN `statuses` ON `statuses`.`id`=`user`.`status`");
        
		$this->load->view("json",$data);
	} 
    
    
	function edituser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
		$data['page']='edituser';
		$data['page2']='block/userblock';
		$data['title']='Edit User';
		$this->load->view('template',$data);
	}
	function editusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','trim|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
			$data['before']=$this->user_model->beforeedit($this->input->post('id'));
			$data['page']='edituser';
//			$data['page2']='block/userblock';
			$data['title']='Edit User';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            $email=$this->input->get_post('email');
            $password=$this->input->get_post('password');
            $accesslevel=$this->input->get_post('accesslevel');
            $status=$this->input->get_post('status');
            $socialid=$this->input->get_post('socialid');
            $logintype=$this->input->get_post('logintype');
            $json=$this->input->get_post('json');
//            $category=$this->input->get_post('category');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
            
            if($image=="")
            {
            $image=$this->user_model->getuserimagebyid($id);
               // print_r($image);
                $image=$image->image;
            }
            
			if($this->user_model->edit($id,$name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json)==0)
			$data['alerterror']="User Editing was unsuccesful";
			else
			$data['alertsuccess']="User edited Successfully.";
			
			$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->deleteuser($this->input->get('id'));
//		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="User Deleted Successfully";
		$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
	function changeuserstatus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->changestatus($this->input->get('id'));
		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="Status Changed Successfully";
		$data['redirect']="site/viewusers";
        $data['other']="template=$template";
        $this->load->view("redirect",$data);
	}
    
    
    
     public function viewplan()
    {
    $access=array("1");
    $this->checkaccess($access);
    $data["page"]="viewplan";
    $data["base_url"]=site_url("site/viewplanjson");
    $data["title"]="View plan";
    $this->load->view("template",$data);
    }
    function viewplanjson()
    {
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`campaign_plan`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        $elements[1]=new stdClass();
        $elements[1]->field="`campaign_plan`.`Name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="Name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`campaign_plan`.`Duration`";
        $elements[2]->sort="1";
        $elements[2]->header="Duration";
        $elements[2]->alias="Duration";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`campaign_plan`.`Amount`";
        $elements[3]->sort="1";
        $elements[3]->header="Amount";
        $elements[3]->alias="Amount";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`campaign_plan`.`numberofcampaigns`";
        $elements[4]->sort="1";
        $elements[4]->header="Number Of Campaigns";
        $elements[4]->alias="numberofcampaigns";
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
        $maxrow=20;
        }
        if($orderby=="")
        {
        $orderby="id";
        $orderorder="ASC";
        }
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `campaign_plan`");
        $this->load->view("json",$data);
    }

    public function createplan()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="createplan";
        $data["title"]="Create plan";
        $this->load->view("template",$data);
    }
    public function createplansubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("Name","Name","trim|required");
        $this->form_validation->set_rules("Duration","Duration","trim|required");
        $this->form_validation->set_rules("Amount","Amount","trim|required");
        $this->form_validation->set_rules("numberofcampaigns","Number Of Campaigns","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createplan";
            $data["title"]="Create plan";
            $this->load->view("template",$data);
        }
        else
        {
            $Name=$this->input->get_post("Name");
            $Duration=$this->input->get_post("Duration");
            $Amount=$this->input->get_post("Amount");
            $numberofcampaigns=$this->input->get_post("numberofcampaigns");
            if($this->plan_model->create($Name,$Duration,$Amount,$numberofcampaigns)==0)
            $data["alerterror"]="New plan could not be created.";
        else
            $data["alertsuccess"]="plan created Successfully.";
            $data["redirect"]="site/viewplan";
            $this->load->view("redirect",$data);
        }
    }
    public function editplan()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="editplan";
        $data["title"]="Edit plan";
        $data["before"]=$this->plan_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
    }
    public function editplansubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
        $this->form_validation->set_rules("Name","Name","trim");
        $this->form_validation->set_rules("Duration","Duration","trim");
        $this->form_validation->set_rules("Amount","Amount","trim");
        $this->form_validation->set_rules("numberofcampaigns","Number Of Campaigns","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="editplan";
            $data["title"]="Edit plan";
            $data["before"]=$this->plan_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $Name=$this->input->get_post("Name");
            $Duration=$this->input->get_post("Duration");
            $Amount=$this->input->get_post("Amount");
            $numberofcampaigns=$this->input->get_post("numberofcampaigns");
            if($this->plan_model->edit($id,$Name,$Duration,$Amount,$numberofcampaigns)==0)
            $data["alerterror"]="New plan could not be Updated.";
        else
            $data["alertsuccess"]="plan Updated Successfully.";
            $data["redirect"]="site/viewplan";
            $this->load->view("redirect",$data);
        }
    }
    public function deleteplan()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->plan_model->delete($this->input->get("id"));
        $data["redirect"]="site/viewplan";
        $this->load->view("redirect",$data);
    }
    public function vieworder()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="vieworder";
        $data["base_url"]=site_url("site/vieworderjson");
        $data["title"]="View order";
        $this->load->view("template",$data);
    }
    function vieworderjson()
    {
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`campaign_order`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";

        $elements[1]=new stdClass();
        $elements[1]->field="`user`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="user";
        $elements[1]->alias="user";

        $elements[2]=new stdClass();
        $elements[2]->field="`plan`.`name`";
        $elements[2]->sort="1";
        $elements[2]->header="Plan";
        $elements[2]->alias="Plan";
        //    
        $elements[3]=new stdClass();
        $elements[3]->field="`orderstatus`.`name`";
        $elements[3]->sort="1";
        $elements[3]->header="Status";
        $elements[3]->alias="status";
            
        $elements[4]=new stdClass();
        $elements[4]->field="`campaign_order`.`timestamp`";
        $elements[4]->sort="1";
        $elements[4]->header="Timestamp";
        $elements[4]->alias="Timestamp";
        //    
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
        $maxrow=20;
        }
        if($orderby=="")
        {
        $orderby="id";
        $orderorder="ASC";
        }
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `campaign_order` INNER JOIN `user` ON `campaign_order`.`user`=`user`.`id` INNER JOIN `plan` ON `campaign_order`.`plan`=`plan`.`id` INNER JOIN `orderstatus` ON `orderstatus`.`id`=`campaign_order`.`status` ");
        $this->load->view("json",$data);
    }

    public function createorder()
    {
    $access=array("1");
    $this->checkaccess($access);
     $data["status"]=$this->order_model->getstatusdropdown();
      $data["user"]=$this->order_model->getuserdropdown();
    $data["Plan"]=$this->order_model->getplandropdown();
    //    print_r($data["status"]);
    $data["page"]="createorder";
    $data["title"]="Create order";
    $this->load->view("template",$data);
    }
    public function createordersubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("user","user","trim");
        $this->form_validation->set_rules("Plan","Plan","trim");
        $this->form_validation->set_rules("status","Status","trim");
//        $this->form_validation->set_rules("Timestamp","Timestamp","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createorder";
            $data["title"]="Create order";
            $this->load->view("template",$data);
        }
        else
        {
            $user=$this->input->get_post("user");
            $Plan=$this->input->get_post("Plan");
            $status=$this->input->get_post("status");
//            $Timestamp=$this->input->get_post("Timestamp");
            if($this->order_model->create($user,$Plan,$status)==0)
            $data["alerterror"]="New order could not be created.";
        else
            $data["alertsuccess"]="order created Successfully.";
            $data["redirect"]="site/vieworder";
            $this->load->view("redirect",$data);
        }
    }
    public function editorder()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["status"]=$this->order_model->getstatusdropdown();
        $data["Plan"]=$this->order_model->getplandropdown();
        $data["user"]=$this->order_model->getuserdropdown(); 
        $data["page"]="editorder";
        $data["title"]="Edit order";
        $data["before"]=$this->order_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
    }
    public function editordersubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
        $this->form_validation->set_rules("user","user","trim");
        $this->form_validation->set_rules("Plan","Plan","trim");
        $this->form_validation->set_rules("status","Status","trim");
//        $this->form_validation->set_rules("Timestamp","Timestamp","trim");
        if($this->form_validation->run()==FALSE)
        {
        $data["alerterror"]=validation_errors();
        $data["page"]="editorder";
        $data["title"]="Edit order";
        $data["before"]=$this->order_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
        }
        else
        {
        $id=$this->input->get_post("id");
        $user=$this->input->get_post("user");
        $Plan=$this->input->get_post("Plan");
        $status=$this->input->get_post("status");
        $Timestamp=$this->input->get_post("Timestamp");
        if($this->order_model->edit($id,$user,$Plan,$status)==0)
        $data["alerterror"]="New order could not be Updated.";
        else
        $data["alertsuccess"]="order Updated Successfully.";
        $data["redirect"]="site/vieworder";
        $this->load->view("redirect",$data);
    }
    }
    public function deleteorder()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->order_model->delete($this->input->get("id"));
        $data["redirect"]="site/vieworder";
        $this->load->view("redirect",$data);
    }
    public function viewcampaign()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="viewcampaign";
        $data["base_url"]=site_url("site/viewcampaignjson");
        $data["title"]="View campaign";
        $this->load->view("template",$data);
    }
    function viewcampaignjson()
    {
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`campaign_campaign`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";

        $elements[1]=new stdClass();
        $elements[1]->field="`campaign_campaign`.`Name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="Name";

        $elements[2]=new stdClass();
        $elements[2]->field="`campaign_campaign`.`startdate`";
        $elements[2]->sort="1";
        $elements[2]->header="Start Date";
        $elements[2]->alias="startdate";

        $elements[3]=new stdClass();
        $elements[3]->field="`campaign_campaign`.`testdate`";
        $elements[3]->sort="1";
        $elements[3]->header="Test Date";
        $elements[3]->alias="testdate";

        $elements[4]=new stdClass();
        $elements[4]->field="`campaign_campaign`.`publishingdate`";
        $elements[4]->sort="1";
        $elements[4]->header="Publishing Date";
        $elements[4]->alias="publishingdate";

        $elements[5]=new stdClass();
        $elements[5]->field="`user`.`name`";
        $elements[5]->sort="1";
        $elements[5]->header="User";
        $elements[5]->alias="user";

        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
        $maxrow=20;
        }
        if($orderby=="")
        {
        $orderby="id";
        $orderorder="ASC";
        }
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `campaign_campaign` INNER JOIN `user` ON `campaign_campaign`.`user`=`user`.`id`");
        $this->load->view("json",$data);
    }

    public function createcampaign()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["user"]=$this->order_model->getuserdropdown(); 
        $data["status"]=$this->campaign_model->getcampaignstatusdropdown();
         $data["before"]=$this->CampaignGroup_model->beforeedit($this->input->get("id"));
//        print_r($data["before"]);
        $data["page"]="createcampaign";
        $data["title"]="Create campaign";
        $this->load->view("template",$data);
    }
    public function createcampaignsubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("Name","Name","trim|required");
        $this->form_validation->set_rules("startdate","Start Date","trim|required");
        $this->form_validation->set_rules("testdate","Test Date","trim|required");
        $this->form_validation->set_rules("publishingdate","Publishing Date","trim|required");
        $this->form_validation->set_rules("user","User","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createcampaign";
            $data["title"]="Create campaign";
            $data["status"]=$this->campaign_model->getcampaignstatusdropdown();
            $this->load->view("template",$data);
        }
        else
        {
        $Name=$this->input->get_post("Name");
        $startdate=$this->input->get_post("startdate");
        $testdate=$this->input->get_post("testdate");
        $publishingdate=$this->input->get_post("publishingdate");
        $user=$this->input->get_post("user");
        if($this->campaign_model->create($Name,$startdate,$testdate,$publishingdate,$user)==0)
        $data["alerterror"]="New campaign could not be created.";
        else
        $data["alertsuccess"]="campaign created Successfully.";
        $data["redirect"]="site/viewcampaign";
        $this->load->view("redirect",$data);
    }
    }
    public function editcampaign()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["user"]=$this->order_model->getuserdropdown();
        $data["page"]="editcampaign";
        $data["page2"]="block/campaignblock";
        $data["title"]="Edit campaign";
        $data["status"]=$this->campaign_model->getcampaignstatusdropdown();
        $data["before"]=$this->campaign_model->beforeedit($this->input->get("id"));
        $this->load->view("templatewith2",$data);
    }
    public function editcampaignsubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
        $this->form_validation->set_rules("Name","Name","trim");
        $this->form_validation->set_rules("startdate","Start Date","trim");
        $this->form_validation->set_rules("testdate","Test Date","trim");
        $this->form_validation->set_rules("publishingdate","Publishing Date","trim");
        $this->form_validation->set_rules("user","User","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="editcampaign";
            $data["title"]="Edit campaign";
            $data["status"]=$this->campaign_model->getcampaignstatusdropdown();
            $data["before"]=$this->campaign_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $Name=$this->input->get_post("Name");
            $startdate=$this->input->get_post("startdate");
            $testdate=$this->input->get_post("testdate");
            $publishingdate=$this->input->get_post("publishingdate");
            $user=$this->input->get_post("user");
            $status=$this->input->get_post("status");
            if($this->campaign_model->edit($id,$Name,$startdate,$testdate,$publishingdate,$user,$status)==0)
                $data["alerterror"]="New campaign could not be Updated.";
            else
                $data["alertsuccess"]="campaign Updated Successfully.";
            $data["redirect"]="site/viewcampaign";
            $this->load->view("redirect",$data);
        }
    }
    public function deletecampaign()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->campaign_model->delete($this->input->get("id"));
        $data["redirect"]="site/viewcampaign";
        $this->load->view("redirect",$data);
    }
    public function viewCampaignGroup()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="viewCampaignGroup";
        $data["page2"]="block/campaignblock";
        $campaignid=$this->input->get('id');
       $data['before']=$this->campaign_model->beforeedit($campaignid);
        $data['selectedgroup']=$this->campaign_model->getselectedcampaigngroupbycampaign($campaignid);
        $data["base_url"]=site_url("site/viewCampaignGroupjson?id=".$campaignid);
//        print_r($data["base_url"]);
        $data["title"]="View CampaignGroup";
        $this->load->view("templatewith2",$data);
    }
 
    function viewCampaignGroupjson()
    {
        $campaignid=$this->input->get('id');
       $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`campaign_CampaignGroup`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        $elements[1]=new stdClass();
        $elements[1]->field="`campaign_campaign`.`Name`";
        $elements[1]->sort="1";
        $elements[1]->header="campaign";
        $elements[1]->alias="campaign";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`campaign_CampaignGroup`.`Timestamp`";
        $elements[2]->sort="1";
        $elements[2]->header="timestamp";
        $elements[2]->alias="Timestamp";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`campaign_CampaignGroup`.`order`";
        $elements[3]->sort="1";
        $elements[3]->header="order";
        $elements[3]->alias="order";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`campaigngroupstatus`.`name`";
        $elements[4]->sort="1";
        $elements[4]->header="Status";
        $elements[4]->alias="status";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`campaign_group`.`Name`";
        $elements[5]->sort="1";
        $elements[5]->header="group";
        $elements[5]->alias="group";
        
         $elements[6]=new stdClass();
        $elements[6]->field="`campaign_campaign`.`id`";
        $elements[6]->sort="1";
        $elements[6]->header="campaignid";
        $elements[6]->alias="campaignid";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
            $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `campaign_CampaignGroup` INNER JOIN `campaigngroupstatus` ON `campaigngroupstatus`.`id`=`campaign_CampaignGroup`.`status` INNER JOIN `campaign_group`  ON `campaign_group`.`id`=`campaign_CampaignGroup`.`group` INNER JOIN `campaign_campaign` ON `campaign_CampaignGroup`.`campaign`=`campaign_campaign`.`id`","WHERE `campaign_campaigngroup`.`campaign` ='$campaignid'");
            $this->load->view("json",$data);
    }

    public function createCampaignGroup()
    {
           $access=array("1");
           $this->checkaccess($access);
        
        
        $json=array();
        
        $json[0]=new stdClass();
        $json[0]->placeholder="";
        $json[0]->value="";
        $json[0]->label="Open Rate";
        $json[0]->type="text";
        $json[0]->options="";
        $json[0]->classes="";
        
        $json[1]=new stdClass();
        $json[1]->placeholder="";
        $json[1]->value="";
        $json[1]->label="Click Rate";
        $json[1]->type="text";
        $json[1]->options="";
        $json[1]->classes="";
        
        
        $data["fieldjson"]=$json;
        
    //         $data["before"]=$this->CampaignGroup_model->beforeedit($this->input->get("id"));
           $data["status"]=$this->CampaignGroup_model->getstatusdropdown();
           $data["group"]=$this->order_model->getgroupdropdown();
//           $data["group"]=$this->order_model->getgroupdropdownbycampaign($this->input->get('id'));
           $data['campaign']=$this->input->get('id');
           $data["page"]="createCampaignGroup";
           $data["title"]="Create CampaignGroup";
           $this->load->view("template",$data);
    }
    public function createCampaignGroupsubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
         $campaign=$this->input->get_post("campaign");
//        echo "the campagni is".$campaign;
//        $this->form_validation->set_rules("campaign","campaign","trim");
//        $this->form_validation->set_rules("Timestamp","timestamp","trim");
        $this->form_validation->set_rules("order","order","trim");
        $this->form_validation->set_rules("status","Status","trim");
        $this->form_validation->set_rules("group","group","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createCampaignGroup";
            $data["title"]="Create CampaignGroup";
            $this->load->view("template",$data);
        }
        else
        {
            $campaign=$this->input->get_post("campaign");
//            $Timestamp=$this->input->get_post("Timestamp");
            $order=$this->input->get_post("order");
            $status=$this->input->get_post("status");
            $group=$this->input->get_post("group");
            if($this->CampaignGroup_model->create($campaign,$order,$status, $group)==0)
            $data["alerterror"]="New CampaignGroup could not be created.";
        else
            $data["alertsuccess"]="CampaignGroup created Successfully.";
             $data["redirect"]="site/viewCampaignGroup?id=".$campaign;
        $this->load->view("redirect2",$data);
        }
    }
    public function editCampaignGroup()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="editCampaignGroup";
        $data["title"]="Edit CampaignGroup";
         $data["status"]=$this->CampaignGroup_model->getstatusdropdown();
       $data["group"]=$this->order_model->getgroupdropdown();
        $data["before"]=$this->CampaignGroup_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
    }
    public function editCampaignGroupsubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
//        $this->form_validation->set_rules("campaign","campaign","trim");
//        $this->form_validation->set_rules("Timestamp","timestamp","trim");
        $this->form_validation->set_rules("order","order","trim");
        $this->form_validation->set_rules("status","Status","trim");
        $this->form_validation->set_rules("group","group","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="editCampaignGroup";
            $data["title"]="Edit CampaignGroup";
            $data["before"]=$this->CampaignGroup_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $campaign=$this->input->get_post("campaign");
//            echo "cmpaign id is".$campaign;
            $Timestamp=$this->input->get_post("Timestamp");
            $order=$this->input->get_post("order");
            $status=$this->input->get_post("status");
            $group=$this->input->get_post("group");
            if($this->CampaignGroup_model->edit($id,$order,$status,$group,$campaign)==0)
            $data["alerterror"]="New CampaignGroup could not be Updated.";
            else
            $data["alertsuccess"]="CampaignGroup Updated Successfully.";
           $data["redirect"]="site/viewCampaignGroup?id=".$campaign;
        $this->load->view("redirect2",$data);
    }
    }
    public function deleteCampaignGroup()
    {
        $access=array("1");
        $this->checkaccess($access);
         $this->CampaignGroup_model->delete($this->input->get("campaigntestid"));
         $campaign=$this->input->get_post("id");
//        echo "campagi is ".$campaign;
       $data["redirect"]="site/viewCampaignGroup?id=".$campaign;
        $this->load->view("redirect2",$data);
        
        
    }
    public function viewgroup()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="viewgroup";
        $data["base_url"]=site_url("site/viewgroupjson");
        $data["title"]="View group";
        $this->load->view("template",$data);
    }
    function viewgroupjson()
    {
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`campaign_group`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";

        $elements[1]=new stdClass();
        $elements[1]->field="`campaign_group`.`Name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="Name";

        $elements[2]=new stdClass();
        $elements[2]->field="`tab1`.`name`";
        $elements[2]->sort="1";
        $elements[2]->header="designer";
        $elements[2]->alias="designer";

        $elements[3]=new stdClass();
        $elements[3]->field="`tab2`.`name`";
        $elements[3]->sort="1";
        $elements[3]->header="contentwriter";
        $elements[3]->alias="contentwriter";

        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
            $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `campaign_group` LEFT OUTER JOIN `user` as `tab1` ON  `campaign_group`.`designer`=`tab1`.`id` LEFT OUTER JOIN `user` as `tab2` ON  `campaign_group`.`contentwriter`=`tab2`.`id` ");
            $this->load->view("json",$data);
    }

    public function creategroup()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["contentwriter"]=$this->order_model->getuserdropdown();
        $data["designer"]=$this->order_model->getuserdropdown();
        $data["page"]="creategroup";
        $data["title"]="Create group";
        $this->load->view("template",$data);
    }
    public function creategroupsubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("Name","Name","trim");
        $this->form_validation->set_rules("designer","designer","trim");
        $this->form_validation->set_rules("contentwriter","contentwriter","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="creategroup";
            $data["title"]="Create group";
            $this->load->view("template",$data);
        }
        else
        {
            $Name=$this->input->get_post("Name");
            $designer=$this->input->get_post("designer");
            $contentwriter=$this->input->get_post("contentwriter");
            if($this->group_model->create($Name,$designer,$contentwriter)==0)
            $data["alerterror"]="New group could not be created.";
        else
            $data["alertsuccess"]="group created Successfully.";
            $data["redirect"]="site/viewgroup";
            $this->load->view("redirect",$data);
        }
    }
    public function editgroup()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["contentwriter"]=$this->order_model->getuserdropdown();
        $data["designer"]=$this->order_model->getuserdropdown();
        $data["page"]="editgroup";
        $data["title"]="Edit group";
        $data["before"]=$this->group_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
    }
    public function editgroupsubmit()
        {
            $access=array("1");
            $this->checkaccess($access);
            $this->form_validation->set_rules("id","ID","trim");
            $this->form_validation->set_rules("Name","Name","trim");
            $this->form_validation->set_rules("designer","designer","trim");
            $this->form_validation->set_rules("contentwriter","contentwriter","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="editgroup";
            $data["title"]="Edit group";
            $data["before"]=$this->group_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $Name=$this->input->get_post("Name");
            $designer=$this->input->get_post("designer");
            $contentwriter=$this->input->get_post("contentwriter");
            if($this->group_model->edit($id,$Name,$designer,$contentwriter)==0)
            $data["alerterror"]="New group could not be Updated.";
            else
            $data["alertsuccess"]="group Updated Successfully.";
            $data["redirect"]="site/viewgroup";
            $this->load->view("redirect",$data);
        }
    }
    public function deletegroup()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->group_model->delete($this->input->get("id"));
        $data["redirect"]="site/viewgroup";
        $this->load->view("redirect",$data);
    }
    public function viewCampaignTest()
    {
        $access=array("1");
        $this->checkaccess($access);
             $data["page"]="viewCampaignTest";
            $data["page2"]="block/campaignblock";
            $campaignid=$this->input->get('id');
           $data['before']=$this->campaign_model->beforeedit($campaignid);
            $data["base_url"]=site_url("site/viewCampaignTestjson?id=".$campaignid);
    //        print_r($data["base_url"]);
            $data["title"]="View CampaignTest";
            $this->load->view("templatewith2",$data);
         $campaignid=$this->input->get('id');
        }
    function viewCampaignTestjson()
    {
         $campaignid=$this->input->get('id');
    
         $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`campaign_CampaignTest`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        $elements[1]=new stdClass();
        $elements[1]->field="`campaign_campaign`.`Name`";
        $elements[1]->sort="1";
        $elements[1]->header="campaign";
        $elements[1]->alias="campaign";
        
   
        $elements[2]=new stdClass();
        $elements[2]->field="`campaign_CampaignTest`.`Timestamp`";
        $elements[2]->sort="1";
        $elements[2]->header="Timestamp";
        $elements[2]->alias="Timestamp";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`campaign_group`.`Name`";
        $elements[3]->sort="1";
        $elements[3]->header="group";
        $elements[3]->alias="group";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`campaign_CampaignTest`.`reports`";
        $elements[4]->sort="1";
        $elements[4]->header="reports";
        $elements[4]->alias="reports";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`campaign_campaign`.`id`";
        $elements[5]->sort="1";
        $elements[5]->header="campaignid";
        $elements[5]->alias="campaignid";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
        $maxrow=20;
        }
        if($orderby=="")
        {
        $orderby="id";
        $orderorder="ASC";
        }
            $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `campaign_CampaignTest` INNER JOIN `campaign_campaign` ON `campaign_CampaignTest`.`campaign`=`campaign_campaign`.`id` INNER JOIN `campaign_group` ON `campaign_CampaignTest`.`group`=`campaign_group`.`id`","WHERE `campaign_CampaignTest`.`campaign`='$campaignid'");
            $this->load->view("json",$data);
    }

    public function createCampaignTest()
    {
        $access=array("1");
         $this->checkaccess($access);
        
        
        $json=array();
        
        $json[0]=new stdClass();
        $json[0]->placeholder="";
        $json[0]->value="";
        $json[0]->label="Open Rate";
        $json[0]->type="text";
        $json[0]->options="";
        $json[0]->classes="";
        
        $json[1]=new stdClass();
        $json[1]->placeholder="";
        $json[1]->value="";
        $json[1]->label="Click Rate";
        $json[1]->type="text";
        $json[1]->options="";
        $json[1]->classes="";
        
        
        $data["fieldjson"]=$json;
        
        $data["page"]="createCampaignTest";
//         $data["group"]=$this->order_model->getgroupdropdown();
         $data["group"]=$this->order_model->getgroupdropdownbycampaign($this->input->get('id'));
        $data["title"]="Create Campaign Test";
        $this->load->view("template",$data);
    }
    public function createCampaignTestsubmit() 
    {
        $access=array("1");
        $campaign=$this->input->post("campaign");
//        echo "campaign".$campaign;
        $this->checkaccess($access);
        $this->form_validation->set_rules("campaign","campaign","trim");
//        $this->form_validation->set_rules("Timestamp","Timestamp","trim");
        $this->form_validation->set_rules("group","group","trim");
//        $this->form_validation->set_rules("reports","reports","trim");
        $this->form_validation->set_rules("json","json","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createCampaignTest";
            $data["title"]="Create CampaignTest";
            $this->load->view("template",$data);
        }
        else
        {
            $campaign=$this->input->get_post("campaign");
//            $Timestamp=$this->input->get_post("Timestamp");
            $group=$this->input->get_post("group");
//            $reports=$this->input->get_post("reports");
            $reports=$this->input->get_post("json");
            if($this->CampaignTest_model->create($campaign,$group,$reports)==0)
            $data["alerterror"]="New CampaignTest could not be created.";
        else
            $data["alertsuccess"]="CampaignTest created Successfully.";
            $data["redirect"]="site/viewCampaignTest?id=".$campaign;
          $this->load->view("redirect2",$data);
        }
    }
    public function editCampaignTest()
    {
        $access=array("1");
        $this->checkaccess($access);
          $data["user"]=$this->order_model->getuserdropdown();
      $data["page"]="editCampaignTest";
//        $data["page2"]="block/campaigntest";
         $data["title"]="Edit CampaignTest";
//        $data["group"]=$this->order_model->getgroupdropdown();
        $data["group"]=$this->order_model->getgroupdropdownbycampaign($this->input->get('campaignid'));
        $data["before"]=$this->CampaignTest_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
     }
    public function editCampaignTestsubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
        $this->form_validation->set_rules("campaign","campaign","trim");
//        $this->form_validation->set_rules("Timestamp","Timestamp","trim");
        $this->form_validation->set_rules("group","group","trim");
//        $this->form_validation->set_rules("reports","reports","trim");
        $this->form_validation->set_rules("json","json","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="editCampaignTest";
            $data["title"]="Edit CampaignTest";
            $data["before"]=$this->CampaignTest_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $campaign=$this->input->get_post("campaign");
//            $Timestamp=$this->input->get_post("Timestamp");
            $group=$this->input->get_post("group");
//            $reports=$this->input->get_post("reports");
            $reports=$this->input->get_post("json");
            if($this->CampaignTest_model->edit($id,$campaign,$group,$reports)==0)
            $data["alerterror"]="New CampaignTest could not be Updated.";
            else
            $data["alertsuccess"]="CampaignTest Updated Successfully.";
            $data["redirect"]="site/viewCampaignTest?id=".$campaign;
            $this->load->view("redirect2",$data);
        }
    }
    public function deleteCampaignTest()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->CampaignTest_model->delete($this->input->get("campaigntestid"));
         $campaign=$this->input->get_post("id");
//        echo "campagi is ".$campaign;
       $data["redirect"]="site/viewCampaignTest?id=".$campaign;
        $this->load->view("redirect2",$data);
    }
    public function viewCampaignResult()
    {
        $access=array("1");
        $this->checkaccess($access);
         $access=array("1");
    $this->checkaccess($access);
 $data["page"]="viewCampaignResult";
        $data["page2"]="block/campaignblock";
        $campaignid=$this->input->get('id');
       $data['before']=$this->campaign_model->beforeedit($campaignid);
        $data["base_url"]=site_url("site/viewCampaignResultjson?id=".$campaignid);
//        print_r($data["base_url"]);
       $data["title"]="View CampaignResult";
        $this->load->view("templatewith2",$data);
     $campaignid=$this->input->get('id');
   }
    function viewCampaignResultjson()
    {
        
         $campaignid=$this->input->get('id');
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`campaign_CampaignResult`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        $elements[1]=new stdClass();
        $elements[1]->field="`campaign_CampaignResult`.`Timestamp`";
        $elements[1]->sort="1";
        $elements[1]->header="Timestamp";
        $elements[1]->alias="Timestamp";
        $elements[2]=new stdClass();
        $elements[2]->field="`campaign_CampaignResult`.`reports`";
        $elements[2]->sort="1";
        $elements[2]->header="reports";
        $elements[2]->alias="reports";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`campaign_campaign`.`Name`";
        $elements[3]->sort="1";
        $elements[3]->header="campaign";
        $elements[3]->alias="campaign";
        
         $elements[4]=new stdClass();
        $elements[4]->field="`campaign_campaign`.`id`";
        $elements[4]->sort="1";
        $elements[4]->header="campaignid";
        $elements[4]->alias="campaignid";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`campaign_campaign`.`id`";
        $elements[5]->sort="1";
        $elements[5]->header="campaignid";
        $elements[5]->alias="campaignid";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
        $maxrow=20;
        }
        if($orderby=="")
        {
        $orderby="id";
        $orderorder="ASC";
        }
            $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `campaign_CampaignResult` INNER JOIN `campaign_campaign` ON `campaign_CampaignResult`.`campaign`=`campaign_campaign`.`id`","WHERE `campaign_CampaignResult`.`campaign`='$campaignid'");
            $this->load->view("json",$data);
    }

    public function createCampaignResult()
    {
        $access=array("1");
        $this->checkaccess($access);
        
        $json=array();
        
        $json[0]=new stdClass();
        $json[0]->placeholder="";
        $json[0]->value="";
        $json[0]->label="Open Rate";
        $json[0]->type="text";
        $json[0]->options="";
        $json[0]->classes="";
        
        $json[1]=new stdClass();
        $json[1]->placeholder="";
        $json[1]->value="";
        $json[1]->label="Click Rate";
        $json[1]->type="text";
        $json[1]->options="";
        $json[1]->classes="";
        
        
        $data["fieldjson"]=$json;
        $data["group"]=$this->order_model->getgroupdropdownbycampaign($this->input->get('id'));
        $data["page"]="createCampaignResult";
        $data["title"]="Create CampaignResult";
        $this->load->view("template",$data);
    }
    public function createCampaignResultsubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
//        $this->form_validation->set_rules("Timestamp","Timestamp","trim|required");
//        $this->form_validation->set_rules("reports","reports","trim|required");
        $this->form_validation->set_rules("json","json","trim|required");
        $this->form_validation->set_rules("campaign","campaign","trim|required");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createCampaignResult";
            $data["group"]=$this->order_model->getgroupdropdown();
            $data["title"]="Create CampaignResult";
            $this->load->view("template",$data);
        }
        else
        {
//            $Timestamp=$this->input->get_post("Timestamp");
//            $reports=$this->input->get_post("reports");
            $reports=$this->input->get_post("json");
            $campaign=$this->input->get_post("campaign");
            $group=$this->input->get_post("group");
            if($this->CampaignResult_model->create($reports,$campaign,$group)==0)
            $data["alerterror"]="New CampaignResult could not be created.";
        else
            $data["alertsuccess"]="CampaignResult created Successfully.";
            $data["redirect"]="site/viewCampaignResult?id=".$campaign;
        $this->load->view("redirect2",$data);
        }
    }
    public function editCampaignResult()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["group"]=$this->order_model->getgroupdropdown();
        $data["page"]="editCampaignResult";
        $data["title"]="Edit CampaignResult";
        $data["before"]=$this->CampaignResult_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
    }
    public function editCampaignResultsubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
//        $this->form_validation->set_rules("Timestamp","Timestamp","trim");
        $this->form_validation->set_rules("json","json","trim");
//        $this->form_validation->set_rules("reports","reports","trim");
        $this->form_validation->set_rules("campaign","campaign","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["group"]=$this->order_model->getgroupdropdown();
            $data["page"]="editCampaignResult";
            $data["title"]="Edit CampaignResult";
            $data["before"]=$this->CampaignResult_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
//            $Timestamp=$this->input->get_post("Timestamp");
            $reports=$this->input->get_post("json");
            $campaign=$this->input->get_post("campaign");
            $group=$this->input->get_post("group");
            if($this->CampaignResult_model->edit($id,$reports,$campaign,$group)==0)
            $data["alerterror"]="New CampaignResult could not be Updated.";
            else
            $data["alertsuccess"]="CampaignResult Updated Successfully.";
 $data["redirect"]="site/viewCampaignResult?id=".$campaign;
        $this->load->view("redirect2",$data);
        }
    }
    public function deleteCampaignResult()
    {
        $access=array("1");
        $this->checkaccess($access);
       $this->CampaignResult_model->delete($this->input->get("campaigntestid"));
         $campaign=$this->input->get_post("id");
//        echo "campagi is ".$campaign;
       $data["redirect"]="site/viewCampaignResult?id=".$campaign;
        $this->load->view("redirect2",$data);
    }

}
?>
