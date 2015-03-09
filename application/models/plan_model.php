<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class plan_model extends CI_Model
{
    public function create($Name,$Duration,$Amount,$numberofcampaigns)
    {
        $data=array("Name" => $Name,"Duration" => $Duration,"Amount" => $Amount,"numberofcampaigns" => $numberofcampaigns);
        $query=$this->db->insert( "campaign_plan", $data );
        $id=$this->db->insert_id();
        if(!$query)
            return  0;
        else
            return  $id;
    }
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("campaign_plan")->row();
        return $query;
    }
    function getsingleplan($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("campaign_plan")->row();
        return $query;
    }
    public function edit($id,$Name,$Duration,$Amount,$numberofcampaigns)
    {
        $data=array("Name" => $Name,"Duration" => $Duration,"Amount" => $Amount,"numberofcampaigns" => $numberofcampaigns);
        $this->db->where( "id", $id );
        $query=$this->db->update( "campaign_plan", $data );
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `campaign_plan` WHERE `id`='$id'");
        return $query;
    }
}
?>
