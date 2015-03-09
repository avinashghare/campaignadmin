<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class CampaignTest_model extends CI_Model
{
    public function create($campaign,$group,$reports)
    {
        $querycheck=$this->db->query("SELECT * FROM `campaign_CampaignTest` WHERE `campaign`='$campaign'")->result();
        $length=sizeof($querycheck);
//        echo $length;
        if($length==2)
        {
            return 0;
        }
        {
            
        $data=array(
            "campaign" => $campaign,
            "group" => $group,
            "reports" => $reports
            );
    //        print_r($data);
            $query=$this->db->insert( "campaign_CampaignTest", $data );
            $id=$this->db->insert_id();
            $querycheck=$this->db->query("SELECT * FROM `campaign_CampaignTest` WHERE `campaign`='$campaign'")->result();
            $length=sizeof($querycheck);
    //        echo $length;
            if($length==2)
            {
                $queryupdatecampaignstatus=$this->db->query("UPDATE `campaign_campaign` SET `status`=5 WHERE `id`='$campaign'");
            }
        }
        if(!$query)
        return  0;
        else
        return  $id;
    }
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("campaign_CampaignTest")->row();
        return $query;
    }
    function getsingleCampaignTest($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("campaign_CampaignTest")->row();
        return $query;
    }
    public function edit($id,$campaign,$group,$reports)
    {
        $data=array("campaign" => $campaign,"group" => $group,"reports" => $reports);
        $this->db->where( "id", $id );
        $query=$this->db->update( "campaign_CampaignTest", $data );
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `campaign_CampaignTest` WHERE `id`='$id'");
        return $query;
    }
}
?>
