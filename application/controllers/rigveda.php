<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rigveda extends CI_Controller {
    static $hindi = 2304,$telugu = 3072,$tamil = 2944;
    public function __construct()
    {
        parent:: __construct();
        $this->load->model("translit_model");
    }
    
    public function index()
    {
        
        $data['result'] = $this->translit_model->get_veda_tree();
        $this->session->sess_destroy();
        $this->load->view("view_header");
        $this->load->view("view_translit",$data);
        $this->load->view("view_footer");
    }
    public function mantra($mantra,$lang=0)
    {
        $mantra = explode("-",$mantra);
        if($this->session->userdata('lang1') != "" && $this->session->userdata('lang2') != "" && $this->session->userdata('lang2') != 2304) {
             $text = $this->translit_model->get_mantra($mantra[0],$mantra[1],$mantra[2]);
             $data['mantra'][0] = $text[0];
             $data['mantra'][0]['dn_mantra_accented'] = $this->translit_fun($text[0]['dn_mantra_accented'],$this->session->userdata('lang1'),$this->session->userdata('lang2'));
             $data['mantra'][0]['swara'] = $this->translit_fun($text[0]['swara'],$this->session->userdata('lang1'),$this->session->userdata('lang2'));
             $data['mantra'][0]['rishi'] = $this->translit_fun($text[0]['rishi'],$this->session->userdata('lang1'),$this->session->userdata('lang2'));
             $data['mantra'][0]['chandas'] = $this->translit_fun($text[0]['chandas'],$this->session->userdata('lang1'),$this->session->userdata('lang2'));
             $data['mantra'][0]['devata'] = $this->translit_fun($text[0]['devata'],$this->session->userdata('lang1'),$this->session->userdata('lang2'));
             $data['mantra'][0]['dn_pada_patha_accented'] = $this->translit_fun($text[0]['dn_pada_patha_accented'],$this->session->userdata('lang1'),$this->session->userdata('lang2'));
        }
        else
        {
            $data['mantra'] = $this->translit_model->get_mantra($mantra[0],$mantra[1],$mantra[2]);
        }
        $data['result'] = $this->translit_model->get_veda_tree();
        $data['link'] = $this->translit_model->getLinks($mantra);
        $data['lang'] = $this->session->userdata('lang2') == '' ? 2304 :$this->session->userdata('lang2') ;
        $data['session'] = $this->session;
        $this->load->view("view_header");                               
        $this->load->view("view_translit",$data);
        $this->load->view("view_right_panel");
        $this->load->view("view_footer");
    } 
    public function trans()
    {
        
        $l1=$_POST['l1'];
        $l2=$_POST['l2'];
        $user_data['lang1'] = $l1;
        $user_data['lang2'] = $l2;
        $this->session->set_userdata($user_data);
        
        /**
        * Shifted the transliteration to client side
        */
        
//        $text = $_POST['text2'];
//        $text1 = $_POST['text1'];
//        $rishi = $_POST['rishi'];
//        $devata = $_POST['devata'];
//        $chandas = $_POST['chandas'];
//        $swara = $_POST['swara'];
//        $text_ord = array();
//        $text_ord['dn_acc'] = $this->translit_fun($text,$l1,$l2);
//        $text_ord['dn_pp_acc'] = $this->translit_fun($text1,$l1,$l2);
//        $text_ord['rishi'] = $this->translit_fun($rishi,$l1,$l2);
//        $text_ord['chandas'] = $this->translit_fun($chandas,$l1,$l2);
//        $text_ord['swara'] = $this->translit_fun($swara,$l1,$l2);
//        $text_ord['devata'] = $this->translit_fun( $devata ,$l1,$l2);
//        echo json_encode($text_ord);
    }
    public function translit_fun($text,$l1,$l2)
    {
        
        $arr = array(); 
        $text_ord = '';
        $common = array(32,44,10,2385,2386,2404,2405,2424);
        $special = array(2385,2386,3075);
        if($l1>$l2)
        {
            $diff = $l1 - $l2;
        }
        else
        {
            $diff = $l2 - $l1;
        }
        if($l1 == 2944)
        {
            $lang1 = "Tamil";
            $l12 = 3053;
        }
        else if($l1 == 3072)
        {
            $lang1 = "Telugu";
            $l12 = 3199;
        }
        else if($l1 == 2304)
        {
            $lang1 = "Hindi";
            $l12 = 2491;
        }
        /**
        * Changed the conversion from text to unicode method to php 
        * in-built method json_encode which gives similar result
        */
        //$text1 = $this->utility->_uniord($text); 
        $text1 = str_replace(' ',"\u0020",json_encode($text));
        $text1 .= " ";
        for($i=0; $i<strlen($text1);$i++)
        {
            $a = '';
            if($text1[$i] == 'u' && $i<strlen($text1))
            {
                while($text1[$i] != '\\' && $i<strlen($text1)-1)
                {
                    $a .= $text1[$i];
                    $i++;
                }
            }
            
            array_push($arr , $a);
        }
        $last_ord = NULL;
        foreach($arr as $ar)
        {
            $ord = hexdec($ar);
            if(($ord >= $l1 && $ord <= $l12) || in_array($ord,$common))
            {
                if($l1>$l2 && !in_array($ord,$common))
                {
                    $ord = intval($ord)-$diff;
                }
                else if(!in_array($ord,$common))
                {
                    $ord = intval($ord)+$diff;
                }
                if (function_exists('mb_convert_encoding')) {
                    $text_ord .=  mb_convert_encoding('&#'.intval($ord).';', 'UTF-8', 'HTML-ENTITIES');
                } 
                else {
                    $text_ord .= chr(intval($ord));
                }
            }
            $last_ord = $ord;
        }
        return $text_ord;
    }

}

