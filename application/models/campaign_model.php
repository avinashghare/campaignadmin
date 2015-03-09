<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class campaign_model extends CI_Model
{
    
    public function create($Name,$startdate,$testdate,$publishingdate,$user)
    {
        $data=array(
            "Name" => $Name,
            "startdate" => $startdate,
            "testdate" => $testdate,
            "publishingdate" => $publishingdate,
            "user" => $user,
            "status"=>1
        );
        $query=$this->db->insert( "campaign_campaign", $data );
        $id=$this->db->insert_id();
        if(!$query)
            return  0;
        else
            return  1;
    }
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("campaign_campaign")->row();
        return $query;
    }
    function getsinglecampaign($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("campaign_campaign")->row();
        return $query;
    }
    public function edit($id,$Name,$startdate,$testdate,$publishingdate,$user,$status)
    {
        $data=array(
            "Name" => $Name,
            "startdate" => $startdate,
            "testdate" => $testdate,
            "publishingdate" => $publishingdate,
            "user" => $user,
            "status"=>$status
        );
        $this->db->where( "id", $id );
        $query=$this->db->update( "campaign_campaign", $data );
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `campaign_campaign` WHERE `id`='$id'");
        return $query;
    }
     
    public function getstatusdropdown()
    {
       	$query=$this->db->query("SELECT * FROM  `campaignstatus`")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
	  return $return;
    }
    
    public function getcampaignstatusdropdown()
    {
       	$query=$this->db->query("SELECT * FROM  `campaignstatus`")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
	  return $return;
    }
    
    function getselectedcampaigngroupbycampaign($id)
    {
        $query=$this->db->query("SELECT `campaign_campaigngroup`.`id`, `campaign_campaigngroup`.`campaign`, `campaign_campaigngroup`.`Timestamp`,`campaign_campaigngroup`. `order`, `campaign_campaigngroup`.`status`, `campaign_campaigngroup`.`group`,`campaign_group`.`name` as `groupname` 
FROM `campaign_campaigngroup` 
LEFT OUTER JOIN `campaign_group` ON `campaign_campaigngroup`.`group`=`campaign_group`.`id`
LEFT OUTER JOIN `campaigngroupstatus` ON `campaign_campaigngroup`.`status`=`campaigngroupstatus`.`id`
WHERE `campaign_campaigngroup`.`campaign`='$id' AND `campaign_campaigngroup`.`status`=1 LIMIT 0,2")->result();
        return $query;
    }
}
?>
