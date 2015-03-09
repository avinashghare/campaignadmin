<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class CampaignGroup_model extends CI_Model
{
    public function create($campaign,$order,$status, $group)
    {
        $querycheck=$this->db->query("SELECT * FROM `campaign_CampaignGroup` WHERE `campaign`='$campaign' AND `status`=1")->result();
        $length=sizeof($querycheck);
//        echo $length;
        if($length==2)
        {
            if($status==1)
            {
                $data=array(
                    "campaign" => $campaign,
                    "order" => $order,
                    "status" => 2,
                    "group" => $group
                );
                $query=$this->db->insert( "campaign_CampaignGroup", $data );
            }
            else
            {
                $data=array(
                    "campaign" => $campaign,
                    "order" => $order,
                    "status" => $status,
                    "group" => $group
                );
                $query=$this->db->insert( "campaign_CampaignGroup", $data );
            }
        }
        else
        {
            $data=array(
                "campaign" => $campaign,
                "order" => $order,
                "status" => $status,
                "group" => $group
            );
            $query=$this->db->insert( "campaign_CampaignGroup", $data );
            
            $querycheckforcampaign=$this->db->query("SELECT * FROM `campaign_CampaignGroup` WHERE `campaign`='$campaign' AND `status`=1")->result();
            $length1=sizeof($querycheckforcampaign);
            if($length==2)
            {
                $queryupdatecampaignstatus=$this->db->query("UPDATE `campaign_campaign` SET `status`=2 WHERE `id`='$campaign'");
            }
        
        }
        $id=$this->db->insert_id();
        if(!$query)
            return  0;
        else
            return  1;
    }
    
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("campaign_CampaignGroup")->row();
        return $query;
    }
    function getsingleCampaignGroup($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("campaign_CampaignGroup")->row();
        return $query;
    }
    public function edit($id,$order,$status,$group,$campaign)
    {
        if($status==1)
        {
            $querycheck=$this->db->query("SELECT * FROM `campaign_CampaignGroup` WHERE `campaign`='$campaign' AND `status`=1")->result();
            $length=sizeof($querycheck);
            if($length==2)
            {
                $data=array(
                    "id" =>$id,
        //            "campaign" => $campaign,
//                    "status" => 2,
                    "order" => $order,
                    "group" => $group
                );
        //        print_r($data);
                $this->db->where( "id", $id );
                $query=$this->db->update( "campaign_CampaignGroup", $data );
            }
            else
            {

                $data=array(
                    "id" =>$id,
        //            "campaign" => $campaign,
        //            "Timestamp" => $Timestamp,
                    "order" => $order,
                    "status" => $status,
                    "group" => $group
                );
        //        print_r($data);
                $this->db->where( "id", $id );
                $query=$this->db->update( "campaign_CampaignGroup", $data ); 
                
                $querycheckforcampaign=$this->db->query("SELECT * FROM `campaign_CampaignGroup` WHERE `campaign`='$campaign' AND `status`=1")->result();
                $length1=sizeof($querycheckforcampaign);
                if($length==2)
                {
                    $queryupdatecampaignstatus=$this->db->query("UPDATE `campaign_campaign` SET `status`=2 WHERE `id`='$campaign'");
                }
            }
        }
        else
        {
        
            $data=array(
                "id" =>$id,
    //            "campaign" => $campaign,
    //            "Timestamp" => $Timestamp,
                "order" => $order,
                "status" => $status,
                "group" => $group
            );
    //        print_r($data);
            $this->db->where( "id", $id );
            $query=$this->db->update( "campaign_CampaignGroup", $data );
        
        }
        
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `campaign_CampaignGroup` WHERE `id`='$id'");
        return $query;
    }
    
    public function getstatusdropdown()
    {
       	$query=$this->db->query("SELECT * FROM  `campaigngroupstatus`")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
	  return $return;
    }
}
?>
