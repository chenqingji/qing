<?php

/**
 * Description of MailAliasService
 * 
 * @author Administrator
 */
class MailAliasService extends ActionService {
	
	/**
	 * 获取邮箱别名
	 *
	 * @param $mailAlias type       	
	 * @return type
	 */
	public function getMailboxAliasByAliasName($mailAlias) {
		$cr = new CDbCriteria ();
		$cr->compare ( 'type', MailAlias::TYPE_MAILBOX_ALIAS );
		$cr->compare ( 'address', $mailAlias );
		return MailAlias::model ()->find ( $cr );
	}
	
	/**
	 * 验证别名是否存在
	 *
	 * @param $alias string
	 *       	 待验证别名
	 * @param $domain string       	
	 */
	public function checkMailAliasExist($alias, $domain = "") {
		$str = " (address = '@$alias' or goto ='@$domain' ) and type='" . MailAlias::TYPE_DOMAIN_ALIAS . "' ";
		if ($domain) {
			$str .= " and goto != '@$domain' ";
		}
		return MailAlias::model ()->find ( $str );
	}
	
	/**
	 * 验证邮箱是否已被使用,包括邮件别名和邮件列表
	 *
	 * @param $username string       	
	 */
	public function checkMailboxUsername($username) {
		return MailAlias::model ()->find ( "address ='$username'" );
	}
	
	/**
	 * 　获取域别名
	 *
	 * @param $domainAlias type       	
	 * @return MailAlias
	 */
	public function getDomainAliasByAliasName($domainAlias) {
		$cr = new CDbCriteria ();
		$cr->compare ( 'type', MailAlias::TYPE_DOMAIN_ALIAS );
		$cr->compare ( 'address', $domainAlias );
		return MailAlias::model ()->find ( $cr );
	}
	
	/**
	 * 根据邮局的列表名信息
	 */
	public function getAddressListInfosByPoId($po_id) {
		$str = " type=" . MailAlias::TYPE_MAIL_LIST . " and goto is NULL and po_id=" . $po_id . " order by address asc ";
		return MailAlias::model ()->findAll ( $str );
	}
	
	/**
	 * 根据邮箱地址查询邮箱列表名信息
	 *
	 * @param $mailboxUr string       	
	 * @return MailAlias
	 */
	public function getAddressListInfoByMailboxUrl($mailboxUr) {
		return MailAlias::model ()->find ( "address= :address and type = " . MailAlias::TYPE_MAIL_LIST, array (":address" => $mailboxUr ) );
	}
	
	/**
	 * 根据ids获取邮件列表信息
	 *
	 * @param $ids String       	
	 * @return array
	 */
	public function getMailListInfoByIds($ids) {
		return MailAlias::model ()->findAll ( "id in ($ids) " );
	}
	
	/**
	 * 根据邮箱id查询邮箱所处列表Id
	 *
	 * @param $mbId int       	
	 * @return array
	 */
	public function findMailListIdsByMbId($mbId) {
		$connect = ConnectionFactory::getConnection ( "db" );
		$sql = "SELECT id FROM postfix.mail_alias where  type=" . MailAlias::TYPE_MAIL_LIST . " and goto is null and address in (select address from postfix.mail_alias where mb_id =$mbId and type=" . MailAlias::TYPE_MAIL_LIST_DETAIL . " )";
		$ids = array ();
		$result = $connect->createCommand ( $sql )->queryAll ();
		foreach ( $result as $r ) {
			$ids [] = $r ["id"];
		}
		return $ids;
	}
	
	/**
	 * 根据邮箱id查询邮箱所处列表
	 *
	 * @param $mbId int       	
	 * @return array
	 */
	public function findMailListByMbId($mbId) {
		$connect = ConnectionFactory::getConnection ( "db" );
		$sql = "SELECT * FROM postfix.mail_alias where  type=" . MailAlias::TYPE_MAIL_LIST . " and goto is null and address in (select address from postfix.mail_alias where mb_id =$mbId and type=" . MailAlias::TYPE_MAIL_LIST_DETAIL . " )";
		return $connect->createCommand ( $sql )->queryAll ();
	}
	
	/**
	 * 根据邮箱id删除邮箱所处列表
	 *
	 * @param $mbId int       	
	 */
	public function deleteMailListByMbId($mbId) {
		MailAlias::model ()->deleteAll ( "mb_id =$mbId and type=" . MailAlias::TYPE_MAIL_LIST_DETAIL );
	}
	
	/**
	 * 根据邮箱id查询邮箱所处列表
	 *
	 * @param $mbId int       	
	 */
	public function findMailboxListByMbId($mbId) {
		return MailAlias::model ()->findAll ( "mb_id =$mbId and type=" . MailAlias::TYPE_MAIL_LIST_DETAIL );
	}
	
	/**
	 * 根据邮局名称获取邮局别名
	 *
	 * @param $domainName string
	 *       	 邮局名
	 */
	public function findMailAliasesByDomainName($domainName) {
		$cr = new CDbCriteria ();
		$cr->compare ( 'type', MailAlias::TYPE_DOMAIN_ALIAS );
		$cr->compare ( 'goto', '@' . $domainName );
		return MailAlias::model ()->findAll ( $cr );
	}
	
	/**
	 * 获取邮箱别名 真实邮箱地址
	 *
	 * @param $mailAlias type       	
	 * @return type
	 */
	public function getMailboxByAlias($mailAlias) {
		$mailbox = '';
		$aliasModel = $this->getMailboxAliasByAliasName ( $mailAlias );
		if ($aliasModel) {
			$mailbox = $aliasModel->goto;
		} else {
			$domainAlias = strstr ( $mailAlias, '@' );
			$aliasModel = $this->getDomainAliasByAliasName ( $domainAlias );
			if ($aliasModel) {
				$mailbox = str_replace ( $domainAlias, $aliasModel->goto, $mailAlias );
			} else {
				$mailbox = $mailAlias;
			}
		}
		return $mailbox;
	}
	
	/**
	 * 获取邮箱真正邮箱地址
	 *
	 * @param $mailAlias string       	
	 * @return string
	 */
	public function getRealMailboxUrl($mailAlias) {
		$aliasModel = $this->getMailboxAliasByAliasName ( $mailAlias );
		if ($aliasModel) {
			return $aliasModel->goto;
		}
		
		$info = explode ( "@", $mailAlias );
		$mailboxName = $info [0];
		$aliasDomainUrl = $info [1];
		
		$domainUrl = ServiceFactory::getDomainService ()->getRealDomainName ( $aliasDomainUrl );
		if ($domainUrl == false) {
			return false;
		}
		
		$aliasModel = $this->getMailboxAliasByAliasName ( $mailboxName . "@" . $domainUrl );
		if ($aliasModel) {
			return $aliasModel->goto;
		}
		
		$mailbox = ServiceFactory::getMailboxService ()->getMailboxByMailboxUrl ( $mailboxName . "@" . $domainUrl );
		if ($mailbox) {
			return $mailbox->username;
		}
		
		return false;
	}
	
	/**
	 * 删除邮局别名
	 */
	public function deleteMailAliasByPoId($po_id) {
		MailAlias::model ()->deleteAll ( "po_id = {$po_id}" );
	}
	
	/**
	 * 通过邮箱对象删除别名
	 *
	 * @param $mailbox Mailbox       	
	 */
	public function deleteMailAliasByMailbox($mailbox) {
		MailAlias::model ()->deleteAll ( "goto='{$mailbox->username}'" );
	}
	
	/**
	 * 根据邮箱id删除邮箱相关别名
	 *
	 * @param $mbId int       	
	 */
	public function deleteMailAliasByMbId($mbId) {
		MailAlias::model ()->deleteAll ( "mb_id = $mbId" );
	}
	
	/**
	 * 根据邮局名删除邮局别名
	 *
	 * @param $domain string       	
	 */
	public function deleteDomainAliasByDomain($domain) {
		MailAlias::model ()->deleteAll ( "goto='@{$domain}' and type = " . MailAlias::TYPE_DOMAIN_ALIAS );
	}
	
	/**
	 * 增加别名
	 *
	 * @param $mailAlias MailAlias       	
	 */
	public function saveMailAlias($mailAlias) {
		$mailAlias->save ();
	}
	
	/**
	 * 批量增加别名
	 *
	 * @param $mailAliases array       	
	 */
	public function saveMailAliases($mailAliases) {
		foreach ( $mailAliases as $mailAlias ) {
			$this->saveMailAlias ( $mailAlias );
		}
	}
	
	/**
	 * 删除邮箱的授权列表
	 *
	 * @param $mailbox Mailbox       	
	 */
	public function deleteMailboxInfoInRange($mailbox) {
		$mailaliases = MailAlias::model ()->findAll ( "po_id={$mailbox->po_id} and mb_id=0" );
		foreach ( $mailaliases as $mailalias ) {
			if (strpos ( $mailalias->range, $mailbox->username )) {
				$mailalias->range = str_replace ( ",{$mailbox->username},", ",", $mailalias->range );
				$mailalias->save ();
			}
		}
	}
	
	/**
	 * 通过域别名获取真实的域名
	 *
	 * @param $domainAliasName string       	
	 * @return string
	 */
	public function getDomainNameByAlias($domainAliasName) {
		$domainAlias = $this->getDomainAliasByAliasName ( "@" . $domainAliasName );
		if ($domainAlias) {
			$goTodomain = explode ( "@", $domainAlias->goto );
			return $goTodomain [1];
		} else {
			return "";
		}
	}
	
	/**
	 * 更换表中类型为域别名记录的主域名
	 *
	 * @param $oldDomainName type       	
	 * @param $newDomainName type       	
	 * @param $oldDomainId type       	
	 */
	public function replaceDomainNameWithDomainAlias($oldDomainName, $newDomainName, $oldDomainId) {
		$db = ConnectionFactory::getConnection ( 'db' );
		$sql = "update postfix.mail_alias set goto=REPLACE(goto,'@" . $oldDomainName . "','@" . $newDomainName . "') where type = " . MailAlias::TYPE_DOMAIN_ALIAS . " and po_id='" . $oldDomainId . "'";
		$db->createCommand ( $sql )->execute ();
	}
	/**
	 * 更换表中类型为邮箱别名、邮件列表记录的主域名
	 *
	 * @param $oldDomainName type       	
	 * @param $newDomainName type       	
	 * @param $oldDomainId type       	
	 */
	public function replaceDomainNameWithMailAlias($oldDomainName, $newDomainName, $oldDomainId) {
		$db = ConnectionFactory::getConnection ( 'db' );
		$sql = "update postfix.mail_alias set goto=REPLACE(goto,'@" . $oldDomainName . "','@" . $newDomainName . "'),
                address=REPLACE(address,'@" . $oldDomainName . "','@" . $newDomainName . "') where po_id=" . $oldDomainId . " and type <> " . MailAlias::TYPE_DOMAIN_ALIAS;
		$db->createCommand ( $sql )->execute ();
	}
	/**
	 * 更换表中相应邮局的主域名
	 *
	 * @param $oldDomainName type       	
	 * @param $newDomainName type       	
	 * @param $oldDomainId type       	
	 */
	public function replaceDomainName($oldDomainName, $newDomainName, $oldDomainId) {
		$this->replaceDomainNameWithDomainAlias ( $oldDomainName, $newDomainName, $oldDomainId );
		$this->replaceDomainNameWithMailAlias ( $oldDomainName, $newDomainName, $oldDomainId );
	}
}
