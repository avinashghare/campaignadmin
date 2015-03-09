<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class CampaignResult_model extends CI_Model
{
    public function create($reports,$campaign,$group)
    {
        $data=array(
            "reports" => $reports,
            "campaign" => $campaign,
            "group" => $group
        );
        $query=$this->db->insert( "campaign_CampaignResult", $data );
        $id=$this->db->insert_id();
        if(!$query)
        return  0;
        else
        return  $id;
    }
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("campaign_CampaignResult")->row();
        return $query;
    }
    function getsingleCampaignResult($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("campaign_CampaignResult")->row();
        return $query;
    }
    public function edit($id,$reports,$campaign,$group)
    {
        $data=array(
                    "reports" => $reports,
                    "campaign" => $campaign,
                    "group" => $group
                   );
        $this->db->where( "id", $id );
        $query=$this->db->update( "campaign_CampaignResult", $data );
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `campaign_CampaignResult` WHERE `id`='$id'");
        return $query;
    }
}
?>
