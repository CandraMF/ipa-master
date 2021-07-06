<?php
	class andri {	
		function __construct() {
			include_once APPPATH . '/third_party/fpdf/fpdf.php';
			
		}
		function cetakuang($n) {
		return @number_format($n,0,',','.');}
		//////////////////////////////// form
		function rdAktif($name='txtField',$value='',$param='')
		{
			$AK = !empty($value)?strtoupper($value):"N";
			$SelY = $AK=='1'?" checked ":"";
			$SelN = $AK=='0'?" checked ":"";

			$Input  = "<table>
			<tr>
				<td style='border:0px;'><input type=\"radio\" name=\"$name\" value='1' $SelY $param></td>
				<td style='border:0px;'>Y</td>
				<td style='border:0px;'><input type=\"radio\" name=\"$name\" value='0' $SelN $param> </td>
				<td style='border:0px;'>N </td>
			</tr>
			</table>
			
			";
//			$Input .= "&nbsp;";
			return $Input;
		}

		function radio2D($name='txtField',$value='',$arrList = '',$param='')
		{
			$i=1;$Input="";
			while($i<=count($arrList))
			{	
				$Sel="";
				$check = $value;				
				$Sel = $arrList[$i-1][0]==$check?" checked ":"";
				$Input.= "<input type=\"radio\" name=\"$name\" value=\"{$arrList[$i-1][0]}\" $Sel $param> {$arrList[$i-1][1]}&nbsp;";
				$i++;
			}
			return $Input;
		}
		
		function cektipedata($n) {
			if (is_numeric($n)){
				return "<p align=right>".@number_format(floatval($n),0,',','.')."</p>";
			}else{
				return @htmlentities($n);
			}
			
		
		}		
		function TglInd($Tgl="")
		{
			$Tanggal = !empty($Tgl)?substr($Tgl,8,2)."-".substr($Tgl,5,2)."-".substr($Tgl,0,4):"";
			return $Tanggal;
		}

		function TglSQL($Tgl="")
		{
			$Tanggal = !empty($Tgl)?substr($Tgl,6,4)."-".substr($Tgl,3,2)."-".substr($Tgl,0,2):"";
			return $Tanggal;
		}

		function cmb2D($name='txtField',$value='',$arrList = '',$param='')
		{
			global $Ref;
			$isi = $value;
			$Input = "<option value=\"\">Pilih</option>";
			for($i=0;$i<count($arrList);$i++)
			{
				$Sel = $isi==$arrList[$i][0]?" selected ":"no";
				$Input .= "<option $Sel value=\"{$arrList[$i][0]}\">{$arrList[$i][1]}</option>";
			}
			$Input  = "<select $param name=\"$name\"  id=\"$name\" class='form-control'>$Input</select>";
			return $Input;
		}
		function cmbUmum($name='txtField',$value='',$arrList = '',$param='')
		{
			global $Ref;
			$isi = $value;
			$Input = "<option value=\"\">Pilih</option>";
			for($i=0;$i<count($arrList);$i++)
			{
				$Sel = $isi==$arrList[$i]?" selected ":"no";
				$Input .= "<option $Sel value=\"{$arrList[$i]}\">{$arrList[$i]}</option>";
			}
			$Input  = "<select $param name=\"$name\"  id=\"$name\" class='form-control'>$Input</select>";
			return $Input;
		}

		public function gFile($file){	
			$fd = fopen ($file, "r");
			$cIsi = fread ($fd, filesize ($file));
			fclose ($fd);
			return $cIsi;
		}
		public function ModFolder($file){	
			$getFolder="./application/views/pages/mod_".$file.".inc.php";
			return $getFolder;
		}
		
		public function getData($Qry,$PageAwal=0,$PageAkhir=0){
			$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
			$rows = isset($_REQUEST['rows']) ? intval($_REQUEST['rows']) : 10;
			$offset = ($page-1)*$rows;
//			echo $Qry;
			$JcountQry=$this->limit($Qry);
			$result["total"] = mysql_num_rows(mysql_query($JcountQry));
			$rs = mysql_query($Qry);
			$Query1 = mysql_query($Qry);
			$items = array();
			$PageAwal=$PageAwal==0?1:$PageAwal;
			$i=$PageAwal;	
		
			$val="";
			while ($Field=mysql_fetch_field($Query1)){
				
				$val.="
				af (is_numeric([|]row['{$Field->name}'])){
					[|]data->{$Field->name}=@number_format([|]row['{$Field->name}'],0,',','.');
				}alse{
					[|]data->{$Field->name}=[|]row['{$Field->name}'];
				}";
			}
			
			$string=str_replace('[|]','$',$val);
			$string=str_replace('af','if',$string);
			$string=str_replace('alse','else',$string);
			
			while($row = mysql_fetch_array($rs)){	
				$data = new stdClass();					
				eval("$string");
				array_push($items, $data);
				
				$i++;
			}
		
			$result["rows"] = $items;
			echo str_replace('[]"},{','",',json_encode($result));
		}


		public function getList($Qry1="",$Qry2="",$Qry3="",$Qry4="",$Qry5="",$Qry6=""){
			$items = array();

			if(!empty($Qry1)){
				$rs = mysql_query($Qry1);			
				while($row = mysql_fetch_object($rs)){ array_push($items, $row); }
			}

			if(!empty($Qry2)){
				$rs = mysql_query($Qry2);			
				while($row = mysql_fetch_object($rs)){ array_push($items, $row); }
			}

			if(!empty($Qry3)){
				$rs = mysql_query($Qry3);			
				while($row = mysql_fetch_object($rs)){ array_push($items, $row); }
			}

			if(!empty($Qry4)){
				$rs = mysql_query($Qry3);			
				while($row = mysql_fetch_object($rs)){ array_push($items, $row); }
			}

			if(!empty($Qry5)){
				$rs = mysql_query($Qry3);			
				while($row = mysql_fetch_object($rs)){ array_push($items, $row); }
			}

			if(!empty($Qry6)){
				$rs = mysql_query($Qry3);			
				while($row = mysql_fetch_object($rs)){ array_push($items, $row); }
			}

			$result["records"] = $items;

			echo json_encode($result);
		}

		public function color($id)
		{
			$arrColor=array("'#7CB5EC','#434348','#90ED7D','#F7A35C','#F0F8FF','#FAEBD7','#00FFFF','#7FFFD4','#F0FFFF','#F5F5DC','#FFE4C4','#FFEBCD','#0000FF','#8A2BE2','#A52A2A','#DEB887','#5F9EA0','#7FFF00','#D2691E','#FF7F50','#6495ED','#FFF8DC','#DC143C','#00FFFF','#00008B','#008B8B','#B8860B','#A9A9A9','#006400','#BDB76B','#8B008B','#556B2F','#FF8C00','#9932CC','#8B0000','#E9967A','#8FBC8F','#483D8B','#2F4F4F','#00CED1','#9400D3','#FF1493','#00BFFF','#696969',#1E90FF','#B22222','#FFFAF0','#228B22','#FF00FF','#DCDCDC','#F8F8FF','#FFD700','#DAA520','#808080','#008000','#ADFF2F','#F0FFF0','#FF69B4','#CD5C5C','#4B0082','#FFFFF0','#F0E68C','#E6E6FA','#FFF0F5','#7CFC00','#FFFACD','#ADD8E6','#F08080','#E0FFFF','#FAFAD2','#D3D3D3','#90EE90','#FFB6C1','#FFA07A','#20B2AA','#87CEFA','#778899','#B0C4DE','#FFFFE0','#00FF00','#32CD32','#FAF0E6','#FF00FF','#800000','#66CDAA','#0000CD','#BA55D3','#9370DB','#3CB371','#7B68EE','#00FA9A','#48D1CC','#C71585','#191970','#F5FFFA','#FFE4E1','#FFE4B5','#FFDEAD','#000080','#FDF5E6','#808000','#6B8E23','#FFA500','#FF4500','#DA70D6','#EEE8AA','#98FB98','#AFEEEE','#DB7093','#FFEFD5','#FFDAB9','#CD853F','#FFC0CB','#DDA0DD','#B0E0E6','#800080','#FF0000','#BC8F8F','#4169E1','#8B4513','#FA8072','#F4A460','#2E8B57','#FFF5EE','#A0522D','#C0C0C0','#87CEEB','#6A5ACD','#708090','#FFFAFA','#00FF7F','#4682B4','#D2B48C','#008080','#D8BFD8','#FF6347','#40E0D0','#EE82EE','#F5DEB3','#FFFF00','#9ACD32'");
			$arrColor=array("#7CB5EC");
			$rt=$arrColor[0];
			return $rt;
		}
		public function getTgl($date)
		{
			$cthn=substr($date,0,4);
			$query="select 	'{$date}' as 'stnow', DATE_SUB(DATE_FORMAT('{$date}','%Y-%m-%d'),INTERVAL 1 month) as 'stnowlastmonth', DATE_SUB(DATE_FORMAT('{$date}','%Y-%m-%d'),INTERVAL 1 DAY) as 'styest', DATE_SUB(DATE_FORMAT('{$date}','%Y-%m-%d'),INTERVAL 1 month) as 'styestlastmonth', last_day(date_add('{$date}', interval -1 month))as 'stendlastmonth', last_day(date_add('{$cthn}-12-01', interval -1 year))as 'stendlastyear'";
			$rs = mysql_query($query);
			$row = mysql_fetch_array($rs);		
			$data['stnow']=$row['stnow'];
			$data['stnowlastmonth']=$row['stnowlastmonth'];
			$data['styest']=$row['styest'];
			$data['styestlastmonth']=$row['styestlastmonth'];
			$data['stendlastmonth']=$row['stendlastmonth'];
			$data['stendlastyear']=$row['stendlastyear'];
			return $data;
		}
		
		public function replTextDate($text,$date)
		{
			$data=$this->getTgl($date);
			
			$text=str_replace("{stnow}",$this->setDate($data['stnow'], 'ShortDate'),$text);
			$text=str_replace("{stnowlastmonth}",$this->setDate($data['stnowlastmonth'], 'ShortDate'),$text);
			$text=str_replace("{styest}",$this->setDate($data['styest'], 'ShortDate'),$text);
			$text=str_replace("{styestlastmonth}",$this->setDate($data['styestlastmonth'], 'ShortDate'),$text);
			$text=str_replace("{stendlastmonth}",$this->setDate($data['stendlastmonth'], 'ShortDate'),$text);
			$text=str_replace("{stendlastyear}",$this->setDate($data['stendlastyear'], 'ShortDate'),$text);
			return $text;
		}
		public function easyuiform($text,$name,$type,$action){
			$frm="";
			switch($type)
			{
				case "100":					
					$frm="$text &nbsp;<input  id='m{$name}' name='m{$name}' class='easyui-datebox' data-options='formatter:myformatter,parser:myparser'></input>		
					<input type='hidden' name='{$name}' id='{$name}'>
				";
				break;
				case "101":
					$frm="&nbsp;<input class='easyui-validatebox' type='text' id='{$name}' name='{$name}' placeholder='{$text}' style='border:1px solid #CCCCCC;height:26px;padding:2px;'></input>";
				break;
				case "102":
					$arr=explode(':>',$action);
					switch($arr[0])
					{
						case "arr":			
							$frm=$this->cmb2D($name,$this->cvrtoArr($arr[1]),$text);
						break;
						case "qry":
							$frm=$this->cmbQuery($name,$arr[1],$text);
						break;
					}					
				break;
			}
			return $frm;
		
		}
		public function cvrtoArr($data)
		{
			$data = str_replace(array("{", ","), '', $data);
			$data = explode('}', $data);
			unset($data[count($data) - 1]);
			$final_array = array();
			foreach($data AS $row){$final_array[] = explode(':', $row);}
			return $final_array;
		}
		public function limit($Text){			
			$Text=str_replace('Limit','limit',$Text);
			$Text=str_replace('LIMIT','limit',$Text);
			$find=strpos($Text, 'limit', 1);
			$find=substr($Text,0,$find);
			$find=!empty($find)?$find:$Text;
			return $find;
		}
		function ambilTextArr($Text=''){
			$Arr=explode('}',$Text);
			$i=1;
			$data=array();
			while($i<count($Arr))
			{
				$ArrData=explode('{',$Arr[$i-1]);
				$data[$i-1]=str_replace("st", "", $ArrData[1]);
				$i++;
			}
			return $data;
		}
		

		function ambilTextJson($Text=''){
			$Arr=explode('}',$Text);
			$i=1;
			$data=array();$result = array();
			while($i<count($Arr))
			{
				$ArrData=explode('{',$Arr[$i-1]);
				$dt = new stdClass();
				$dt->varFilter=$ArrData[1];
				array_push($result, $dt);
				$i++;
			}
			echo json_encode($result);
		}

		public function jsontocsv($rs, $type, $jsonmain="") {
			// receive a recordset and convert it to csv
			// or to json based on "type" parameter.
			$jsonArray = array();
			$csvString = "";
			$csvcolumns = "";
			$count = 0;
			while($r = mysql_fetch_row($rs)) {
				for($k = 0; $k < count($r); $k++) {
					$jsonArray[$count][mysql_field_name($rs, $k)] = $r[$k];
					$csvString.=",\"".$r[$k]."\"";
				}
				if (!$csvcolumns) for($k = 0; $k < count($r); $k++) $csvcolumns.=($csvcolumns?",":"").mysql_field_name($rs, $k);
				$csvString.="\n";
				$count++;
			}
			$jsondata = "{\"$jsonmain\":".json_encode($jsonArray)."}";
			$csvdata = str_replace("\n,","\n",$csvcolumns."\n".$csvString);
			return ($type=="csv"?$csvdata:$jsondata);
		}

	
		public function clean($str){
			$str=@trim($str);
			if(get_magic_quotes_gpc())$str=stripslashes($str);
			return $str;
		}

		function hapustitik($data=0)
		{$return=str_replace(".", "", $data);return $return;}

		public function tglAkhirBulan($thn,$bln){		
		$bulan=array(31,28,31,30,31,30,31,31,30,31,30,31);if ($thn%4==0){$bulan[1]=29;}
		return $bulan[$bln-1];
		}
		public function Persen($Number=0){$conv="concat(replace(FORMAT(ROUND({$Number}, 1), 1),',','.'),'%')";return $conv;}
		public function Rp($Number=0){$conv="concat(replace(FORMAT({$Number}, 0),',','.'))";return $conv;}

		public function ambilData($query)
		{
			$Query = mysql_query($query);
			$Hasil=mysql_fetch_array($Query);
			return $Hasil;
		}
		
		function setDate($Date = '00-00-0000', $Format = 'LongDate'){
				date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
	header('Expires: Mon, 1 Jul 1998 01:00:00 GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0', FALSE);
	header('Pragma: no-cache');
	header("Last-Modified: " . gmdate("D, j M Y H:i:s") . " GMT" );
			$Ref = new stdClass();
			$Ref->Hari=array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
			$Ref->Bulan=array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Des");
			if (substr($Date, 0, 2) != '00' && !empty($Date)){
				$Day = substr($Date, 2, 1) == '-' || substr($Date, 2, 1) == '/' ? substr($Date, 0, 2) : substr($Date, 8, 2);
				$Month = substr($Date, 2, 1) == '-' || substr($Date, 2, 1) == '/' ? substr($Date, 3, 2) : substr($Date, 5, 2);
				$Year = substr($Date, 2, 1) == '-' || substr($Date, 2, 1) == '/' ? substr($Date, 6, 4) : substr($Date, 0, 4);
				$Year2 = substr($Year, 2, 2);
				$Hari = $Ref->Hari[date("w", mktime(0, 0, 0, $Month, $Day, $Year))];
				$Bulan = $Ref->Bulan[($Month * 1) - 1];
				switch ($Format){
					case "SQL":return "$Year-$Month-$Day";break;
					case "IDN":return "$Day-$Month-$Year";break;
					case "IdnSlash":return "$Day/$Month/$Year";break;
					case "ShortDate":return "$Day $Bulan $Year";break;
					case "ShortDateNum":return "$Day$Month$Year2";break;
					case "LongDate":default:return "$Hari, $Day $Bulan $Year";break;
				}
			}
			else return "";
		}

		function YMDate($Date = '000000'){
			$Ref = new stdClass();
			$Ref->Bulan=array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Des");
			if (!empty($Date)){
				$Month=intval(substr($Date,5,2));

				$Year=intval(substr($Date,0,4));
				$Bulan = $Ref->Bulan[($Month * 1) - 1];
				return $Bulan.' '.$Year;
			}else
			{return "";}
			
		}

		function FormatPersen($angka){
			return number_format($angka, 2) . "%";
		}

	
		public function cmbQuery($name='txtField',$query='',$Atas='',$value='',$param='',$vAtas='')
		{
			global $Ref;
			if (empty($Atas)){$Input = "";}else{$Input = "<option>$Atas</option>";}
			$Input = "";
			$Query = mysql_query($query);
			while ($Hasil=mysql_fetch_row($Query))
			{
				$Sel = $Hasil[0]==$value?"selected":"";
				$Input .= "<option $Sel value=\"{$Hasil[0]}\" $param>{$Hasil[1]}";
			}
			$Input  = "
			<div class='styled-select'><select name='$name' id='$name' >$Input</select></div>
			<script>$('#".$name."').change(function () { $( '#".$name." option:selected' ); })</script>
			";
		
			return $Input;
		}
		
		

		public function dateConv($cDate,$cText)
		{
			$vDate=explode($cText,$cDate);
			return @$vDate[2]."-".@$vDate[1]."-".@$vDate[0];
		}

		public function TableAngular($vTableName="",$Url="",$vContent=array(), $ParamPost="",$AddUrl="",$PToggle="",$IDPopUp="",$myModalTarget="myModal"){
			
			$data=$vContent;$th="";$td="";$i=0;
			$ParamPost=!empty($ParamPost)?",{".$ParamPost."}":"";
			foreach ($data as $v1) { 	
				IF(!empty($IDPopUp)){
					$PToggle="data-toggle='modal' ng-click='popup(".$vTableName."x.".$IDPopUp.")' data-target='#".$myModalTarget."' data-id='{{ ".$vTableName."x.".$IDPopUp." }}' class='open-AddBookDialog'  ng-click='ID_KAT_PELANGGAN=3'";
				}
				$cek = strpos($data[$i][1], "number");
				$TextAlign=$cek>0?"align=right":"";
				$TextAlign2=$cek>0?"style='text-align:right'":"";
				$th.= "<th ".$TextAlign2.">".$data[$i][0]."</th>";
				$td.="<td ".$TextAlign." ".$PToggle.">{{ ".$vTableName."x.".$data[$i][1]." }}</td>";
				$i++;
			}
			//// Add Td
			$tdReplace=str_replace(" }}</td>","Add }}</td>",$td);
			$tdAdd=!empty($AddUrl)?"<tr ng-repeat='".$vTableName."TdAddx in ".$vTableName."TdAddnames'>{$tdReplace}</tr>":"";
			/////////////////////////////
			$TableData0="
				<table class='table table-bordered  table-hover'>
				<tr >{$th}</tr>
				<tr ng-repeat={+}".$vTableName."x in ".$vTableName."names{+}>{$td}</tr>
				".$tdAdd."
				</table>			
			";
			$TableData[0]=str_replace("{+}",'"',$TableData0);
			
			////////////// add Control
			$PostAdd="";
			if(!empty($AddUrl)){
				$PostAdd="
					{|}http.post('".base_url($AddUrl)."' ".$ParamPost.")
					.success(function (response) {
						{|}scope.".$vTableName."TdAddnames = response.records;}
					);	
				";
			}
			/////////////////////////////////////////
			$TableData[1]="
				{|}http.post('".base_url($Url)."' ".$ParamPost.")
				.success(function (response) {
					{|}scope.".$vTableName."names = response.records;}
				);	
				".$PostAdd."
			";


			return $TableData;
		}

		public function CtrlAngular($RequastData=array()){
			$i=1;$FuncCtrl="";$ContentCtrl="";
			foreach ($RequastData as $v1){ $ContentCtrl.=$RequastData[$i-1]; $i++; }
			if(!empty($ContentCtrl)){$FuncCtrl="{|}scope.search = function() {".$ContentCtrl."}";}
			if(!empty($ContentCtrl)){$FuncCtrl2="{|}scope.popup = function(e) {{|}scope.ID_KAT_PELANGGAN=e;{|}scope.search();}";}

			$StartSistemYear=2013;$YearNow=date('Y');$MonthNow=date('M');
			$ListThn="'".$StartSistemYear."'";
			while($YearNow>=$StartSistemYear){
				$StartSistemYear++;
				$ListThn.=",'".$StartSistemYear."'";
				
			}

			$Table="
				<script>
				
				function Ctrl({|}scope, {|}http) {
					".$FuncCtrl."
					".$FuncCtrl2."
					
					 {|}scope.ArrViewData = ['As Of Today', 'Cut - Off [ Mid Of Month ]', 'Cut - Off [ End of Month ]']
					 {|}scope.ViewData = 'As Of Today';
					 {|}scope.ArrSort = ['DELIVERED', 'RECEIVED', 'REJECTION', 'PENDING', 'DEVIATION']
					 {|}scope.ArrSortWs = ['REJECTION', 'DEVIATION']
					 {|}scope.ArrSortSv = ['DELIVERED', 'RECEIVED', 'REJECTION', 'PENDING', 'DEVIATION']
					 {|}scope.ArrWsSortDep = ['REJECTION', 'DEVIATION']
					 {|}scope.vSortValCustWS = 'REJECTION';
					 {|}scope.vSortValCust = 'DELIVERED';
					 {|}scope.vSortTonCust = 'ORDER';
					 {|}scope.vSortValDepWs = 'REJECTION';
					 {|}scope.vSortTon = 'ORDER';
					 {|}scope.vSortVal = 'DELIVERED';
					 {|}scope.ArrLimit = ['10', '20', '30', '40', '60']
					 {|}scope.vLimitVal = '30';
					 {|}scope.vLimitTon = '30';
					 {|}scope.ArrFilter = ['Monthly', 'Quarter', 'Yearly']
					 {|}scope.vFilter = 'Monthly';
					 {|}scope.selectFilterChange = function() {
						switch({|}scope.vFilter) {
						  case 'Monthly': 
							{|}scope.vSubFilter = '".$MonthNow."';
							{|}scope.vSubSubFilter = '".$YearNow."';
							{|}scope.ArrSubFilter = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Des']
						  break;
					  
						  case 'Quarter': 
							{|}scope.vSubFilter = 'Q1';
							{|}scope.vSubSubFilter = '".$YearNow."';
						    {|}scope.ArrSubFilter = ['Q1','Q2','Q3','Q4']
						  break;
						  case 'Yearly': 
							{|}scope.vSubFilter = '".$YearNow."';	
							{|}scope.vSubSubFilter = '	';
						    {|}scope.ArrSubFilter = [".$ListThn."]
						  break;
						}
					  }
					 {|}scope.selectFilterChange();
				};			
				Ctrl.{|}inject = ['{|}scope','{|}http'];
				angular.module('myApp', []).controller('Ctrl', Ctrl)
				</script>				
			";

			return str_replace("{|}","$",$Table);
		}

		public function tabBootstrap($vCol=6,$vTitle="",$vContent=array()){
			$tab=$vContent;
			$li="";$IsiTab="";
			$jml=count($tab)-1;
			$i=$jml;
			$idtitle=str_replace(" ","",strtolower($vTitle));
			foreach ($tab as $v1) { 
				$vurl=$idtitle.str_replace(" ","_",$tab[$i][0]);
				$LiDefault=$i==0?"class='active'":"";
				$DivDefault=$i==0?" active":"";
				$li.= "<li ".$LiDefault."><a href='#".$vurl."' data-toggle='tab'>".$tab[$i][0]."</a></li>";
				$IsiTab.="<div role='tabpanel' class='tab-pane".$DivDefault."' id='".$vurl."'>".$tab[$i][1]."</div>";
				$i--;
			}
			
			$TextTab="
				<div class='col-lg-".$vCol."'>
					<div class='box box-success'>			
						<div class='nav-tabs-custom' style='padding-top:10px;'>			
							<ul class='nav nav-tabs pull-right' role='tablist' id='myTab'>					 
							  ".$li."
							  <li class='pull-left header'>".$vTitle."</li>
							</ul>
							<div class='tab-content'>					  
							  ".$IsiTab."
							</div>
						</div>		
					</div>			
				</div>
			";
			return $TextTab;
		}

		function get_client_ip() {
			$ipaddress = '';
			if (isset($_SERVER['HTTP_CLIENT_IP']))
				$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
			else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
				$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_X_FORWARDED']))
				$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
			else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
				$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_FORWARDED']))
				$ipaddress = $_SERVER['HTTP_FORWARDED'];
			else if(isset($_SERVER['REMOTE_ADDR']))
				$ipaddress = $_SERVER['REMOTE_ADDR'];
			else
				$ipaddress = 'UNKNOWN';
			return $ipaddress;
		}
	}



?>