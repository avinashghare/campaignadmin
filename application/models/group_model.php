<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class group_model extends CI_Model
{
    public function create($Name,$designer,$contentwriter)
    {
        $data=array("Name" => $Name,"designer" => $designer,"contentwriter" => $contentwriter);
        $query=$this->db->insert( "campaign_group", $data );
        $id=$this->db->insert_id();
        if(!$query)
            return  0;
        else
            return  $id;
    }
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("campaign_group")->row();
        return $query;
    }
    function getsinglegroup($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("campaign_group")->row();
        return $query;
    }
    public function edit($id,$Name,$designer,$contentwriter)
    {
        $data=array("Name" => $Name,"designer" => $designer,"contentwriter" => $contentwriter);
        $this->db->where( "id", $id );
        $query=$this->db->update( "campaign_group", $data );
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `campaign_group` WHERE `id`='$id'");
        return $query;
    }
}
?>
