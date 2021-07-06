<?php
	$data=$this->input->post();
	if(!empty($data)){
		foreach($data as $key => $value){$$key = $this->andri->clean($value);}
	}else{
		$JENIS_CPCL=$this->uri->segment(6);	
		$KDKEGUNIT=$this->uri->segment(7);	
		$KDDEWAN=$this->uri->segment(8);
		$UNITKEY=$this->uri->segment(9);
	}
	
	$JENIS_CPCL=!empty($JENIS_CPCL)?$JENIS_CPCL:"3";

	$UNITKEY=!empty($UNITKEY)?$UNITKEY:"";
	$KDDEWAN=!empty($KDDEWAN)?$KDDEWAN:"";
	$KDKEGUNIT=!empty($KDKEGUNIT)?$KDKEGUNIT:"";
	$URUSKEY=!empty($URUSKEY)?$URUSKEY:"";
	$KDTAHAP=$_tahap;

	/*
	$UNITKEY=@$this->input->post('UNITKEY');
	$KDDEWAN=@$this->input->post('KDDEWAN');
	$KDKEGUNIT=@$this->input->post('KDKEGUNIT');
	*/

	$wh="";
	if(!empty($_kddewan)){
		$KDDEWAN=$_kddewan;
		$wh=" and KDDEWAN='{$KDDEWAN}'";		
	}

	$row=$this->m_action->ambilData("select NODEWAN as NODEWAN, NMDEWAN AS NMDEWAN from dbsipd_".$_tahun.".mdprd where KDDEWAN='{$KDDEWAN}'");
	$NODEWAN=$row->NODEWAN;
	$NMDEWAN=$row->NMDEWAN;
	
 
	
	
	
	$row=$this->m_action->ambilData("SELECT distinct b.KDPRGRM, b.KDKEGUNIT, concat(c.NOPRGRM,b.NOKEG) AS NOKEG, b.NMKEG, c.UNITKEY AS URUSKEY FROM dbsipd_".$_tahun.".t_rpjmd_keg AS b  INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS c ON b.KDPRGRM=c.KDPRGRM WHERE  b.KDKEGUNIT='{$KDKEGUNIT}'");

	
	
	$NOKEG=$row->NOKEG;
	$NMKEG=$row->NMKEG;
	$KDKEGUNIT=!empty($KDKEGUNIT)?$KDKEGUNIT:$row->KDKEGUNIT;
	$KDPRGRM=!empty($KDPRGRM)?$KDPRGRM:$row->KDPRGRM;
	$URUSKEY=!empty($URUSKEY)?$URUSKEY:$row->URUSKEY;
?>
<form method="post" action="<?=base_url('login/pages/'.$Pr)?>" id='Fm' name='Fm'>

<div class="row-fluid">
	<div class="widget-box">
	    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?></h5>			
	  </div>
		 <!-- Data List Program -->
	  <div class="widget-content form-horizontal">		
			<input type="hidden" name="KDKEGUNIT" id='KDKEGUNIT' value='<?=$KDKEGUNIT?>'>
			<div class="control-group">
              <label class="control-label">Lampiran</label>
              <div class="controls">
                	<?=$this->m_auth->cmbQuery('JENIS_CPCL',@$JENIS_CPCL,"select JENIS_CPCL as '0', LAMPIRAN as '1' from dbsipd_".$_tahun.".t_lampiran where JENIS_CPCL in ('3','4')","onchange=\"Fm.submit();\"")?>					
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Dewan</label>
              <div class="controls">
				<?=$this->m_auth->cmbQuery('KDDEWAN',@$KDDEWAN,"select KDDEWAN as '0', concat(NODEWAN,'. ',NMDEWAN) as '1' from dbsipd_".$_tahun.".mdprd where NMDEWAN!='' ".$wh." AND KDDEWAN ".@$_qrydewan." order by NODEWAN asc","onchange=\"Fm.submit();\"")?>	
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">SKPD Tujuan</label>
              <div class="controls">
				 <?=$this->m_auth->cmbQuery('UNITKEY',@$UNITKEY,"SELECT DISTINCT a.UNITKEY  as '0', concat(a.KDUNIT,' ' ,a.NMUNIT) as '1' FROM dbsipd_".$_tahun.".mskpd  AS a where a.KDSTUNIT='3' ORDER BY a.KDUNIT","onchange=\"Fm.submit();\"")?>	
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Urusan</label>
              <div class="controls">
                	<?=$this->m_auth->cmbQuery('URUSKEY',@$URUSKEY,"select a.UNITKEY  as '0', a.NMUNIT as '1' from (SELECT UNITKEY, concat(KDUNIT,' ' ,NMUNIT) as 'NMUNIT'  FROM dbsipd_".$_tahun.".mskpd WHERE UNITKEY='203' union SELECT DISTINCT a.URUSKEY AS UNITKEY, concat(b.KDUNIT,' ' ,b.NMUNIT) as 'NMUNIT' FROM dbsipd_".$_tahun.".mskpd_urusan AS a INNER JOIN dbsipd_".$_tahun.".mskpd AS b on a.URUSKEY=b.UNITKEY where a.UNITKEY='{$UNITKEY}') AS a order by a.NMUNIT","onchange=\"Fm.submit();\"")?>				
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Program</label>
              <div class="controls">
                	<?=$this->m_auth->cmbQuery('KDPRGRM',@$KDPRGRM,"SELECT DISTINCT a.KDPRGRM  as '0', concat(a.NOPRGRM,' ' ,a.NMPRGRM) as '1' FROM dbsipd_".$_tahun.".t_rpjmd_pgrm  AS a  WHERE a.UNITKEY ='".@$URUSKEY."' or a.UNITKEY='203'  ORDER BY a.NOPRGRM","onchange=\"Fm.submit();\"")?>					
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Kegiatan</label>
              <div class="controls">
                	<?=$this->m_auth->cmbQuery('KDKEGUNIT',@$KDKEGUNIT,"SELECT distinct b.KDKEGUNIT  as '0', concat(b.NOKEG,' ',b.NMKEG) as '1' FROM dbsipd_".$_tahun.".t_rpjmd_keg AS b WHERE  b.KDPRGRM='".$KDPRGRM."'","onchange=\"Fm.submit();\"")?>					
              </div>
            </div>
			<div class="control-group">
              <label class="control-label"></label>
              <div class="controls">
                <div class="input-append">
                  <input type="text" style='width:120px;' readonly  value='<?=$NOKEG?>'>
                  
				 </div>
				 <input type="text" class="span6" readonly  value='<?=$NMKEG?>'>		
              </div>
            </div>	
			<div class="control-group">
				 <label class="control-label"></label>
				 <div class="controls">
					<?php if(!empty($JENIS_CPCL)&&!empty($KDDEWAN)&&!empty($UNITKEY)&&!empty($KDKEGUNIT)){ ?>
				 	<a href="<?=base_url('login/pages/'.$Pr.'/cpcl/param/'.$JENIS_CPCL.'/'.$KDKEGUNIT.'/'.$KDDEWAN.'/'.$UNITKEY)?>" <?=$_pinsert?><button type="button" id='btnsimpan' class="btn btn-primary">Tambah</button></a>
					<?php } ?>
					<button type="button" onclick="Fm.submit();" class="btn btn-primary">Reload</button>
				 </div>
			
			</div>	
			
	  </div>
	   <div class="widget-content">		
		  <table class="table table-bordered table-striped with-check">
		  <thead>
		   <tr>			
			  <th>No</th>			  
			  <th>Kegiatan Prioritas</th>
			  <th>Sasaran Kegiatan</th>
			  <th>Program</th>
			  
			  <th>Lokasi (Desa/Kel/Kec)	</th>
			  <th>Volume</th>
			  <th>Pagu</th>
			  <th>Penanggung Jawab</th>			
			  <th colspan=3>Aksi</th>
		   </tr>
		  </thead>
		  <tbody>		   
			<?php			
				$i=1;
				$qry=$this->db->query("SELECT a.KDCPCL, f.NMPRGRM, a.KEGIATAN_PRIORITAS, a.SASARAN_KEGIATAN, concat(a.LOKASI,' ', c.NMDESA,' ' , b.NMUNIT) as LOKASI, concat(a.TARGET, ' ',a.SATUAN) VOLUME, a.PAGU, a.PENANGGUNG_JAWAB, a.FOTO, a.TGLVALID FROM dbsipd_".$_tahun.".t_kegiatan_cpcl AS a 
				LEFT JOIN dbsipd_".$_tahun.".mskpd AS b ON a.IDKEC=b.UNITKEY 
				LEFT JOIN dbsipd_".$_tahun.".mdesa AS c ON a.IDDESA=c.IDDESA 
				INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS e ON a.KDKEGUNIT=e.KDKEGUNIT
				INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS f ON e.KDPRGRM=f.KDPRGRM
				
				WHERE a.KDTAHAP='{$KDTAHAP}' AND a.KDDEWAN='{$KDDEWAN}' AND a.UNITKEY='{$UNITKEY}' AND a.KDKEGUNIT='{$KDKEGUNIT}' AND a.JENIS_CPCL='{$JENIS_CPCL}'");
				
				$i=1;
				foreach ($qry->result() as $row){	
					$FOTO=!empty($row->FOTO)?$row->FOTO:"assets/img-cpcl/photo.png";
					if(empty($row->TGLVALID)||($row->TGLVALID=='0000-00-00'))
					{
						$valid="";$TGLVALID="";$ArrCmbUmum=array();
						if(empty($_pupdate)){$ArrCmbUmum[]='Upload Foto';$ArrCmbUmum[]='Edit';}
						if(empty($_pdelete)){$ArrCmbUmum[]='Delete';}
					}else{
						$valid="style='display:none;'";
						$TGLVALID=$row->TGLVALID;
						$ArrCmbUmum=array();
					}
					echo "    
					<tr>					
						<td align=center>".$i.".</td>
						<td><a href='".base_url($FOTO)."' target='_blank'>".$row->KEGIATAN_PRIORITAS."</a></td>						
						<td>".$row->SASARAN_KEGIATAN."</td>
						<td>".$row->NMPRGRM."</td>
						
						<td>".$row->LOKASI."</td>
						<td>".$row->VOLUME."</td>
						<td align=right>".$this->andri->cetakuang($row->PAGU)."</td>
						<td>".$row->PENANGGUNG_JAWAB."</td>
						<td>
							<center ".$valid.">
								".$this->andri->cmbUmum("cmbAksi","",$ArrCmbUmum,"data-id='".@$row->KDCPCL."' class='cmbAksi' style='width:80px;'")."
							</center><br>
							<center>".$TGLVALID."</center>
						</td>
					</tr>
					";
					$i++;
				}
			?>
		  </tbody>
		</table>
	   </div>
</div>
		
</form>


<div id="popskpd" class="modal fade" >
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			
			<div class="modal-body">
				<div id="tree_skpd"> </div>
			</div>
			<div class="modal-footer">
				<strong>DAFTAR SKPD</strong>
			</div>
		</div>
	</div>
</div> 

<div id="popkeg" class="modal fade" >
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			
			<div class="modal-body">
				<div id="tree_keg"> </div>
			</div>
			<div class="modal-footer">
				<strong>DAFTAR KEGIATAN</strong>
			</div>
		</div>
	</div>
</div> 
<script src="<?=base_url("assets/tree/jquery/jquery.js")?>" type="text/javascript"></script>
<script src="<?=base_url("assets/tree/jquery/jquery-ui.custom.js")?>" type="text/javascript"></script>
<script src="<?=base_url("assets/tree/jquery/jquery.cookie.js")?>" type="text/javascript"></script>


<script type="text/javascript">	
	$( document ).ready(function() {	
	

		$('.cmbAksi').change(function(){	
			var cmbData=$(this).val();
			var KDCPCL=$(this).attr("data-id");			
			switch(cmbData) {			 
			  case "Upload Foto":
				  parent.location="<?=base_url('login/pages/'.$Pr.'/upload-foto/edit/')?>"+KDCPCL;
			  break;
			  case "Edit":
				  parent.location="<?=base_url('login/pages/'.$Pr.'/cpcl/edit/')?>"+KDCPCL;
			  break;
			  case "Delete":
				  parent.location="<?=base_url('login/pages/'.$Pr.'/cpcl/hapus/')?>"+KDCPCL;
			  break;
			}   
		});
	});
</script>	