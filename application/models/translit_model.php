<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Translit_model extends CI_Model {

	
	public function get_veda_tree()
	{
        $data = $this->db->select("mantra_id,mandal1,sukta1,mantra1")->from('mantras')->get()->result_array();
		return $data;
	}
    public function get_mantra($mandal,$sukta,$mantra)
    {
        $data = $this->db->select("mantra_id,mandal1,sukta1,mantra1,ashtak3,adhyaya3,varga3,mantra3,mandal2,anuvaak2,mantra2,rishi,devata,chandas,swara,dn_mantra_accented, dn_pada_patha_accented")
                ->from("mantras")
                ->where("mandal1","$mandal")
                ->where("sukta1","$sukta")
                ->where("mantra1","$mantra")
                ->get()
                ->result_array();
        return $data;                
    }
    public function getLinks($mantra)
    {
        $id = $this->db->select("mantra_id")
                ->from("mantras")
                ->where("mandal1",$mantra[0])
                ->where("sukta1",$mantra[1])
                ->where("mantra1",$mantra[2])
                ->get()
                ->result_array();   
        $id = $id[0]['mantra_id'];
        $last_id = $this->db->select("mantra_id")->order_by("mantra_id","desc")->limit(1)->get("mantras")->result_array();
        $last_id = $last_id[0]['mantra_id'];
        if($id == 1)
        {
            $data['prev'] = "javascript:void(0)";
        }
        else
        {
            $prev = $this->db->select("mandal1,sukta1,mantra1")->get_where("mantras",array('mantra_id' => $id-1))->result_array();
            $data['prev'] = base_url()."rigveda/mantra/".$prev[0]['mandal1']."-".$prev[0]['sukta1']."-".$prev[0]['mantra1'];
        }
        if($id == $last_id)
        {
            $data['next'] = "javascript:void(0)";
        }
        else
        {
            $next = $this->db->select("mandal1,sukta1,mantra1")->get_where("mantras",array('mantra_id' => $id+1))->result_array();
            $data['next'] = base_url()."rigveda/mantra/".$next[0]['mandal1']."-".$next[0]['sukta1']."-".$next[0]['mantra1'];
        }
        return $data;
    }
}

