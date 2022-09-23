<?php
//connect database
$conn='';
ConnectDB();
function ConnectDB(){
	if(_DB_PORT_>0){$host=_DB_HOSTNAME_.':'._DB_PORT_;}else{$host=_DB_HOSTNAME_;}
	$conn = @mysql_connect($host,_DB_USERNAME_,_DB_PASSWORD_);
	
	if(!$conn)die('CANNOT CONNECT DATABASE<br>'.mysql_error());
	
	mysql_select_db(_DB_NAME_,$conn) or die ('CANNOT SELECT DATABASE<br>'.mysql_error());
	mysql_query('set names '.str_replace('-','',_DB_CHARSET_),$conn) or die('CANNOT SET NAMES DATABASE<br>'.mysql_error());
	
	$GLOBALS['conn'] = $conn;
}

function CloseDB(){
	global $conn;
	mysql_close($conn) or die('CANNOT DISCONNECT DATABASE<br>'.mysql_error());
}

//action database
class __webctrl {
	
	public $sql;
	public $debug = false;
	
	private $sql_select = '*';
	private $sql_from;
	private $sql_where;
	private $sql_group;
	private $sql_order;
	private $sql_limit;
	private $sql_page;
	private $total_num;
	
	function affected_rows(){
		return mysql_affected_rows();
	}
	
	function block_injection($str){
		$str = htmlspecialchars($str,ENT_QUOTES);
		$str = @mysql_real_escape_string($str);
		
		return stripslashes($str);
	}
	
	function chkQuote($str){
		if($str[0]=="'" && substr($str,-1)=="'"){
			return "'".$this->block_injection(substr($str,1,strlen($str)-2))."'";
		}else{
			return $this->block_injection($str);
		}
	}
	
	function del($tb,$w){
		$sql = "DELETE FROM ".$tb;
		
		if(is_array($w)){
			$num = count($w);
			$keys = array_keys($w);
			$sql .= " WHERE ";
			
			for($i=0;$i<$num;++$i){
				if($i>0){$sql .= ' AND ';}
				$sql .= $this->chkQuote($keys[$i]) . $this->chkQuote($w[$keys[$i]]);
			}
		}else{
			$sql .= " WHERE " . $w;
		}
		$this->sql = $sql;
		$this->query();
	}
	
	function from($c){
		$this->sql_from = $c;
		$this->genSQL();
	}
	
	function genSQL(){
		$sql = "SELECT ".$this->sql_select." FROM ".$this->sql_from;
		
		if($this->sql_where<>''){
			$sql .= " WHERE ".$this->sql_where;
		}
		
		if($this->sql_group<>''){
			$sql .= " GROUP BY ".$this->sql_group;
		}
		
		if($this->sql_order<>''){
			$sql .= " ORDER BY ".$this->sql_order;
		}
		
		if($this->sql_limit>0){
			if($this->sql_page>0){
				$start = ($this->sql_page-1) * $this->sql_limit;
				$sql .= " LIMIT $start,".$this->sql_limit;
			}else{
				$sql .= " LIMIT ".$this->sql_limit;
			}
		}
		
		$this->sql = $sql;
	}
	
	function group($c){
		$this->sql_group = $c;
		$this->genSQL();
	}
	
	function insert($tb,$a){
		if(is_array($a)){
			$num = count($a);
			$keys = array_keys($a);
			$insert = '';
			
			for($i=0;$i<$num;++$i){
				$insert[$keys[$i]] = $this->chkQuote($a[$keys[$i]]);
			}
			
			$this->sql = "INSERT INTO ".$tb."(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
			//echo $this->sql;
		}else{
			die('Error insert is not Array.');
		}
		
		$this->query();
	}
	
	function insertid(){
		return mysql_insert_id();
	}
	
	function limit($c){
		$this->sql_limit = $c;
		$this->genSQL();
	}
	
	function num(){
		$query = '';
		if(@$this->from<>''){
			$sql = "SELECT COUNT(*) FROM ".$this->sql_from;
		
			if($this->sql_where<>''){
				$sql .= " WHERE ".$this->sql_where;
			}
		
			if($this->sql_group<>''){
				$sql .= " GROUP BY ".$this->sql_group;
			}
			
			if($this->sql_order<>''){
				$sql .= " ORDER BY ".$this->sql_order;
			}
			
			$query = $this->query($sql);
			$row = $this->row($query);
			
			$this->total_num = $row[0][0];
			
			$num = $row[0][0];
		}else{
			$query = @$this->query(reset(explode('LIMIT',$this->sql)));
			$num = $this->numrows($query);
			$this->total_num = $num;
		}
		
		return $num;
	}
	
	function numinpage(){
		$query = $this->query();
		return $this->numrows($query);
	}
	
	function numrows($query){
		return mysql_num_rows($query);
	}
	
	function order($c){
		$this->sql_order = $c;
		$this->genSQL();
	}
	
	function page($c){
		$this->sql_page = $c;
		$this->genSQL();
	}
	
	function query($sql=''){
		if($sql==''){$sql = $this->sql;}
		
		if($this->debug){
			$dbq = mysql_query($sql) or die('<p>'.$sql.'</p>'.mysql_error());
		}else{
			$dbq = mysql_query($sql);
		}
		
		return $dbq;
	}
	
	function row($query=''){
		if($query==''){
			$query = $this->query();
		}
		while($row=mysql_fetch_array($query)){
			$return[] = $row;
		}
		
		return @$return;
	}
	
	function select($c='*'){
		if(is_array($c)){
			$num = count($c);
			$keys = array_keys($c);
			$sql = '';
			
			for($i=0;$i<$num;++$i){
				if($i>0){$sql.=',';}
				
				if(is_string($keys[$i])){
					$sql .= $keys[$i].' AS '.$c[$keys[$i]];
				}else{
					$sql .= $c[$i];
				}
			}
			
			$this->sql_select = $sql;
		}else{
			$this->sql_select = $c;
		}
		
		$this->genSQL();
	}
	
	function sql($s,$limit='',$page='1'){
		$sql = $s;
		
		if($limit>0){
			$this->sql_limit = $limit;
		
			if($page>0){
				$this->sql_page = $page;
				$start = ($page-1) * $limit;
				$sql .= " LIMIT $start,$limit";
			}else{
				$sql .= " LIMIT $limit";
			}
		}
		$this->sql = $sql;
	}
	
	function totalpage(){
		if($this->sql_limit>0){
			if($this->total_num>0){
				return ceil($this->total_num/$this->sql_limit);
			}else{
				return ceil($this->num()/$this->sql_limit);
			}
		}else{
			return 1;
		}
	}
	
	function update($tb,$arrU,$arrW,$q=true){ //$q = false; no chkQuote
		$numu = count($arrU);
		$numw = count($arrW);
		$keysu = array_keys($arrU);
		$keysw = array_keys($arrW);
		
		$sql = "UPDATE $tb SET ";
		for($i=0;$i<$numu;++$i){
			if($i>0){$sql .= ',';}
			
			if(!$q){
				$sql .= $keysu[$i].'='.$arrU[$keysu[$i]];
			}else{
				$sql .= $this->chkQuote($keysu[$i]).'='.$this->chkQuote($arrU[$keysu[$i]]);
			}
		}
		
		$sql .= ' WHERE ';
		
		for($i=0;$i<$numw;++$i){
			if($i>0){$sql .= ' AND ';}
			
			if(!$q){
				$sql .= $keysw[$i] . $arrW[$keysw[$i]];
			}else{
				$sql .= $this->chkQuote($keysw[$i]) . $this->chkQuote($arrW[$keysw[$i]]);
			}
		}
		$this->sql = $sql;
		$this->query();
	}
	
	function where($c){
		if(is_array($c)){
			$num = count($c);
			$keys = array_keys($c);
			$where = '';
			
			for($i=0;$i<$num;++$i){
				if($i>0){$where.=' AND ';}
				$where .= $keys[$i] . $this->chkQuote($c[$keys[$i]]);
			}
			
			$this->sql_where = $where;
		}else{
			$this->sql_where = $c;
		}
		
		$this->genSQL();
	}
	
}
?>