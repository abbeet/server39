<?php	
	function xhead($where_clause="",$sort_by="") {
		$sql = sql_select("xhead",$where_clause,$sort_by);
		return mysql_query($sql);
	}
	
	function xlevel($where_clause="",$sort_by="") {
		$sql = sql_select("xlevel",$where_clause,$sort_by);
		return mysql_query($sql);
	}
	
	function xmenu($where_clause="",$sort_by="") {
		$sql = sql_select("xmenu",$where_clause,$sort_by); #echo $sql;
		return mysql_query($sql);
	}
	
	function xmodul($where_clause="",$sort_by="") {
		$sql = sql_select("xmodul",$where_clause,$sort_by);
		return mysql_query($sql);
	}
	
	function xuser($where_clause="",$sort_by="") {
		$sql = sql_select("xuser",$where_clause,$sort_by);
		return mysql_query($sql);
	}
	
	function xconfig($where_clause="",$sort_by="") {
		$sql = sql_select("xconfig",$where_clause,$sort_by);
		return mysql_query($sql);
	}
	
	function tb_satker($where_clause="",$sort_by="kdsatker") {
		$sql = sql_select("tb_satker",$where_clause,$sort_by);
		return mysql_query($sql);
	}

	function tb_unitkerja($where_clause="",$sort_by="") {
		$sql = sql_select("tb_unitkerja",$where_clause,$sort_by);
		return mysql_query($sql);
	}

	function tb_program($where_clause="",$sort_by="") {
		$sql = sql_select("tb_program",$where_clause,$sort_by);
		return mysql_query($sql);
	}

	function tb_giat($where_clause="",$sort_by="") {
		$sql = sql_select("tb_giat",$where_clause,$sort_by);
		return mysql_query($sql);
	}

	function sinonim($where_clause="",$sort_by="") {
		$sql = sql_select("sinonim_kata",$where_clause,$sort_by);
		return mysql_query($sql);
	}

	function is_published($name) {
		$rs = xmodul("name='".$name."'");
		$xmodul = mysql_fetch_object($rs);
		if ($xmodul->published == 1) return true;
		else return false;
	}
	
	function xmenu_id($id) {
		$rs = xmenu("id='".$id."'");
		return mysql_fetch_object($rs);
	}
	
	function xmenu_type($type,$parent) {
		return xmenu("published='1' AND level LIKE '%".$_SESSION['xlevel']."%' AND type ".$type." AND parent = '".$parent."'","ordering");
	}
	
	function xmenu_list($parent=0) {
		return xmenu("level LIKE '%".$_SESSION['xlevel']."%' AND parent = ".$parent,"parent, ordering, id");
	}
	
	function xlevel_list() {
		return xlevel("id >= '".$_SESSION['xlevel']."'","id");
	}
	
	function xuser_list() {
		return xuser("level >= '".$_SESSION['xlevel']."' OR username='".$_SESSION['xuser']."'","username");
	}
	
	function xhead_list() {
		return xhead("","type,src");
	}
	
	function xmodul_list() {
		return xmodul("","id");
	}
	
	function xconfig_list() {
		return xconfig("","id");
	}
	
	function tb_satker_list($where) 
	{
		return tb_satker($where, "");
	}

	function tb_unitkerja_list($where) 
	{
		return kata_dasar($where, "kode_unit_kerja");
	}

	function trans_id_en_list($where) 
	{
		return trans_id_en($where, "kata");
	}

	function sinonim_list($where) 
	{
		return sinonim($where, "kata");
	}

	function document_list() {
		return document("","kd_doc");
	}

	function check_login($username,$password,$level="") {
		$where_clause = "username='".$username."' AND password='".$password."'";
		if ($level != "") $where_clause .= " AND level LIKE '%".$level."%'";
		$sql = sql_select("xuser",$where_clause);
		return $sql;
	}
	
	function update_lastvisit($userid) {
		$field = array("id","lastvisit");
		$value = array($userid,now());
		$sql = sql_update("xuser",$field,$value);
		return mysql_query($sql);
	}
	
	function update_log($desc,$type,$is_success){
		$sql = str_replace("'", "\'", $desc);
		$value = array('',now(),$sql,$type,$_SESSION['xusername'],$_SERVER['REMOTE_ADDR'],$is_success);
		$log = sql_insert("xlog","",$value);
		return mysql_query($log);
	}
	
	function get_field($table) {
		switch ($table) {
			case "xmenu": $field = array("id","name","title","type","parent","published","level","action","src","ordering","lastmodified","modifiedby"); break;
			case "xlevel": $field = array("id","name","lastmodified","modifiedby"); break;
			case "xuser": $field = array("id","username","password","level","lastvisit","lastmodified","modifiedby"); break;
			case "xuser_update": $field = array("id","username","password","level","lastmodified","modifiedby"); break;
			case "xhead": $field = array("id","type","src","lastmodified","modifiedby"); break;
			case "xmodul": $field = array("id","name","published","lastmodified","modifiedby"); break;
			case "xconfig": $field = array("id","name","content","lastmodified","modifiedby"); break;
			case "tb_satker": $field = array("id","kdsatker","nmsatker"); break;
			case "tb_unitkerja": $field = array("id","kode_unit_kerja","kdunit","nama_unit_kerja","ket_unit_kerja"); break;
			case "tb_program": $field = array("id","kddept","kdunit","kdprogram","nmprogram","outcome"); break;
			case "tb_giat": $field = array("id","kdgiat","nmgiat","kddept","kdunit","kdprogram"); break;
			case "tb_output": $field = array("id","kdoutput","nmoutput","kdgiat"); break;
			case "tb_subprogram": $field = array("id","kdsubprogram","nmsubprogram","outcome","kddept","kdunit","kdprogram"); break;
			case "tb_satuan_output": $field = array("id","kdsatuan","nmsatuan"); break;
		}
		return $field;
	}
		
	function get_value($table,$field,$id) {
		$sql = sql_select($table,$id);
		$rs = mysql_query($sql);
		$object = mysql_fetch_object($rs);
		
		foreach ($field as $k=>$val) {
			$value[$k] = $object->$val;
		}
		
		return $value;
	}
	
	function get_edit_link($p) {
		$xmenu = xmenu_id($p);
		$type = $xmenu->type;
		
		if ($type == "sub") {
			$parent = $xmenu->parent;
		}
		else {
			$parent = $p;
		}
		
		$rs = xmenu("parent='".$parent."' AND action='ed'");
		$link = mysql_fetch_object($rs);
		return $link->id;
	}
	
	function get_delete_link($p) {
		$xmenu = xmenu_id($p);
		$type = $xmenu->type;
		
		if ($type == "sub") {
			$parent = $xmenu->parent;
		}
		else {
			$parent = $p;
		}
		
		$rs = xmenu("parent='".$parent."' AND action='del'");
		$link = mysql_fetch_object($rs);
		return $link->id;
	}
	
	function get_title() {
		$rs = xconfig("name='title'");
		$xconfig = mysql_fetch_object($rs);
		return $xconfig->content;
	}
	
	function get_version() {
		$rs = xconfig("name='version'");
		$xconfig = mysql_fetch_object($rs);
		return $xconfig->content;
	}
	
	function get_copyright() {
		$rs = xconfig("name='copyright'");
		$xconfig = mysql_fetch_object($rs);
		return $xconfig->content;
	}
	
	function get_list_link($p) {
		$xmenu = xmenu_id($p);
		$type = $xmenu->type;
		
		if ($type == "sub") {
			$parent = $xmenu->parent;
		}
		else {
			$parent = $p;
		}
		
		$rs = xmenu("parent='".$parent."' AND action='ls'");
		$link = mysql_fetch_object($rs);
		return $link->id;
	}
	
// DOC TO TEXT
	
	function parseWord($userDoc) {
		$fileHandle = fopen($userDoc, "r");
		$line = @fread($fileHandle, filesize($userDoc));
		$lines = explode(chr(0x0D),$line);
		$outtext = "";
		$i = 0;
		foreach($lines as $thisline) {
			$pos = strrpos($thisline, chr(0x00));
			
			if (($pos !== FALSE)||(strlen($thisline) == 0))
			{
				if ($i == 0)
				{
					$len = strlen($thisline);
					$cleantext = substr($thisline,$pos+1,$len-$pos);
					$cleantext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/"," ",$cleantext);
					$outtext .= $cleantext." ";
					if ($cleantext != ' ') $i++;
				}
			}
			else
			{
				$outtext .= $thisline." ";
			}
		}
		
		$outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/"," ",$outtext);
		return $outtext;
	}
	
// PDF to TEXT

function decodeAsciiHex($input) {
    $output = "";

    $isOdd = true;
    $isComment = false;

    for($i = 0, $codeHigh = -1; $i < strlen($input) && $input[$i] != '>'; $i++) {
        $c = $input[$i];

        if($isComment) {
            if ($c == '\r' || $c == '\n')
                $isComment = false;
            continue;
        }

        switch($c) {
            case '\0': case '\t': case '\r': case '\f': case '\n': case ' ': break;
            case '%': 
                $isComment = true;
            break;

            default:
                $code = hexdec($c);
                if($code === 0 && $c != '0')
                    return "";

                if($isOdd)
                    $codeHigh = $code;
                else
                    $output .= chr($codeHigh * 16 + $code);

                $isOdd = !$isOdd;
            break;
        }
    }

    if($input[$i] != '>')
        return "";

    if($isOdd)
        $output .= chr($codeHigh * 16);

    return $output;
}
function decodeAscii85($input) {
    $output = "";

    $isComment = false;
    $ords = array();
    
    for($i = 0, $state = 0; $i < strlen($input) && $input[$i] != '~'; $i++) {
        $c = $input[$i];

        if($isComment) {
            if ($c == '\r' || $c == '\n')
                $isComment = false;
            continue;
        }

        if ($c == '\0' || $c == '\t' || $c == '\r' || $c == '\f' || $c == '\n' || $c == ' ')
            continue;
        if ($c == '%') {
            $isComment = true;
            continue;
        }
        if ($c == 'z' && $state === 0) {
            $output .= str_repeat(chr(0), 4);
            continue;
        }
        if ($c < '!' || $c > 'u')
            return "";

        $code = ord($input[$i]) & 0xff;
        $ords[$state++] = $code - ord('!');

        if ($state == 5) {
            $state = 0;
            for ($sum = 0, $j = 0; $j < 5; $j++)
                $sum = $sum * 85 + $ords[$j];
            for ($j = 3; $j >= 0; $j--)
                $output .= chr($sum >> ($j * 8));
        }
    }
    if ($state === 1)
        return "";
    elseif ($state > 1) {
        for ($i = 0, $sum = 0; $i < $state; $i++)
            $sum += ($ords[$i] + ($i == $state - 1)) * pow(85, 4 - $i);
        for ($i = 0; $i < $state - 1; $i++)
            $ouput .= chr($sum >> ((3 - $i) * 8));
    }

    return $output;
}
function decodeFlate($input) {
    return @gzuncompress($input);
}

function getObjectOptions($object) {
    $options = array();
    if (preg_match("#<<(.*)>>#ismU", $object, $options)) {
        $options = explode("/", $options[1]);
        @array_shift($options);

        $o = array();
        for ($j = 0; $j < @count($options); $j++) {
            $options[$j] = preg_replace("#\s+#", " ", trim($options[$j]));
            if (strpos($options[$j], " ") !== false) {
                $parts = explode(" ", $options[$j]);
                $o[$parts[0]] = $parts[1];
            } else
                $o[$options[$j]] = true;
        }
        $options = $o;
        unset($o);
    }

    return $options;
}
function getDecodedStream($stream, $options) {
    $data = "";
    if (empty($options["Filter"]))
        $data = $stream;
    else {
        $length = !empty($options["Length"]) ? $options["Length"] : strlen($stream);
        $_stream = substr($stream, 0, $length);

        foreach ($options as $key => $value) {
            if ($key == "ASCIIHexDecode")
                $_stream = decodeAsciiHex($_stream);
            if ($key == "ASCII85Decode")
                $_stream = decodeAscii85($_stream);
            if ($key == "FlateDecode")
                $_stream = decodeFlate($_stream);
        }
        $data = $_stream;
    }
    return $data;
}
function getDirtyTexts(&$texts, $textContainers) {
    for ($j = 0; $j < count($textContainers); $j++) {
        if (preg_match_all("#\[(.*)\]\s*TJ#ismU", $textContainers[$j], $parts))
            $texts = array_merge($texts, @$parts[1]);
        elseif(preg_match_all("#Td\s*(\(.*\))\s*Tj#ismU", $textContainers[$j], $parts))
            $texts = array_merge($texts, @$parts[1]);
    }
}
function getCharTransformations(&$transformations, $stream) {
    preg_match_all("#([0-9]+)\s+beginbfchar(.*)endbfchar#ismU", $stream, $chars, PREG_SET_ORDER);
    preg_match_all("#([0-9]+)\s+beginbfrange(.*)endbfrange#ismU", $stream, $ranges, PREG_SET_ORDER);

    for ($j = 0; $j < count($chars); $j++) {
        $count = $chars[$j][1];
        $current = explode("\n", trim($chars[$j][2]));
        for ($k = 0; $k < $count && $k < count($current); $k++) {
            if (preg_match("#<([0-9a-f]{2,4})>\s+<([0-9a-f]{4,512})>#is", trim($current[$k]), $map))
                $transformations[str_pad($map[1], 4, "0")] = $map[2];
        }
    }
    for ($j = 0; $j < count($ranges); $j++) {
        $count = $ranges[$j][1];
        $current = explode("\n", trim($ranges[$j][2]));
        for ($k = 0; $k < $count && $k < count($current); $k++) {
            if (preg_match("#<([0-9a-f]{4})>\s+<([0-9a-f]{4})>\s+<([0-9a-f]{4})>#is", trim($current[$k]), $map)) {
                $from = hexdec($map[1]);
                $to = hexdec($map[2]);
                $_from = hexdec($map[3]);

                for ($m = $from, $n = 0; $m <= $to; $m++, $n++)
                    $transformations[sprintf("%04X", $m)] = sprintf("%04X", $_from + $n);
            } elseif (preg_match("#<([0-9a-f]{4})>\s+<([0-9a-f]{4})>\s+\[(.*)\]#ismU", trim($current[$k]), $map)) {
                $from = hexdec($map[1]);
                $to = hexdec($map[2]);
                $parts = preg_split("#\s+#", trim($map[3]));
                
                for ($m = $from, $n = 0; $m <= $to && $n < count($parts); $m++, $n++)
                    $transformations[sprintf("%04X", $m)] = sprintf("%04X", hexdec($parts[$n]));
            }
        }
    }
}
function getTextUsingTransformations($texts, $transformations) {
    $document = "";
    for ($i = 0; $i < count($texts); $i++) {
        $isHex = false;
        $isPlain = false;

        $hex = "";
        $plain = "";
        for ($j = 0; $j < strlen($texts[$i]); $j++) {
            $c = $texts[$i][$j];
            switch($c) {
                case "<":
                    $hex = "";
                    $isHex = true;
                break;
                case ">":
                    $hexs = str_split($hex, 4);
                    for ($k = 0; $k < count($hexs); $k++) {
                        $chex = str_pad($hexs[$k], 4, "0");
                        if (isset($transformations[$chex]))
                            $chex = $transformations[$chex];
                        $document .= html_entity_decode("&#x".$chex.";");
                    }
                    $isHex = false;
                break;
                case "(":
                    $plain = "";
                    $isPlain = true;
                break;
                case ")":
                    $document .= $plain;
                    $isPlain = false;
                break;
                case "\\":
                    $c2 = $texts[$i][$j + 1];
                    if (in_array($c2, array("\\", "(", ")"))) $plain .= $c2;
                    elseif ($c2 == "n") $plain .= '\n';
                    elseif ($c2 == "r") $plain .= '\r';
                    elseif ($c2 == "t") $plain .= '\t';
                    elseif ($c2 == "b") $plain .= '\b';
                    elseif ($c2 == "f") $plain .= '\f';
                    elseif ($c2 >= '0' && $c2 <= '9') {
                        $oct = preg_replace("#[^0-9]#", "", substr($texts[$i], $j + 1, 3));
                        $j += strlen($oct) - 1;
                        $plain .= html_entity_decode("&#".octdec($oct).";");
                    }
                    $j++;
                break;

                default:
                    if ($isHex)
                        $hex .= $c;
                    if ($isPlain)
                        $plain .= $c;

                break;
            }
        }
        $document .= "\n";
    }

    return $document;
}

function pdf2text($filename) {
    $infile = @file_get_contents($filename, FILE_BINARY);
    if (empty($infile))
        return "";

    $transformations = array();
    $texts = array();

    preg_match_all("#obj(.*)endobj#ismU", $infile, $objects);
    $objects = @$objects[1];

    for ($i = 0; $i < count($objects); $i++) {
        $currentObject = $objects[$i];

        if (preg_match("#stream(.*)endstream#ismU", $currentObject, $stream)) {
            $stream = ltrim($stream[1]);

            $options = getObjectOptions($currentObject);
            if (!(empty($options["Length1"]) && empty($options["Type"]) && empty($options["Subtype"])))
                continue;

            $data = getDecodedStream($stream, $options); 
            if (strlen($data)) {
                if (preg_match_all("#BT(.*)ET#ismU", $data, $textContainers)) {
                    $textContainers = @$textContainers[1];
                    getDirtyTexts($texts, $textContainers);
                } else
                    getCharTransformations($transformations, $data);
            }
        }
    }

    return getTextUsingTransformations($texts, $transformations);
}

	function odt2text($filename) {
		return readZippedXML($filename, "content.xml");
	}
	
	function docx2text($filename) {
		return readZippedXML($filename, "word/document.xml");
	}
	
	function readZippedXML($archiveFile, $dataFile) {
		// Create new ZIP archive
		$zip = new ZipArchive;
	
		// Open received archive file
		if (true === $zip->open($archiveFile)) {
			// If done, search for the data file in the archive
			if (($index = $zip->locateName($dataFile)) !== false) {
				// If found, read it to the string
				$data = $zip->getFromIndex($index);
				// Close archive file
				$zip->close();
				// Load XML from a string
				// Skip errors and warnings
				$xml = DOMDocument::loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
				// Return data without XML formatting tags
				return strip_tags($xml->saveXML());
			}
			$zip->close();
		}
	
		// In case of failure return empty string
		return "";
	} 
	
?>