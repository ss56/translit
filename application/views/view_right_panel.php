  <div class="large-10 columns">
  <div class="block top-section">
  <ul class="search">
  <li>
                     <input type="hidden" id="source" value="">
                    <select id="target">
                        <option value="3072">Telugu</option>
                        <option value="2304">Devanagari</option>
                        <option value="2944">Tamil</option>
                    </select>
                    
  </li>
  <!--<li><input type="button" id="trans_lit" value="Transliterate" class="button"></li>-->
  </ul>
  <br />
  <br />
  <hr />
  <a href="<?php echo $link['prev']?>" id="prevLink" style="float: left;"> &#171; Previous</a><a href="<?php echo $link['next']?>" id="nextLink" style="float: right;">Next &#187; </a></div>
    <div class="block">
      <h2>mantra identifier: <?php echo $mantra[0]['mantra_id'];?></h2>
      <ul class="list-style"> 
      <li> maṇḍala <?php echo $mantra[0]['mandal1'];?> – sūkta <?php echo $mantra[0]['sukta1'];?> – mantra <?php echo $mantra[0]['mantra1'];?></li>
      <li> maṇḍala <?php echo $mantra[0]['mandal2'];?> – anuvāka <?php echo $mantra[0]['anuvaak2'];?> – mantra <?php echo $mantra[0]['mantra2'];?></li>
      <li>aṣṭaka <?php echo $mantra[0]['ashtak3'];?> – adhyāya <?php echo $mantra[0]['adhyaya3'];?> – varga <?php echo $mantra[0]['varga3'];?> – mantra <?php echo $mantra[0]['mantra3'];?></li>
	  </ul>
	  <br>
    </div>                                               
    <div class="block">
      <h2>attributes:</h2>                           
      <p><span class="mantra-att">r̥ṣi</span><span class="mantra-att-col">:</span> 
        <span class="change_lit mnull pnull" id="rishi"><?php echo $mantra[0]['rishi'];?></span>
        <span style="display: none" id="rishi_uc"><?php echo implode("_",explode("\\",str_replace(' ','\\u0020',json_encode($mantra[0]['rishi']))));?></span>
      </p>
      <p><span class="mantra-att">devata</span><span class="mantra-att-col">:</span> 
        <span class="change_lit  mnull pnull" id="devata"><?php echo $mantra[0]['devata'];?></span>
        <span style="display: none" id="devata_uc"><?php echo implode("_",explode("\\",str_replace(' ','\\u0020',json_encode($mantra[0]['devata']))));?></span></p>
      <p><span class="mantra-att">chandas</span> <span class="mantra-att-col">:</span> 
        <span class="change_lit  mnull pnull" id="chandas"><?php echo $mantra[0]['chandas'];?></span>
        <span style="display: none" id="chandas_uc"><?php echo implode("_",explode("\\",str_replace(' ','\\u0020',json_encode($mantra[0]['chandas']))));?></span></p>
      <p><span class="mantra-att">svara</span> <span class="mantra-att-col">:</span> 
        <span class="change_lit  mnull pnull" id="swara"><?php echo $mantra[0]['swara'];?></span>
        <span style="display: none" id="swara_uc"><?php echo implode("_",explode("\\",str_replace(' ','\\u0020',json_encode($mantra[0]['swara']))));?></span></p>
	  <br>
    </div>
    <div class="block">
      <h2>saṁhita pāṭha</h2>
      <p class="change_lit" id="transliterated"><?php echo $mantra[0]['dn_mantra_accented'];?></p>
    <br>
	</div>
    <div class="block">
      <h2>pada pāṭha</h2>
      <p class="change_lit" id="transliterated_pp"><?php echo $mantra[0]['dn_pada_patha_accented'];?></p>
    <br>
	</div>
    
  </div>
</div>
















