<style>
	.wrapper1, .wrapper2{width: 1000px; border: none 0px RED;
	overflow-x: scroll; overflow-y:hidden;}
	.wrapper1{height: 20px; }
	.wrapper2{height: 500px; padding-bottom:20px;}
	.div1 { height: 20px; }
	.div2 { height: 500px;
	overflow: auto;}
</style>
<div class="row-fluid">
	<div class="widget-box">
	  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5>Form E-Monitoring E.81
		<a href="<?=base_url("login/cetak/".$Pr)?>" target='_blank'><button type="button" class="btn btn-primary" style="height:font-size:5pt;height:20px;padding-top:0px;">Cetak</button></a>
		</h5>
		 
	  </div>
	  <div class="widget-content nopadding">	
		<div class="wrapper1">
			<div class="div1">
			</div>
		</div>
		<div class="wrapper2">
			<div class="div2">
				<table border=1 cellpadding=5 cellspacing=0 style='border-collapse: collapse;'>
				  <thead>
					<tr>
						<th width='50' rowspan=2>No.</th>
						<th rowspan=2>Sasaran</th>			
						<th rowspan=2>Program/Kegiatan</th>
						<th rowspan=2>Indikator Kinerja Program (outcome)/ Kegiatan (output)</th>
						<th rowspan=2 colspan=2>Target Renstra Perangkat Daerah (Akhir Periode Renstra Perangkat Daerah)</th>
						<th rowspan=2 colspan=2>Realisasi Capaian Kinerja Renstra Perangkat Daerah sampai dengan Renja Perangkat Daerah Tahun Lalu(n-2)</th>
						<th rowspan=2 colspan=2>Target Kinerja dan Anggaran Renja Perangkat Daerah Tahun berjalan (Tahun n-1) yang dievaluasi</th>
						<th colspan=8>Realisasi Kinerja Pada Triwulan</th>
						<th rowspan=2 colspan=2>Realisasi Capaian Kinerja dan Anggaran Renja Perangkat Daerah yang dievaluasi</th>
						<th rowspan=2 colspan=2>Realisasi Kinerja dan Anggaran Renstra Perangkat Daerah (Akhir Tahun Pelaksanaan Renja Perangkat Daerah)</th>
						<th rowspan=2 colspan=2>Tingkat Capaian Kinerja Dan Realisasi Anggaran Renstra Perangkat Daerah  (%)</th>
						<th rowspan=2>unit Perangkat Daerah Penanggung Jawab</th>
						<th rowspan=2>Keterangan</th>
					</tr>
					<tr>
						<th colspan='2'>I</th>		
						<th colspan='2'>II</th>		
						<th colspan='2'>III</th>		
						<th colspan='2'>IV</th>		
					</tr>
					<tr>
						<th rowspan=2>(1)</th>
						<th rowspan=2>(2)</th>
						<th rowspan=2>(3)</th>
						<th rowspan=2>(4)</th>
						<th colspan='2'>(5)</th>
						<th colspan='2'>(6)</th>
						<th colspan='2'>(7)</th>
						<th colspan='2'>(8)</th>
						<th colspan='2'>(9)</th>
						<th colspan='2'>(10)</th>
						<th colspan='2'>(11)</th>
						<th colspan='2'>(12)</th>
						<th colspan='2'>(13)</th>
						<th colspan='2'>(14)</th>
						<th rowspan='2'>(15)</th>
						<th rowspan='2'>(16)</th>
					</tr>
					<tr>
						<th>K</th><th>Rp.</th>
						<th>K</th><th>Rp.</th>
						<th>K</th><th>Rp.</th>
						<th>K</th><th>Rp.</th>
						<th>K</th><th>Rp.</th>
						<th>K</th><th>Rp.</th>
						<th>K</th><th>Rp.</th>
						<th>K</th><th>Rp.</th>
						<th>K</th><th>Rp.</th>
						<th>K</th><th>Rp.</th>				
					</tr>
				  </thead>
				  <tbody>		  
					<?php			
					$i=1;$KDPRGRM="";

					if($sGroup==9){
					
						$qry=$this->db->query("SELECT a.KDTAHAP, a.KDPRGRM, a.KDKEGUNIT, a.UNITKEY,  a.NMSASARAN, b.NMPRGRM , c.NMKEG, a.INDIKATOR_KINERJA, a.TARGET_RENSTRA_K, a.TARGET_RENSTRA_RP, a.REALISASI_RENSTRA_K_N2, a.REALISASI_RENSTRA_RP_N2, a.REALISASI_KINERJA_K_1, a.REALISASI_KINERJA_RP_1, a.REALISASI_KINERJA_K_2, a.REALISASI_KINERJA_RP_2, a.REALISASI_KINERJA_K_3, a.REALISASI_KINERJA_RP_3, a.REALISASI_KINERJA_K_4, a.REALISASI_KINERJA_RP_4, a.TARGET_RENJA_K, a.TARGET_RENJA_RP, a.REALISASI_CAPAIAN_K, a.REALISASI_CAPAIAN_RP, a.REALISASI_KINERJA_ANG_K, a.REALISASI_KINERJA_ANG_RP, a.REALISASI_KINERJA_ANG_PERSEN_K, a.REALISASI_KINERJA_ANG_PERSEN_RP, d.NMUNIT, a.KETERANGAN  FROM dbsipd_".$_tahun.".emon_81 AS a  INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS b ON a.KDPRGRM=b.KDPRGRM INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS c ON a.KDKEGUNIT=c.KDKEGUNIT INNER JOIN dbsipd_".$_tahun.".mskpd AS d ON a.UNITKEY=d.UNITKEY WHERE a.KDTAHAP='".$_tahap."' and a.UNITKEY='".$_idopd."' order by d.KDUNIT, b.NOPRGRM, c.NOKEG");
						
					}else{
						$qry=$this->db->query("SELECT a.KDTAHAP, a.KDPRGRM, a.KDKEGUNIT, a.UNITKEY,  a.NMSASARAN, b.NMPRGRM , c.NMKEG, a.INDIKATOR_KINERJA, a.TARGET_RENSTRA_K, a.TARGET_RENSTRA_RP, a.REALISASI_RENSTRA_K_N2, a.REALISASI_RENSTRA_RP_N2, a.REALISASI_KINERJA_K_1, a.REALISASI_KINERJA_RP_1, a.REALISASI_KINERJA_K_2, a.REALISASI_KINERJA_RP_2, a.REALISASI_KINERJA_K_3, a.REALISASI_KINERJA_RP_3, a.REALISASI_KINERJA_K_4, a.REALISASI_KINERJA_RP_4, a.TARGET_RENJA_K, a.TARGET_RENJA_RP, a.REALISASI_CAPAIAN_K, a.REALISASI_CAPAIAN_RP, a.REALISASI_KINERJA_ANG_K, a.REALISASI_KINERJA_ANG_RP, a.REALISASI_KINERJA_ANG_PERSEN_K, a.REALISASI_KINERJA_ANG_PERSEN_RP, d.NMUNIT, a.KETERANGAN  FROM dbsipd_".$_tahun.".emon_81 AS a  INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS b ON a.KDPRGRM=b.KDPRGRM INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS c ON a.KDKEGUNIT=c.KDKEGUNIT INNER JOIN dbsipd_".$_tahun.".mskpd AS d ON a.UNITKEY=d.UNITKEY order by d.KDUNIT, b.NOPRGRM, c.NOKEG");
					}

					
					foreach ($qry->result() as $row){	
						if(empty($KDPRGRM) || $KDPRGRM!=$row->KDPRGRM ){	
							$KDPRGRM=$row->KDPRGRM;
							echo "<tr bgcolor='#339900'><td colspan=26 style='color:white;font-weight:bold;'>".$row->NMPRGRM."</td></tr>";
							$i=1;
						}
						$REALISASI_CAPAIAN_RP=$row->REALISASI_KINERJA_RP_1+$row->REALISASI_KINERJA_RP_2+$row->REALISASI_KINERJA_RP_3+$row->REALISASI_KINERJA_RP_4;
						$REALISASI_KINERJA_ANG_RP=$row->REALISASI_RENSTRA_RP_N2+$REALISASI_CAPAIAN_RP;
						@$REALISASI_KINERJA_ANG_PERSEN_RP=(@$REALISASI_KINERJA_ANG_RP/@$row->TARGET_RENSTRA_RP)*100;
						
						echo "    
						<tr class='TrAksi' data-KDPRGRM='".$row->KDPRGRM."' data-KDKEGUNIT='".$row->KDKEGUNIT."' data-UNITKEY='".$row->UNITKEY."' data-KDTAHAP='".$row->KDTAHAP."'>		
							<td><center>$i.</center></td>
							<td>".$row->NMSASARAN."</td>	
							<td>".$row->NMKEG."</td>
							<td>".$row->INDIKATOR_KINERJA."</td>
							<td>".$row->TARGET_RENSTRA_K."</td>
							<td align=right>".$this->andri->cetakuang($row->TARGET_RENSTRA_RP)."</td>
							<td>".$row->REALISASI_RENSTRA_K_N2."</td>
							<td align=right>".$this->andri->cetakuang($row->REALISASI_RENSTRA_RP_N2)."</td>
							<td>".$row->TARGET_RENJA_K."</td>
							<td align=right>".$this->andri->cetakuang($row->TARGET_RENJA_RP)."</td>
							<td>".$row->REALISASI_KINERJA_K_1."</td>
							<td align=right>".$this->andri->cetakuang($row->REALISASI_KINERJA_RP_1)."</td>
							<td>".$row->REALISASI_KINERJA_K_2."</td>
							<td align=right>".$this->andri->cetakuang($row->REALISASI_KINERJA_RP_2)."</td>
							<td>".$row->REALISASI_KINERJA_K_3."</td>
							<td align=right>".$this->andri->cetakuang($row->REALISASI_KINERJA_RP_3)."</td>
							<td>".$row->REALISASI_KINERJA_K_4."</td>
							<td align=right>".$this->andri->cetakuang($row->REALISASI_KINERJA_RP_4)."</td>
					
							<td>".$row->REALISASI_CAPAIAN_K."</td>
							<td align=right>".$this->andri->cetakuang($REALISASI_CAPAIAN_RP)."</td>
							<td>".$row->REALISASI_KINERJA_ANG_K."</td>
							<td align=right>".$this->andri->cetakuang($REALISASI_KINERJA_ANG_RP)."</td>
							<td>".$row->REALISASI_KINERJA_ANG_PERSEN_K."</td>
							<td align=right>".$this->andri->cetakuang($REALISASI_KINERJA_ANG_PERSEN_RP)."</td>
							<td>".$row->NMUNIT."</td>
							<td>".$row->KETERANGAN."</td>
						</tr>
						";
						$i++;
					}			
					?>
				  </tbody>
				</table>		
	  		</div>
		</div>		
	  </div>
	</div>
</div>
<script src="<?=base_url("assets/tree/jquery/jquery.js")?>" type="text/javascript"></script>
<script src="<?=base_url("assets/tree/jquery/jquery-ui.custom.js")?>" type="text/javascript"></script>
<script src="<?=base_url("assets/tree/jquery/jquery.cookie.js")?>" type="text/javascript"></script>

<script type="text/javascript">	
	$( document ).ready(function() {	
	
		$('.TrAksi').dblclick(function(){	
			
			var KDPRGRM=$(this).attr("data-KDPRGRM");			
			var KDKEGUNIT=$(this).attr("data-KDKEGUNIT");			
			var UNITKEY=$(this).attr("data-UNITKEY");			
			var KDTAHAP=$(this).attr("data-KDTAHAP");			
		
			parent.location="<?=base_url('login/pages/'.$Pr.'/detail/edit/')?>"+KDPRGRM+'/'+KDKEGUNIT+'/'+UNITKEY+'/'+KDTAHAP;
		});
	});
	$(function(){
		$(".wrapper1").scroll(function(){
			$(".wrapper2")
				.scrollLeft($(".wrapper1").scrollLeft());
		});
		$(".wrapper2").scroll(function(){
			$(".wrapper1")
				.scrollLeft($(".wrapper2").scrollLeft());
		});
	});
</script>	