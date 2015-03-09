<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");
class Json extends CI_Controller 
{function getallplan()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`campaign_plan`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`campaign_plan`.`Name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="Name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`campaign_plan`.`Duration`";
$elements[2]->sort="1";
$elements[2]->header="Duration";
$elements[2]->alias="Duration";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`campaign_plan`.`Amount`";
$elements[3]->sort="1";
$elements[3]->header="Amount";
$elements[3]->alias="Amount";

$elements=array();
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
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `campaign_plan`");
$this->load->view("json",$data);
}
public function getsingleplan()
{
$id=$this->input->get_post("id");
$data["message"]=$this->plan_model->getsingleplan($id);
$this->load->view("json",$data);
}
function getallorder()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`campaign_order`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`campaign_order`.`user`";
$elements[1]->sort="1";
$elements[1]->header="user";
$elements[1]->alias="user";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`campaign_order`.`Plan`";
$elements[2]->sort="1";
$elements[2]->header="Plan";
$elements[2]->alias="Plan";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`campaign_order`.`status`";
$elements[3]->sort="1";
$elements[3]->header="Status";
$elements[3]->alias="status";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`campaign_order`.`Timestamp`";
$elements[4]->sort="1";
$elements[4]->header="Timestamp";
$elements[4]->alias="Timestamp";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `campaign_order`");
$this->load->view("json",$data);
}
public function getsingleorder()
{
$id=$this->input->get_post("id");
$data["message"]=$this->order_model->getsingleorder($id);
$this->load->view("json",$data);
}
function getallcampaign()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`campaign_campaign`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`campaign_campaign`.`Name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="Name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`campaign_campaign`.`startdate`";
$elements[2]->sort="1";
$elements[2]->header="Start Date";
$elements[2]->alias="startdate";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`campaign_campaign`.`testdate`";
$elements[3]->sort="1";
$elements[3]->header="Test Date";
$elements[3]->alias="testdate";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`campaign_campaign`.`publishingdate`";
$elements[4]->sort="1";
$elements[4]->header="Publishing Date";
$elements[4]->alias="publishingdate";

$elements=array();
$elements[5]=new stdClass();
$elements[5]->field="`campaign_campaign`.`user`";
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
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `campaign_campaign`");
$this->load->view("json",$data);
}
public function getsinglecampaign()
{
$id=$this->input->get_post("id");
$data["message"]=$this->campaign_model->getsinglecampaign($id);
$this->load->view("json",$data);
}
function getallCampaignGroup()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`campaign_CampaignGroup`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`campaign_CampaignGroup`.`campaign`";
$elements[1]->sort="1";
$elements[1]->header="campaign";
$elements[1]->alias="campaign";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`campaign_CampaignGroup`.`Timestamp`";
$elements[2]->sort="1";
$elements[2]->header="timestamp";
$elements[2]->alias="Timestamp";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`campaign_CampaignGroup`.`order`";
$elements[3]->sort="1";
$elements[3]->header="order";
$elements[3]->alias="order";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`campaign_CampaignGroup`.`status`";
$elements[4]->sort="1";
$elements[4]->header="Status";
$elements[4]->alias="status";

$elements=array();
$elements[5]=new stdClass();
$elements[5]->field="`campaign_CampaignGroup`.`group`";
$elements[5]->sort="1";
$elements[5]->header="group";
$elements[5]->alias="group";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `campaign_CampaignGroup`");
$this->load->view("json",$data);
}
public function getsingleCampaignGroup()
{
$id=$this->input->get_post("id");
$data["message"]=$this->CampaignGroup_model->getsingleCampaignGroup($id);
$this->load->view("json",$data);
}
function getallgroup()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`campaign_group`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`campaign_group`.`Name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="Name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`campaign_group`.`designer`";
$elements[2]->sort="1";
$elements[2]->header="designer";
$elements[2]->alias="designer";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`campaign_group`.`contentwriter`";
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
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `campaign_group`");
$this->load->view("json",$data);
}
public function getsinglegroup()
{
$id=$this->input->get_post("id");
$data["message"]=$this->group_model->getsinglegroup($id);
$this->load->view("json",$data);
}
function getallCampaignTest()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`campaign_CampaignTest`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`campaign_CampaignTest`.`campaign`";
$elements[1]->sort="1";
$elements[1]->header="campaign";
$elements[1]->alias="campaign";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`campaign_CampaignTest`.`Timestamp`";
$elements[2]->sort="1";
$elements[2]->header="Timestamp";
$elements[2]->alias="Timestamp";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`campaign_CampaignTest`.`group`";
$elements[3]->sort="1";
$elements[3]->header="group";
$elements[3]->alias="group";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`campaign_CampaignTest`.`reports`";
$elements[4]->sort="1";
$elements[4]->header="reports";
$elements[4]->alias="reports";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `campaign_CampaignTest`");
$this->load->view("json",$data);
}
public function getsingleCampaignTest()
{
$id=$this->input->get_post("id");
$data["message"]=$this->CampaignTest_model->getsingleCampaignTest($id);
$this->load->view("json",$data);
}
function getallCampaignResult()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`campaign_CampaignResult`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`campaign_CampaignResult`.`Timestamp`";
$elements[1]->sort="1";
$elements[1]->header="Timestamp";
$elements[1]->alias="Timestamp";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`campaign_CampaignResult`.`reports`";
$elements[2]->sort="1";
$elements[2]->header="reports";
$elements[2]->alias="reports";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`campaign_CampaignResult`.`campaign`";
$elements[3]->sort="1";
$elements[3]->header="campaign";
$elements[3]->alias="campaign";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `campaign_CampaignResult`");
$this->load->view("json",$data);
}
public function getsingleCampaignResult()
{
$id=$this->input->get_post("id");
$data["message"]=$this->CampaignResult_model->getsingleCampaignResult($id);
$this->load->view("json",$data);
}
} ?>