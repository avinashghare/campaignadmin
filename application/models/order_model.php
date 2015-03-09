<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class order_model extends CI_Model
{
    public function getstatusdropdown()
    {
       	$query=$this->db->query("SELECT * FROM  `orderstatus`")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
	  return $return;
    }
      public function getgroupdropdown()
    {
       	$query=$this->db->query("SELECT * FROM  `campaign_group`")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->Name;
		}
	  return $return;
    }
      public function getgroupdropdownbycampaign($id)
    {
//       	$query=$this->db->query("SELECT * FROM  `campaign_group`")->result();
       	$query=$this->db->query("SELECT `campaign_campaigngroup`.`id`, `campaign_campaigngroup`.`campaign`, `campaign_campaigngroup`.`Timestamp`,`campaign_campaigngroup`. `order`, `campaign_campaigngroup`.`status`, `campaign_campaigngroup`.`group`,`campaign_group`.`name` as `groupname` 
FROM `campaign_campaigngroup` 
LEFT OUTER JOIN `campaign_group` ON `campaign_campaigngroup`.`group`=`campaign_group`.`id`
LEFT OUTER JOIN `campaigngroupstatus` ON `campaign_campaigngroup`.`status`=`campaigngroupstatus`.`id`
WHERE `campaign_campaigngroup`.`campaign`='$id' AND `campaign_campaigngroup`.`status`=1")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->group]=$row->groupname;
		}
	  return $return;
    }
    
//    function getselectedcampaigngroupbycampaign($id)
//    {
//        $query=$this->db->query("SELECT `campaign_campaigngroup`.`id`, `campaign_campaigngroup`.`campaign`, `campaign_campaigngroup`.`Timestamp`,`campaign_campaigngroup`. `order`, `campaign_campaigngroup`.`status`, `campaign_campaigngroup`.`group`,`campaign_group`.`name` as `groupname` 
//FROM `campaign_campaigngroup` 
//LEFT OUTER JOIN `campaign_group` ON `campaign_campaigngroup`.`group`=`campaign_group`.`id`
//LEFT OUTER JOIN `campaigngroupstatus` ON `campaign_campaigngroup`.`status`=`campaigngroupstatus`.`id`
//WHERE `campaign_campaigngroup`.`campaign`='$id' AND `campaign_campaigngroup`.`status`=1 LIMIT 0,2")->result();
//        return $query;
//    }
     public function getplandropdown()
    {
       	$query=$this->db->query("SELECT * FROM  `plan`")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
	  return $return;
    }
    
    public function getuserdropdown()
    {
        	$query=$this->db->query("SELECT * FROM  `user`")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
	  return $return;
    }
    public function create($user,$Plan,$status)
    {
        $data=array("user" => $user,"Plan" => $Plan,"status" => $status);
        $query=$this->db->insert( "campaign_order", $data );
        $id=$this->db->insert_id();
        if(!$query)
            return  0;
        else
            return  $id;
    }
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("campaign_order")->row();
        return $query;
    }
    function getsingleorder($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("campaign_order")->row();
        return $query;
    }
    public function edit($id,$user,$Plan,$status)
    {
        $data=array("user" => $user,"Plan" => $Plan,"status" => $status);
        $this->db->where( "id", $id );
        $query=$this->db->update( "campaign_order", $data );
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `campaign_order` WHERE `id`='$id'");
        return $query;
    }
}
?>
