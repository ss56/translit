    <div class="header">
  <div class="logo"><a href="#">RigVeda</a></div>
</div>
<!--Main content start-->
<div class="row pad-t-50">
  <div id="index-div"  class="large-2 columns">
    <ul id="red" class="treeview">
  <?php
        $mandal = -1;
        $sukta = -1;
        foreach($result as $row)
        {
            if($mandal != $row['mandal1'])
            {
                if($mandal != -1)
                    echo '</ul></li></ul></li>';
                echo '<li><span id="Mandal-'.$row['mandal1'].'">maṇḍala - '.$row['mandal1'].'</span><ul>';
                $mandal = $row['mandal1'];
                $sukta = -1;
            }
            if($sukta != $row['sukta1'])
            {
                if($sukta != -1)
                    echo '</ul></li>';
                echo '<li><span id="Sukta-'.$row['mandal1']."-".$row['sukta1'].'">sūkta - '.$row['sukta1'].'</span><ul>';
                $sukta = $row['sukta1'];
            }
            echo '<li><a id="'.$row['mandal1'].'-'.$row['sukta1'].'-'.$row['mantra1'].'" href="'.base_url().'rigveda/mantra/'.$row['mandal1'].'-'.$row['sukta1'].'-'.$row['mantra1'].'">mantra-'.$row['mantra1'].'</a></li>';
        }
        echo '</ul></div>';
        if(isset($mantra))
        {
            echo '<span style="display:none" id="text2">'.$mantra[0]['dn_mantra_accented'].'</span>';
            echo '<span style="display:none" id="test">'.implode("_",explode("\\",str_replace(' ','\\u0020',json_encode($mantra[0]['dn_mantra_accented'])))) /*implode("_",explode("\\",str_replace(' ',"_u0020",json_encode($mantra[0]['dn_mantra_accented']))))*/.'</span>';
            echo '<span style="display:none" id="text_pp">'.implode("_",explode("\\",str_replace(' ','\\u0020',json_encode($mantra[0]['dn_pada_patha_accented'])))).'</span>';
        }
  ?>
      
  </div>     
   <span id="lang" style="display: none;"><?php echo $lang;?></span>
<script>
var l2,l1;
var text;
var text1,rishi,devata,chandas,swara;

        $(document).ready(function(){
            //alert("the space"+String.fromCharCode(32)+'is here');
            $("#target").val($("#lang").text());
            if($("#lang").text() == 3072)
            {
                $('.change_lit').addClass("demo");
                
            }
            else
            {
                $('.change_lit').addClass("hint");
            }
            if(document.URL.indexOf('mantra') != -1)
            {
                var docs = document.URL.split('/');
                var man = docs[docs.length-1].split('-');
                $("#Mandal-"+man[0]).trigger('click')
                $("#Sukta-"+man[0]+"-"+man[1]).trigger('click')
                $("#"+man[0]+"-"+man[1]+"-"+man[2]).css('color',"#bc940b");

            }   
  
            $("#target").change(function(){
                 l2=$("#target").val();
                 
                 translit_ajax_fun();
            });
        });
        
        function translit_ajax_fun()
        {
            
                //alert(text);
                text = $('#text2').text();
                
                text1 = $("#text_pp").text();
                rishi = $("#rishi").text();
                devata = $("#devata").text();
                swara = $("#swara").text();
                chandas = $("#chandas").text();
                 
                if(l2!= 0)
                {
                    if(l2 == 3072)
                    {
                        l1=2304;
                        $("#transliterated").addClass("demo");   
                    }
                    else
                    {
                        l1=3072;
                        $("#transliterated").addClass("hint");
                    }
                     var res = translit_fun($("#test").text(),l1,l2);
                     $("#test").text(res['unicode']);
                     $('#transliterated').html("");
                     $("#transliterated").html(res['result']);
                     //alert(res['result']+'\n'+res['unicode']);

                     res = translit_fun($("#rishi_uc").text(),l1,l2);
                     $('#rishi_uc').text("");
                     $('#rishi_uc').text(res['unicode']);
                     $('#rishi').html("");
                     $('#rishi').html(res['result']);

                     res = translit_fun($("#devata_uc").text(),l1,l2);
                     $('#devata_uc').text("");
                     $('#devata_uc').text(res['unicode']);
                     $('#devata').html("");
                     $('#devata').html(res['result']);

                     res = translit_fun($("#chandas_uc").text(),l1,l2);
                     $('#chandas_uc').text("");
                     $('#chandas_uc').text(res['unicode']);
                     $('#chandas').html("");
                     $('#chandas').html(res['result']);

                     res = translit_fun($("#swara_uc").text(),l1,l2);
                     $('#swara_uc').text("");
                     $('#swara_uc').text(res['unicode']);
                     $('#swara').html("");
                     $('#swara').html(res['result']);

                     res = translit_fun($("#text_pp").text(),l1,l2);
                     $('#text_pp').text("");
                     $('#text_pp').text(res['unicode']);
                     $('#transliterated_pp').html("");
                     $('#transliterated_pp').html(res['result']);
                     if(l1== 3072)
                    {
                        $('.change_lit').removeClass("demo");
                        $('.change_lit').addClass("hint");
                    }
                    else
                    {
                        $('.change_lit').removeClass("hint");
                        $('.change_lit').addClass("demo");
                    }
                    $.ajax({
                            type: "POST",
                            url: "<?php echo base_url()?>rigveda/trans",
                            data: {"l1":l1 , "l2":l2}
                    });        
                }
                else
                {
                    alert("Please select appropriate options");
                }
            
        }

</script>