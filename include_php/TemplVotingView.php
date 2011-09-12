<?php
/**
 * Silurus Classifieds Builder
 * 
 * 
 * @author		SnowHall - http://snowhall.com
 * @website		http://snowhall.com/silurus
 * @email		support@snowhall.com
 * 
 * @version		1.0
 * @date		May 7, 2009
 * 
 * Silurus is a professionally developed PHP Classifieds script that was built for you.
 * Whether you are running classifieds for autos, motorcycles, bicycles, rv's, guns,
 * horses, or general merchandise, our product is the right package for you.
 * It has template system and no limit to usage with free for any changes.
 *
 * Copyright (c) 2009
 */

class DolMistake 
{

	var $_error;	

	function DolMistake()
	{
	}
	function log ()
	{
		
	}	
	function displayError ()
	{
		
	}
	
}

define('BX_DOL_TABLE_PROFILES', '`Profiles`');

class DolDb extends DolMistake
{
	var $host, $port, $socket, $dbname, $user, $password, $link;
	var $current_res, $current_arr_type;
	function DolDb()
	{
		
	}

	

	/**
	 * execute sql query and return one row result
	 */
	function getRow($query, $arr_type = MYSQL_ASSOC)
	{
		if(!$query)
			return array();
		
		$res = mysql_query($query);
		$arr_res = array();
		if($res && mysql_num_rows($res))
		{
			$arr_res = mysql_fetch_array($res);
			mysql_free_result($res);
		}
		return $arr_res;
	}


	function getOne($query)
	{
		if(!$query)
			return false;
		$res = mysql_query($query);
		$arr_res = array();
		if($res && mysql_num_rows($res))
			$arr_res = mysql_fetch_array($res);
		if(count($arr_res))
			return $arr_res[0];
		else
			return false;
	}

	/**
	 * execute sql query and return the first row of result
	 * and keep $array type and poiter to all data
	 */
	function getFirstRow($query, $arr_type = MYSQL_ASSOC)
	{
		if(!$query)
			return array();
		if($arr_type != MYSQL_ASSOC && $arr_type != MYSQL_NUM)
			$this->current_arr_type = MYSQL_ASSOC;
		else
			$this->current_arr_type = $arr_type;
		$this->current_res = mysql_query($query);
		$arr_res = array();
		if($this->current_res && mysql_num_rows($this->current_res))
			$arr_res = mysql_fetch_array($this->current_res);
		return $arr_res;
	}

	/**
	 * return next row of pointed last getFirstRow calling data
	 */
	function getNextRow()
	{
		$arr_res = mysql_fetch_array($this->current_res);
		if($arr_res)
			return $arr_res;
		else
		{
			mysql_free_result($this->current_res);
			$this->current_arr_type = MYSQL_ASSOC;
			return array();
		}
	}

	/**
	 * return number of affected rows in current mysql result
	 */
	function getNumRows($res = false)
	{
		if(!$res)
			$res = @mysql_num_rows($this->current_res);

		if((int)$res > 0)
			return (int)$res;
		else
			return 0;
	}


	/**
	 * execute any query return number of rows affected/false
	 */
	function query($query)
	{
		if(!$query)
			return false;
		$res = mysql_query($query);

		if($res)
			return mysql_affected_rows();
		else
			return false;
	}

	/**
	 * execute sql query and return table of records as result
	 */
	function getAll($query, $arr_type = MYSQL_ASSOC)
	{
		if(!$query)
			return array();
		if($arr_type != MYSQL_ASSOC && $arr_type != MYSQL_NUM)
			$arr_type = MYSQL_ASSOC;

		$res = mysql_query($query);
		$arr_res = array();
		if($res)
		{
			while($row = mysql_fetch_array($res, $arr_type))
			{
				$arr_res[] = $row;
			}
			mysql_free_result($res);
		}
		return $arr_res;
	}

	function error($text)
	{
		//$this->log($text.': '.mysql_error($this->link));
		//echoDbg( debug_backtrace() ); //output debug information
	}

}

class DolVotingQuery extends DolDb
{
	var $_aSystem; // current voting system

	function DolVotingQuery(&$aSystem)
	{
		$this->_aSystem = &$aSystem;
		parent::DolDb();
	}

	function  getVote ($iId)
    {
		$sPre = $this->_aSystem['row_prefix'];
		$sTable = $this->_aSystem['table_rating'];

		return $this->getRow("SELECT `{$sPre}rating_count` as `count`, (`{$sPre}rating_sum` / `{$sPre}rating_count`) AS `rate` FROM {$sTable} WHERE `{$sPre}id` = '$iId' LIMIT 1");
	}

	function  putVote ($iId, $sIp, $iRate)
	{
		$user = (int)$_SESSION['memberID'];
		$sPre = $this->_aSystem['row_prefix'];

		$sTable = $this->_aSystem['table_rating'];

		if ($this->getOne("SELECT `{$sPre}id` FROM $sTable WHERE `{$sPre}id` = '$iId' LIMIT 1"))
		{
			$ret = $this->query ("UPDATE {$sTable} 	SET `{$sPre}rating_count` = `{$sPre}rating_count` + 1, `{$sPre}rating_sum` = `{$sPre}rating_sum` + '$iRate' WHERE `{$sPre}id` = '$iId'");
		}
		else
		{
			$ret = $this->query ("INSERT INTO {$sTable} SET `{$sPre}id` = '$iId', `{$sPre}rating_count` = '1', `{$sPre}rating_sum` = '$iRate'");

		}
		if (!$ret) return $ret;

		$sTable = $this->_aSystem['table_track'];
		return $this->query ("INSERT INTO {$sTable} SET `{$sPre}user` = '$user',`{$sPre}rate` = '$iRate',`{$sPre}id` = '$iId', `{$sPre}ip` = '$sIp', `{$sPre}date` = NOW()");
	}

	function isDublicateVote ($iId, $sIp)
	{
		$sPre = $this->_aSystem['row_prefix'];
		$sTable = $this->_aSystem['table_track'];
		$iSec = $this->_aSystem['is_duplicate'];
	
		return $this->getOne ("SELECT `{$sPre}id` FROM {$sTable} WHERE `{$sPre}ip` = '$sIp' AND `{$sPre}id` = '$iId' AND UNIX_TIMESTAMP() - UNIX_TIMESTAMP(`{$sPre}date`) < $iSec");
		
    }

    function getSqlParts ($sMailTable, $sMailField)
    {
        if ($sMailTable) 
            $sMailTable .= '.';

        if ($sMailField)
            $sMailField = $sMailTable.$sMailField;

		$sPre = $this->_aSystem['row_prefix'];
        $sTable = $this->_aSystem['table_rating'];

        return array (
            'fields' => ",$sTable.`{$sPre}rating_count` as `voting_count`, ($sTable.`{$sPre}rating_sum` / $sTable.`{$sPre}rating_count`) AS `voting_rate` ",
            //'fields' => ",34 as `voting_count`, 2.5 AS `voting_rate` ",
            'join' => " LEFT JOIN $sTable ON ({$sTable}.`{$sPre}id` = $sMailField) "
        );
    }

    function deleteVotings ($iId)    
    {
        $sPre = $this->_aSystem['row_prefix'];        

        $sTable = $this->_aSystem['table_track'];        
        $this->query ("DELETE FROM {$sTable} WHERE `{$sPre}id` = '$iId'");

        $sTable = $this->_aSystem['table_rating'];        
        return $this->query ("DELETE FROM {$sTable} WHERE `{$sPre}id` = '$iId'");
    }

    function getTopVotedItem ($iDays, $sJoinTable = '', $sJoinField = '', $sWhere = '')
    {
        $sPre = $this->_aSystem['row_prefix'];
        $sTable = $this->_aSystem['table_track'];

        $sJoin = $sJoinTable && $sJoinField ? " INNER JOIN $sJoinTable ON ({$sJoinTable}.{$sJoinField} = $sTable.`{$sPre}id`) " : '';

        return $this->getOne ("SELECT $sTable.`{$sPre}id`, COUNT($sTable.`{$sPre}id`) AS `voting_count` FROM {$sTable} $sJoin WHERE TO_DAYS(NOW()) - TO_DAYS($sTable.`{$sPre}date`) <= $iDays $sWhere GROUP BY $sTable.`{$sPre}id` HAVING `voting_count` > 2 ORDER BY `voting_count` DESC LIMIT 1");
    }
}


class DolVoting extends DolMistake
{
	var $_iId = 0;	// item id to be rated
	var $_iCount = 0; // number of votes
	var $_fRate = 0; // average rate
    var $_sSystem = 'profile'; // current rating system name	

	var $_aSystem = array (); // current rating system array

	var $_aSystems = array (		// array of supported rate systems

		'voting' => array (
			'table_rating' => 'gvoting',			// table for ratings
			'table_track' => 'gvoting',	// table to track duplicate ratings
			'row_prefix' => 'pr_',						// table rows prefix
			'max_votes' => 5,							// max vote
			'post_name' => 'vote_send_result',						// post name where vote is stored
			'is_duplicate' => 86400,					// time in seconds to prevent duplicate votes, default - 1 day
			'is_on' => 1,								// is voting enabled or not
		),		    
	);

	var $_oQuery = null;
	
	function DolVoting( $sSystem, $iId, $iInit = 1)
	{
		$this->_sSystem = $sSystem;
        if (isset($this->_aSystems[$sSystem]))
            $this->_aSystem = $this->_aSystems[$sSystem];
        else
            return;

        $this->_oQuery = new DolVotingQuery($this->_aSystem);

		if ($iInit) 
			$this->init($iId);

		if (!$this->isEnabled()) return;

		$iVoteResult = $this->_getVoteResult ();
		if ($iVoteResult)
		{
			if (!$this->makeVote ($iVoteResult))
			{
				exit;
			}
			$this->initVotes ();			
			echo $this->getVoteRate() . ',' . $this->getVoteCount(); 
			exit;
		}
	}

	function init ($iId)
	{
		if (!$iId) 
			$iId = $this->_iId;

		if (!$this->isEnabled()) return;

		if (!$this->iId && $iId)
		{	
			$this->setId($iId);			
		}

	}

	function initVotes ()
	{
		if (!$this->isEnabled()) return;
		if (!$this->_oQuery) return;

		$a = $this->_oQuery->getVote ($this->getId());
		if (!$a) return;
		$this->_iCount = $a['count'];
		$this->_fRate = $a['rate'];
	}
	
	function makeVote ($iVote)
	{	
		if (!$this->isEnabled()) return false;
		if ($this->isDublicateVote()) return false;
		
		return $this->_oQuery->putVote ($this->getId(), $_SERVER['REMOTE_ADDR'], $iVote);
	}
	
	function isDublicateVote ()
	{
		if (!$this->isEnabled()) return false;
		return $this->_oQuery->isDublicateVote ($this->getId(), $_SERVER['REMOTE_ADDR']);
	}

	function getId ()
	{
		return $this->_iId;
	}

	function isEnabled ()
	{
		return $this->_aSystem['is_on'];
	}

	function getMaxVote()
	{
		return $this->_aSystem['max_votes'];
	}

	function getVoteCount()
	{
		return $this->_iCount;
	}

	function getVoteRate()
	{
		return $this->_fRate;
	}

	function getSystemName()
	{
		return $this->_sSystem;
	}

	/**
	 * set id to operate with votes
	 */
	function setId ($iId)
	{
		if ($iId == $this->getId()) return;
		$this->_iId = $iId;
		$this->initVotes();
	}

    function getSqlParts ($sMailTable, $sMailField)
    {
        if ($this->isEnabled())
            return $this->_oQuery->getSqlParts ($sMailTable, $sMailField);
        else
            return array();
    }


    function isValidSystem ($sSystem)
    {
        return isset($this->_aSystems[$sSystem]);
    }

    function deleteVotings ($iId)
    {        
        if (!(int)$iId) return false;
        $this->_oQuery->deleteVotings ($iId);
        return true;
    }

    function getTopVotedItem ($iDays, $sJoinTable = '', $sJoinField = '', $sWhere = '')
    {
        return $this->_oQuery->getTopVotedItem ($iDays, $sJoinTable, $sJoinField, $sWhere);
    }

	/** private functions
	*********************************************/


	function _getVoteResult ()
	{
        $iVote = (int)$_GET[$this->_aSystem['post_name']];
		if (!$iVote) return 0;

        if ($iVote > $this->getMaxVote()) $iVote = $this->getMaxVote();
        if ($iVote < 1) $iVote = 1;
		return $iVote;
	}

}



class BaseVotingView extends DolVoting
{
	var $_iSizeStarBig = 32;
	var $_iSizeStarSmall = 16;

	function BaseVotingView( $sSystem, $iId, $iInit = 1 )
	{
		DolVoting::DolVoting( $sSystem, $iId, $iInit );
	}
	
	function getSmallVoting ($iCanRate = 1,$text='',$id='')
	{
		return $this->getVoting($iCanRate, $this->_iSizeStarSmall, 'small',$text,$id);
	}

	function getBigVoting ($iCanRate = 1,$text='',$id='')
	{
		return $this->getVoting($iCanRate, $this->_iSizeStarBig, 'big',$text,$id);
	}

	function getVoting($iCanRate, $iSize, $sName,$text,$id='')
	{
		global $gConfig;

		$iMax = 5;
		$iWidth = $iSize*$iMax;
		$sSystemName = $this->getSystemName();
		$iObjId = $this->getId();
		$sDivId = $this->getSystemName() . $sName.$id;

		$sRet = '<div class="votes_'.$sName.'" id="' . $sDivId . '">';
		
		$sRet .= <<<EOF
<script language="javascript">
	var oVoting{$sDivId} = new DolVoting('{$gConfig[site_url]}', '{$sSystemName}', '{$iObjId}', '{$sDivId}', '{$sDivId}Slider', {$iSize}, {$iMax});
</script>
EOF;

		$sRet .= '<div class="votes_gray_'.$sName.'" style="width:'.$iWidth.'px;">';

		if ($iCanRate)
		{
			$sRet .= '<div class="votes_buttons">';
			for ($i=1 ; $i<=$iMax ; ++$i)
			{
				$sRet .= '<a href="javascript:'.$i.';void(0);" onmouseover="oVoting'.$sDivId.'.over('.$i.');" onmouseout="oVoting'.$sDivId.'.out();" onclick="oVoting'.$sDivId.'.vote('.$i.')"><img class="votes_button_'.$sName.'" src="/img/vote_star_null.gif" /></a>';
			}
			$sRet .= '</div>';
		}
		
		$sRet .= '<div id="'.$sDivId.'Slider" class="votes_active_'.$sName.'" style="width:'.round($this->getVoteRate()*$iWidth/$iMax).'px;"></div>';
		$sRet .= '</div>';
		//$sRet .= '<b>'.$this->getVoteCount(). ' ' . _t('_votes') . '</b>';
		$sRet .= '<b style="color:#355d9f">'.$text.'</b>';
		$sRet .= '<div class="clear_both"></div>';
		$sRet .= '</div>';

		return $sRet;
	}	
}



class TemplVotingView extends BaseVotingView
{
	function TemplVotingView( $sSystem, $iId, $iInit = 1 )
	{
		BaseVotingView::BaseVotingView( $sSystem, $iId, $iInit );
	}
}
?>
